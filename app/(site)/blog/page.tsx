import { getArticles } from "@/lib/db/queries";
import PostCard from "@/components/site/PostCard";

export default async function BlogPage() {
  const posts = await getArticles(1, 6);

  return (
    <>
      <section className="relative overflow-hidden">
        <div className="absolute inset-0 -z-10">
          <div className="absolute top-0 left-1/2 -translate-x-1/2 w-[50rem] h-[20rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full" />
        </div>
        <div className="anim-stagger max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-12">
          <p className="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">Writing</p>
          <h1 className="text-4xl font-extrabold text-slate-900 dark:text-white">Blog</h1>
          <p className="mt-3 text-slate-600 dark:text-slate-400">Notes on projects and things I&apos;m learning.</p>
        </div>
      </section>

      <section className="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        {posts.length === 0 ? (
          <p className="text-slate-500">No posts yet — check back soon.</p>
        ) : (
          <div className="anim-stagger space-y-6">
            {posts.map((post) => (
              <PostCard key={post.id} post={post} />
            ))}
          </div>
        )}
      </section>
    </>
  );
}
