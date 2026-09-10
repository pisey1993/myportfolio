import { fetchTechHeadline } from "./hacker-news";
import { findCoverImage } from "./images";

export type GeneratedPost = {
  title: string;
  excerpt: string | null;
  body: string;
  imageUrl: string | null;
};

const SCOPE =
  "AI companies (like OpenAI, Anthropic, Google, Meta), programming frameworks (like React, Vue, Laravel, Next.js, Django), frontend development, backend development, or databases";

function buildPrompt(headline: Awaited<ReturnType<typeof fetchTechHeadline>>): string {
  if (headline) {
    return `You are a tech blog writer for a software engineer's personal portfolio blog. This blog covers only: ${SCOPE}.

Here is a real, current story from Hacker News, a tech news aggregator, posted on ${headline.publishedAt}:
Headline: "${headline.title}"
Link: ${headline.url}

Write a blog post reacting to this real story from an engineer's perspective. Naturally mention that you came across this on Hacker News and reference the headline. Use what you already know about this topic to add context and opinion; if you don't know further specifics beyond the headline, focus on the broader implications rather than inventing details you're not sure of.

Respond with ONLY a raw JSON object (no markdown code fences, no extra text before or after) with exactly these keys:
- "title": an engaging blog post title (max 100 characters)
- "excerpt": a 1-2 sentence summary (max 200 characters)
- "body": the blog post body, 4-6 short paragraphs separated by blank lines, plain text (no markdown, no headings), written in first person as the blog author
- "image_query": 2-4 words describing a relevant photo to illustrate this story (e.g. "artificial intelligence robot")`;
  }

  return `You are a tech blog writer for a software engineer's personal portfolio blog. This blog covers only: ${SCOPE}.

Write about one genuinely notable, specific recent development strictly within that scope that you know of. Prefer your most recent knowledge.

Respond with ONLY a raw JSON object (no markdown code fences, no extra text before or after) with exactly these keys:
- "title": an engaging blog post title (max 100 characters)
- "excerpt": a 1-2 sentence summary (max 200 characters)
- "body": the blog post body, 4-6 short paragraphs separated by blank lines, plain text (no markdown, no headings), written in first person as the blog author
- "image_query": 2-4 words describing a relevant photo to illustrate this story (e.g. "artificial intelligence robot")`;
}

async function postGeminiWithRetry(url: string, payload: unknown): Promise<Response> {
  let lastResponse: Response | null = null;

  for (let attempt = 1; attempt <= 3; attempt++) {
    const response = await fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload),
    });

    if (response.ok || attempt === 3) return response;

    const bodyText = await response.clone().text();
    const retriable = response.status === 503 || bodyText.includes("high demand");
    if (!retriable) return response;

    lastResponse = response;
    await new Promise((resolve) => setTimeout(resolve, 800));
  }

  return lastResponse!;
}

function stripCodeFences(text: string): string {
  return text.trim().replace(/^```(?:json)?|```$/gm, "").trim();
}

function truncate(value: string, max: number): string {
  return value.length > max ? value.slice(0, max) : value;
}

/**
 * Generates a fully scoped, on-topic blog post: fetches a real Hacker News
 * headline (or falls back to a scoped general-knowledge prompt), asks Gemini
 * to write about it, then finds a matching cover image via a fallback chain.
 * Throws with a user-facing message on failure.
 */
export async function generatePostFromNews(): Promise<GeneratedPost> {
  const apiKey = process.env.GEMINI_API_KEY;
  const model = process.env.GEMINI_MODEL ?? "gemini-2.5-flash";

  if (!apiKey) {
    throw new Error("Gemini API key is not configured.");
  }

  const headline = await fetchTechHeadline();
  const prompt = buildPrompt(headline);
  const url = `https://generativelanguage.googleapis.com/v1beta/models/${model}:generateContent?key=${apiKey}`;
  const payload = { contents: [{ role: "user", parts: [{ text: prompt }] }] };

  let response: Response;
  try {
    response = await postGeminiWithRetry(url, payload);
  } catch {
    throw new Error("Could not reach Gemini.");
  }

  if (!response.ok) {
    const errorBody = await response.json().catch(() => null);
    const message = errorBody?.error?.message ?? "unknown error";
    throw new Error(`Gemini request failed: ${message}`);
  }

  const json = await response.json();
  const text: string = json?.candidates?.[0]?.content?.parts?.[0]?.text ?? "";
  const clean = stripCodeFences(text);

  let data: { title?: string; excerpt?: string; body?: string; image_query?: string };
  try {
    data = JSON.parse(clean);
  } catch {
    throw new Error("Gemini returned an unexpected response.");
  }

  if (!data.title || !data.body) {
    throw new Error("Gemini returned an unexpected response.");
  }

  const title = truncate(data.title, 255);
  const excerpt = data.excerpt ? truncate(data.excerpt, 255) : null;
  const imageUrl = await findCoverImage(data.image_query ?? title, title);

  return { title, excerpt, body: data.body, imageUrl };
}
