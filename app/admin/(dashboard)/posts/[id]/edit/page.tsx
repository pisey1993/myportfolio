import { notFound } from "next/navigation";
import { getPostById } from "@/lib/content";
import PageHeader from "@/components/admin/PageHeader";
import PostForm from "../../PostForm";
import { updatePost } from "../../actions";

export default async function EditPostPage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  const post = await getPostById(Number(id));
  if (!post) notFound();

  return (
    <>
      <PageHeader title="Edit Post" />
      <div className="px-4 sm:px-6 lg:px-8 pb-8">
        <div className="max-w-3xl bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
          <PostForm post={post} action={updatePost.bind(null, post.id)} />
        </div>
      </div>
    </>
  );
}
