import { notFound } from "next/navigation";
import { eq } from "drizzle-orm";
import { db } from "@/lib/db/client";
import { skills } from "@/lib/db/schema";
import PageHeader from "@/components/admin/PageHeader";
import SkillForm from "../../SkillForm";
import { updateSkill } from "../../actions";

export default async function EditSkillPage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  const [skill] = await db.select().from(skills).where(eq(skills.id, Number(id))).limit(1);
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
