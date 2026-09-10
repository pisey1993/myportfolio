import Link from "next/link";
import { notFound } from "next/navigation";
import { getPostBySlug } from "@/lib/db/queries";
import { toEmbedUrl } from "@/lib/youtube";
import { formatDate } from "@/lib/format";
import MediaPlaceholder from "@/components/site/MediaPlaceholder";
import ShareButtons from "@/components/site/ShareButtons";

export default async function PostShowPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const post = await getPostBySlug(slug);
  if (!post) notFound();

  const url = `${process.env.NEXTAUTH_URL ?? "http://localhost:3000"}/blog/${post.slug}`;

  return (
    <article>
      <div className="relative overflow-hidden">
        <div className="absolute inset-0 -z-10">
          <div className="absolute top-0 left-1/2 -translate-x-1/2 w-[50rem] h-[20rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full" />
        </div>
        <div className="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-20 pb-8">
          <Link href="/blog" className="text-sm text-slate-500 hover:text-slate-900 dark:hover:text-white">&larr; All posts</Link>

          {post.publishedAt && <p className="mt-4 text-xs text-slate-500">{formatDate(post.publishedAt)}</p>}
          <h1 className="mt-2 text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">{post.title}</h1>

          <ShareButtons url={url} title={post.title} className="mt-5" />
        </div>
      </div>

      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="aspect-[16/9] rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10">
          {post.videoUrl ? (
            <iframe
              src={toEmbedUrl(post.videoUrl)}
              title={post.title}
              className="w-full h-full"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowFullScreen
            />
          ) : post.coverImage ? (
            // eslint-disable-next-line @next/next/no-img-element
            <img src={post.coverImage} alt={post.title} className="w-full h-full object-cover" />
          ) : (
            <MediaPlaceholder title={post.title} className="w-full h-full" />
          )}
        </div>
      </div>

      <div className="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-24">
        <div className="prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 whitespace-pre-line">{post.body}</div>

        <div className="mt-10 pt-6 border-t border-slate-200 dark:border-white/10">
          <ShareButtons url={url} title={post.title} />
        </div>
      </div>
    </article>
  );
}
