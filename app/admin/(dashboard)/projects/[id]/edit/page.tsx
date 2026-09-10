import { notFound } from "next/navigation";
import { eq } from "drizzle-orm";
import { db } from "@/lib/db/client";
import { projects } from "@/lib/db/schema";
import PageHeader from "@/components/admin/PageHeader";
import ProjectForm from "../../ProjectForm";
import { updateProject } from "../../actions";

export default async function EditProjectPage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  const [project] = await db.select().from(projects).where(eq(projects.id, Number(id))).limit(1);
  if (!project) notFound();

  return (
    <>
      <PageHeader title="Edit Project" />
      <div className="px-4 sm:px-6 lg:px-8 pb-8">
        <div className="max-w-3xl bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
          <ProjectForm project={project} action={updateProject.bind(null, project.id)} />
        </div>
      </div>
    </>
  );
}
