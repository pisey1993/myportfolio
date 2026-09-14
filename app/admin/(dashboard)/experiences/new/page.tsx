import PageHeader from "@/components/admin/PageHeader";
import ExperienceForm from "../ExperienceForm";
import { createExperience } from "../actions";

export default function NewExperiencePage() {
  return (
    <>
      <PageHeader title="New Experience" />
      <div className="px-4 sm:px-6 lg:px-8 pb-8">
        <div className="max-w-2xl bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
          <ExperienceForm action={createExperience} />
        </div>
      </div>
    </>
  );
}
