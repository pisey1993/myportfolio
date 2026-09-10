import Link from "next/link";
import { db } from "@/lib/db/client";
import { posts, POST_TYPE_VIDEO } from "@/lib/db/schema";
import { desc } from "drizzle-orm";
import { formatDate } from "@/lib/format";
import PageHeader from "@/components/admin/PageHeader";
import { deletePost, generateAndCreatePost } from "./actions";

export default async function AdminPostsPage() {
  const allPosts = await db.select().from(posts).orderBy(desc(posts.createdAt));

  return (
    <>
      <PageHeader
        title="Posts"
        actions={
          <>
            <Link href="/admin/posts/new" className="inline-flex items-center px-3 py-1 rounded-lg border border-[#4f46e5] text-[#4f46e5] text-[13px] font-medium hover:bg-[#eef2ff]">
              Add New
            </Link>
            <form action={generateAndCreatePost}>
              <button type="submit" className="inline-flex items-center px-3 py-1 rounded-lg bg-[#4f46e5] text-white text-[13px] font-medium hover:bg-[#4338ca]">
                ✨ Generate from AI News
              </button>
            </form>
          </>
        }
      />

      <div className="px-4 sm:px-6 lg:px-8 pb-8">
        <div className="bg-white border border-[#e2e8f0] rounded-xl shadow-sm overflow-hidden">
          {allPosts.length === 0 ? (
            <p className="px-4 py-8 text-[13px] text-[#64748b]">No posts yet. <Link href="/admin/posts/new" className="text-[#4f46e5] hover:text-[#4338ca]">Write your first one</Link>.</p>
          ) : (
            <table className="min-w-full text-[13px]">
              <thead>
                <tr className="border-b border-[#e2e8f0]">
                  <th className="px-4 py-2 text-left font-semibold text-[#0f172a]">Title</th>
                  <th className="px-4 py-2 text-left font-semibold text-[#0f172a]">Type</th>
                  <th className="px-4 py-2 text-left font-semibold text-[#0f172a]">Status</th>
                  <th className="px-4 py-2 text-left font-semibold text-[#0f172a]">Published</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-[#f1f5f9]">
                {allPosts.map((post) => (
                  <tr key={post.id} className="group hover:bg-[#f8fafc]">
                    <td className="px-4 py-3">
                      <Link href={`/admin/posts/${post.id}/edit`} className="font-medium text-[#4f46e5] hover:text-[#4338ca]">{post.title}</Link>
                      <div className="mt-1 text-[13px] text-[#4f46e5] opacity-0 group-hover:opacity-100 transition space-x-1">
                        <Link href={`/admin/posts/${post.id}/edit`} className="hover:text-[#4338ca] hover:underline">Edit</Link>
                        {post.isPublished && (
                          <>
                            <span className="text-[#e2e8f0]">|</span>
                            <a href={`/blog/${post.slug}`} target="_blank" className="hover:text-[#4338ca] hover:underline">View</a>
                          </>
                        )}
                        <span className="text-[#e2e8f0]">|</span>
                        <form action={deletePost.bind(null, post.id)} className="inline">
                          <button type="submit" className="text-[#b91c1c] hover:text-[#dc2626] hover:underline">Delete</button>
                        </form>
                      </div>
                    </td>
                    <td className="px-4 py-3 align-top">
                      {post.type === POST_TYPE_VIDEO ? (
                        <span className="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium bg-[#7c3aed]/10 text-[#7c3aed]">Video Blog</span>
                      ) : (
                        <span className="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium bg-[#0ea5e9]/10 text-[#0ea5e9]">Blog</span>
                      )}
                    </td>
                    <td className="px-4 py-3 align-top">
                      {post.isPublished ? (
                        <span className="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium bg-[#059669]/10 text-[#059669]">Published</span>
                      ) : (
                        <span className="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium bg-[#f1f5f9] text-[#64748b]">Draft</span>
                      )}
                    </td>
                    <td className="px-4 py-3 text-[#64748b] align-top">{post.publishedAt ? formatDate(post.publishedAt, { year: "numeric", month: "short", day: "numeric" }) : "—"}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>
      </div>
    </>
  );
}
