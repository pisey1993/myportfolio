const USER_AGENT_CONTACT = process.env.NEXTAUTH_URL ?? "http://localhost:3000";

type OpenverseResult = {
  url?: string;
  thumbnail?: string;
};

async function searchOpenverseImage(query: string): Promise<string | null> {
  try {
    const params = new URLSearchParams({
      q: query,
      license_type: "commercial,modification",
      page_size: "5",
    });
    const res = await fetch(`https://api.openverse.org/v1/images/?${params}`, {
      headers: { "User-Agent": `PiseyPortfolioBlog/1.0 (${USER_AGENT_CONTACT})` },
      signal: AbortSignal.timeout(10000),
    });
    if (!res.ok) return null;
    const data = (await res.json()) as { results?: OpenverseResult[] };
    for (const result of data.results ?? []) {
      const url = result.thumbnail ?? result.url;
      if (url) return url;
    }
    return null;
  } catch {
    return null;
  }
}

type CommonsPage = {
  imageinfo?: { mime?: string; thumburl?: string; url?: string }[];
};

async function searchCommonsImage(query: string): Promise<string | null> {
  try {
    const params = new URLSearchParams({
      action: "query",
      generator: "search",
      gsrsearch: query,
      gsrnamespace: "6",
      gsrlimit: "5",
      prop: "imageinfo",
      iiprop: "url|mime",
      iiurlwidth: "1200",
      format: "json",
    });
    const res = await fetch(`https://commons.wikimedia.org/w/api.php?${params}`, {
      headers: { "User-Agent": `PiseyPortfolioBlog/1.0 (${USER_AGENT_CONTACT})` },
      signal: AbortSignal.timeout(10000),
    });
    if (!res.ok) return null;
    const data = (await res.json()) as { query?: { pages?: Record<string, CommonsPage> } };
    const pages = data.query?.pages ?? {};
    for (const page of Object.values(pages)) {
      const info = page.imageinfo?.[0];
      const url = info?.thumburl ?? info?.url;
      if (url && (info?.mime === "image/jpeg" || info?.mime === "image/png")) {
        return url;
      }
    }
    return null;
  } catch {
    return null;
  }
}

/**
 * Finds a real cover photo via a fallback chain: the AI-suggested query,
 * then a query derived from the title, then a generic tech query that's
 * (in practice) always guaranteed to return something.
 */
export async function findCoverImage(imageQuery: string, title: string): Promise<string | null> {
  const titleWords = title.split(/\s+/).slice(0, 5).join(" ");
  const candidates = Array.from(new Set([imageQuery, titleWords, "technology programming computer"]));

  for (const query of candidates) {
    const url = (await searchOpenverseImage(query)) ?? (await searchCommonsImage(query));
    if (url) return url;
  }

  return null;
}
