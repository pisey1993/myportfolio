import PageHeader from "@/components/admin/PageHeader";
import ProjectForm from "../ProjectForm";
import { createProject } from "../actions";

export default function NewProjectPage() {
  return (
    <>
      <PageHeader title="New Project" />
      <div className="px-4 sm:px-6 lg:px-8 pb-8">
        <div className="max-w-3xl bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
          <ProjectForm action={createProject} />
        </div>
      </div>
    </>
  );
}
