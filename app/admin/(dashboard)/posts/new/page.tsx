import PageHeader from "@/components/admin/PageHeader";
import PostForm from "../PostForm";
import { createPost } from "../actions";

export default function NewPostPage() {
  return (
    <>
      <PageHeader title="New Post" />
      <div className="px-4 sm:px-6 lg:px-8 pb-8">
        <div className="max-w-3xl bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
          <PostForm action={createPost} />
        </div>
      </div>
    </>
  );
}
