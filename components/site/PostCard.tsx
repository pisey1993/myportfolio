import Link from "next/link";
import MediaPlaceholder from "./MediaPlaceholder";
import { formatDate } from "@/lib/format";

type Post = {
  id: number;
  slug: string;
  title: string;
  excerpt: string | null;
  coverImage: string | null;
  publishedAt: Date | null;
};

export default function PostCard({ post, showPlayButton = false }: { post: Post; showPlayButton?: boolean }) {
  return (
    <Link
      href={`/blog/${post.slug}`}
      className="group flex gap-5 items-center rounded-2xl border border-slate-200 dark:border-white/10 shadow-sm p-4 sm:p-5 hover:border-slate-300 dark:hover:border-white/20 hover:shadow-md hover:-translate-y-0.5 transition duration-300 bg-white dark:bg-slate-900"
    >
      <div className="relative w-28 h-20 sm:w-40 sm:h-28 rounded-xl overflow-hidden shrink-0">
        {post.coverImage ? (
          // eslint-disable-next-line @next/next/no-img-element
          <img src={post.coverImage} alt={post.title} className="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
        ) : (
          <MediaPlaceholder title={post.title} className="w-full h-full group-hover:scale-105 transition duration-500" />
        )}
        {showPlayButton && (
          <span className="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/30 transition">
            <span className="w-9 h-9 rounded-full bg-white/90 flex items-center justify-center shadow">
              <svg className="w-4 h-4 text-slate-900 translate-x-[1px]" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z" /></svg>
            </span>
          </span>
        )}
      </div>
      <div className="min-w-0">
        {post.publishedAt && <p className="text-xs text-slate-500 mb-1">{formatDate(post.publishedAt)}</p>}
        <h2 className="text-lg font-semibold text-slate-900 dark:text-white group-hover:text-fuchsia-600 dark:group-hover:text-fuchsia-400 transition truncate">{post.title}</h2>
        {post.excerpt && <p className="mt-1 text-sm text-slate-600 dark:text-slate-400 line-clamp-2">{post.excerpt}</p>}
      </div>
    </Link>
  );
}
