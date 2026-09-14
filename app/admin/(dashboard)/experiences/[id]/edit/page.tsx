import { notFound } from "next/navigation";
import { getExperienceById } from "@/lib/content";
import PageHeader from "@/components/admin/PageHeader";
import ExperienceForm from "../../ExperienceForm";
import { updateExperience } from "../../actions";

export default async function EditExperiencePage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  const experience = await getExperienceById(Number(id));
  if (!experience) notFound();

  return (
    <>
      <PageHeader title="Edit Experience" />
      <div className="px-4 sm:px-6 lg:px-8 pb-8">
        <div className="max-w-2xl bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
          <ExperienceForm experience={experience} action={updateExperience.bind(null, experience.id)} />
        </div>
      </div>
    </>
  );
}
