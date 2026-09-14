import PageHeader from "@/components/admin/PageHeader";
import SkillForm from "../SkillForm";
import { createSkill } from "../actions";

export default function NewSkillPage() {
  return (
    <>
      <PageHeader title="New Skill" />
      <div className="px-4 sm:px-6 lg:px-8 pb-8">
        <div className="max-w-2xl bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
          <SkillForm action={createSkill} />
        </div>
      </div>
    </>
  );
}
