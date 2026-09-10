export type YoutubeMeta = {
  title: string;
  thumbnailUrl: string;
};

export async function fetchYoutubeMeta(url: string): Promise<YoutubeMeta> {
  const params = new URLSearchParams({ url, format: "json" });
  const res = await fetch(`https://www.youtube.com/oembed?${params}`, {
    signal: AbortSignal.timeout(5000),
  });

  if (!res.ok) {
    throw new Error("Video not found or is private.");
  }

  const data = await res.json();
  return { title: data.title, thumbnailUrl: data.thumbnail_url };
}

/**
 * Converts a YouTube/Vimeo watch URL into an embeddable player URL, for the
 * post detail page's iframe.
 */
export function toEmbedUrl(videoUrl: string): string {
  const youtubeMatch = videoUrl.match(
    /(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([\w-]+)/,
  );
  if (youtubeMatch) return `https://www.youtube.com/embed/${youtubeMatch[1]}`;

  const vimeoMatch = videoUrl.match(/vimeo\.com\/(\d+)/);
  if (vimeoMatch) return `https://player.vimeo.com/video/${vimeoMatch[1]}`;

  return videoUrl;
}
