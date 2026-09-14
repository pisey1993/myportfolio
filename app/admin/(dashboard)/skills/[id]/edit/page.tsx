import { notFound } from "next/navigation";
import { getSkillById } from "@/lib/content";
import PageHeader from "@/components/admin/PageHeader";
import SkillForm from "../../SkillForm";
import { updateSkill } from "../../actions";

export default async function EditSkillPage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  const skill = await getSkillById(Number(id));
  if (!skill) notFound();

  return (
    <>
      <PageHeader title="Edit Skill" />
      <div className="px-4 sm:px-6 lg:px-8 pb-8">
        <div className="max-w-2xl bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
          <SkillForm skill={skill} action={updateSkill.bind(null, skill.id)} />
        </div>
      </div>
    </>
  );
}
