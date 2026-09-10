export type TechHeadline = {
  title: string;
  url: string;
  publishedAt: string;
};

type HnItem = {
  id: number;
  type?: string;
  title?: string;
  url?: string;
  time?: number;
};

// Scoped to exactly: AI companies/products, frameworks, frontend, backend, database.
// Keep this list in sync with the intent — don't widen it back to generic tech terms.
const TOPIC_KEYWORDS = [
  // AI companies / products
  "openai", "anthropic", "claude", "gemini", "chatgpt", "gpt-4", "gpt-5", "deepmind",
  "meta ai", "mistral", "xai", "grok", "llama", "copilot", "perplexity", "hugging face",
  "ai", "llm", "machine learning",
  // frameworks
  "react", "vue", "angular", "svelte", "next.js", "nextjs", "nuxt", "laravel", "django",
  "rails", "spring boot", "express", "flask", "fastapi", "remix", "astro", "framework",
  // frontend
  "frontend", "front-end", "css", "tailwind", "javascript", "typescript", "webpack", "vite",
  // backend
  "backend", "back-end", "node.js", "nodejs", "api", "microservice", "php", "golang", "rust",
  // database
  "database", "sql", "postgres", "postgresql", "mysql", "mongodb", "redis", "sqlite", "nosql", "mariadb",
];

async function fetchItem(id: number): Promise<HnItem | null> {
  try {
    const res = await fetch(`https://hacker-news.firebaseio.com/v0/item/${id}.json`, {
      signal: AbortSignal.timeout(5000),
    });
    if (!res.ok) return null;
    return (await res.json()) as HnItem;
  } catch {
    return null;
  }
}

function formatHeadline(story: HnItem): TechHeadline {
  return {
    title: story.title!,
    url: story.url ?? `https://news.ycombinator.com/item?id=${story.id}`,
    publishedAt: story.time
      ? new Date(story.time * 1000).toLocaleDateString("en-US", {
          year: "numeric",
          month: "long",
          day: "numeric",
        })
      : "recently",
  };
}

/**
 * Pulls a real, current Hacker News story scoped to AI companies, frameworks,
 * frontend, backend, or database topics. Returns null (never an unrelated
 * fallback story) if nothing in the sample matches — the caller falls back
 * to a general-knowledge prompt that's still scoped to the same topics.
 */
export async function fetchTechHeadline(): Promise<TechHeadline | null> {
  let ids: number[];
  try {
    const res = await fetch("https://hacker-news.firebaseio.com/v0/topstories.json", {
      signal: AbortSignal.timeout(10000),
    });
    if (!res.ok) return null;
    ids = (await res.json()) as number[];
  } catch {
    return null;
  }

  if (!Array.isArray(ids) || ids.length === 0) return null;

  const sample = ids.slice(0, 40);
  const items = await Promise.all(sample.map(fetchItem));
  const stories = items.filter(
    (item): item is HnItem => !!item && item.type === "story" && !!item.title,
  );

  if (stories.length === 0) return null;

  for (const story of stories) {
    const titleLower = story.title!.toLowerCase();
    if (TOPIC_KEYWORDS.some((keyword) => titleLower.includes(keyword))) {
      return formatHeadline(story);
    }
  }

  return null;
}
