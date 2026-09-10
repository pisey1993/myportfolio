"use client";

import { useRef, useState } from "react";
import { POST_TYPE_ARTICLE, POST_TYPE_VIDEO } from "@/lib/db/schema";

type Post = {
  title: string;
  excerpt: string | null;
  body: string;
  coverImage: string | null;
  videoUrl: string | null;
  type: string;
  isPublished: boolean;
  publishedAt: Date | null;
};

const inputClass = "mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]";
const labelClass = "block text-[13px] font-semibold text-[#0f172a]";

function toDatetimeLocal(date: Date | null): string {
  if (!date) return "";
  const d = new Date(date);
  d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
  return d.toISOString().slice(0, 16);
}

export default function PostForm({ post, action }: { post?: Post; action: (formData: FormData) => void }) {
  const titleRef = useRef<HTMLInputElement>(null);
  const excerptRef = useRef<HTMLInputElement>(null);
  const bodyRef = useRef<HTMLTextAreaElement>(null);
  const videoUrlRef = useRef<HTMLInputElement>(null);
  const coverImageRef = useRef<HTMLInputElement>(null);
  const typeRef = useRef<HTMLSelectElement>(null);

  const [thumbnail, setThumbnail] = useState<string | null>(post?.coverImage ?? null);
  const [fetchingVideo, setFetchingVideo] = useState(false);
  const [videoError, setVideoError] = useState<string | null>(null);
  const [generatingNews, setGeneratingNews] = useState(false);
  const [newsError, setNewsError] = useState<string | null>(null);

  async function fetchVideoMeta() {
    const url = videoUrlRef.current?.value.trim();
    if (!url) return;
    setFetchingVideo(true);
    setVideoError(null);
    try {
      const res = await fetch(`/api/posts/youtube-meta?url=${encodeURIComponent(url)}`);
      const data = await res.json();
      if (!res.ok) {
        setVideoError(data.message || "Could not fetch video info.");
        return;
      }
      if (titleRef.current && !titleRef.current.value.trim()) titleRef.current.value = data.title;
      if (coverImageRef.current && !coverImageRef.current.value.trim()) {
        coverImageRef.current.value = data.thumbnail_url;
        setThumbnail(data.thumbnail_url);
      }
      if (typeRef.current) typeRef.current.value = POST_TYPE_VIDEO;
    } catch {
      setVideoError("Could not fetch video info.");
    } finally {
      setFetchingVideo(false);
    }
  }

  async function generateNews() {
    setGeneratingNews(true);
    setNewsError(null);
    try {
      const res = await fetch("/api/posts/generate-news", { method: "POST" });
      const data = await res.json();
      if (!res.ok) {
        setNewsError(data.message || "Could not generate a post right now.");
        return;
      }
      if (titleRef.current) titleRef.current.value = data.title;
      if (excerptRef.current) excerptRef.current.value = data.excerpt || "";
      if (bodyRef.current) bodyRef.current.value = data.body;
      if (typeRef.current) typeRef.current.value = POST_TYPE_ARTICLE;
      if (data.image_url) {
        if (coverImageRef.current) coverImageRef.current.value = data.image_url;
        setThumbnail(data.image_url);
      }
    } catch {
      setNewsError("Could not generate a post right now.");
    } finally {
      setGeneratingNews(false);
    }
  }

  return (
    <form action={action} className="space-y-6">
      <div className="rounded-xl border border-dashed border-[#c7d2fe] bg-[#eef2ff] p-4">
        <button
          type="button"
          onClick={generateNews}
          disabled={generatingNews}
          className="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#4f46e5] text-white text-[13px] font-semibold hover:bg-[#4338ca] disabled:opacity-60 disabled:cursor-not-allowed"
        >
          {generatingNews ? "Generating…" : "✨ Generate from AI / coding / tech news"}
        </button>
        <p className="mt-2 text-[12px] text-[#4338ca]">Uses Gemini to write a post about a notable AI, coding, or tech story and fills in the fields below, including a cover image.</p>
        {newsError && <p className="mt-2 text-[13px] text-[#dc2626]">{newsError}</p>}
      </div>

      <div>
        <label htmlFor="title" className={labelClass}>Title</label>
        <input ref={titleRef} type="text" name="title" id="title" defaultValue={post?.title} required maxLength={255} className={inputClass} />
      </div>

      <div>
        <label htmlFor="type" className={labelClass}>Post Type</label>
        <select ref={typeRef} name="type" id="type" defaultValue={post?.type ?? POST_TYPE_ARTICLE} className={inputClass}>
          <option value={POST_TYPE_ARTICLE}>Blog</option>
          <option value={POST_TYPE_VIDEO}>Video Blog</option>
        </select>
        <p className="mt-1 text-[12px] text-[#94a3b8]">Controls whether this post shows on the Blog page or the Video Blog page.</p>
      </div>

      <div>
        <label htmlFor="excerpt" className={labelClass}>Excerpt</label>
        <input ref={excerptRef} type="text" name="excerpt" id="excerpt" defaultValue={post?.excerpt ?? ""} maxLength={255} className={inputClass} />
        <p className="mt-1 text-[12px] text-[#94a3b8]">Short summary shown in listings. Max 255 characters.</p>
      </div>

      <div>
        <label htmlFor="body" className={labelClass}>Body</label>
        <textarea ref={bodyRef} name="body" id="body" rows={12} defaultValue={post?.body} required className={inputClass} />
      </div>

      <div>
        <label htmlFor="videoUrl" className={labelClass}>Video URL</label>
        <input
          ref={videoUrlRef}
          type="text"
          name="videoUrl"
          id="videoUrl"
          defaultValue={post?.videoUrl ?? ""}
          onBlur={fetchVideoMeta}
          placeholder="https://youtube.com/watch?v=..."
          maxLength={2048}
          className={inputClass}
        />
        <p className="mt-1 text-[12px] text-[#94a3b8]">Paste a YouTube link — the title and thumbnail below fill in automatically. Set this to make the post appear in the Video Blog.</p>
        {fetchingVideo && <p className="mt-1 text-[12px] text-[#4f46e5]">Fetching video info…</p>}
        {videoError && <p className="mt-1 text-[13px] text-[#dc2626]">{videoError}</p>}
      </div>

      <div>
        <label htmlFor="coverImage" className={labelClass}>Cover Image URL</label>
        <input
          ref={coverImageRef}
          type="text"
          name="coverImage"
          id="coverImage"
          defaultValue={post?.coverImage ?? ""}
          onChange={(e) => setThumbnail(e.target.value.trim() || null)}
          placeholder="https://"
          maxLength={2048}
          className={inputClass}
        />
        <p className="mt-1 text-[12px] text-[#94a3b8]">Auto-filled from the video thumbnail or generated news image — override if you want a different image.</p>
        {thumbnail && (
          // eslint-disable-next-line @next/next/no-img-element
          <img src={thumbnail} alt="Cover image preview" className="mt-2 w-40 aspect-video object-cover rounded-lg border border-[#e2e8f0]" />
        )}
      </div>

      <div className="grid sm:grid-cols-2 gap-6 items-end">
        <div className="flex items-center gap-2">
          <input type="checkbox" name="isPublished" id="isPublished" defaultChecked={post?.isPublished} className="rounded-[2px] border-[#94a3b8] text-[#4f46e5] focus:ring-[#4f46e5] focus:ring-offset-0" />
          <label htmlFor="isPublished" className="text-[13px] font-semibold text-[#0f172a]">Published</label>
        </div>
        <div>
          <label htmlFor="publishedAt" className={labelClass}>Published At</label>
          <input type="datetime-local" name="publishedAt" id="publishedAt" defaultValue={toDatetimeLocal(post?.publishedAt ?? null)} className={inputClass} />
          <p className="mt-1 text-[12px] text-[#94a3b8]">Leave blank to publish immediately.</p>
        </div>
      </div>

      <div className="flex justify-end gap-3">
        <a href="/admin/posts" className="px-4 py-2 text-sm font-medium text-gray-700">Cancel</a>
        <button type="submit" className="px-5 py-2.5 rounded-md bg-[#4f46e5] text-white text-sm font-medium hover:bg-[#4338ca]">
          {post ? "Save Changes" : "Create Post"}
        </button>
      </div>
    </form>
  );
}
