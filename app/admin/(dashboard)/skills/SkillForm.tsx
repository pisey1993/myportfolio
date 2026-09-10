"use client";

type Skill = { name: string; category: string; level: number; sortOrder: number };

const inputClass = "mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]";
const labelClass = "block text-[13px] font-semibold text-[#0f172a]";

export default function SkillForm({ skill, action }: { skill?: Skill; action: (formData: FormData) => void }) {
  return (
    <form action={action} className="space-y-6">
      <div>
        <label htmlFor="name" className={labelClass}>Name</label>
        <input type="text" name="name" id="name" defaultValue={skill?.name} required maxLength={255} className={inputClass} />
      </div>
      <div>
        <label htmlFor="category" className={labelClass}>Category</label>
        <input type="text" name="category" id="category" defaultValue={skill?.category ?? "General"} required placeholder="Backend, Frontend, Tools..." className={inputClass} />
      </div>
      <div className="grid sm:grid-cols-2 gap-6">
        <div>
          <label htmlFor="level" className={labelClass}>Level (0-100)</label>
          <input type="number" name="level" id="level" min={0} max={100} defaultValue={skill?.level ?? 80} required className={inputClass} />
        </div>
        <div>
          <label htmlFor="sortOrder" className={labelClass}>Sort Order</label>
          <input type="number" name="sortOrder" id="sortOrder" defaultValue={skill?.sortOrder ?? 0} className={inputClass} />
        </div>
      </div>
      <div className="flex justify-end gap-3">
        <a href="/admin/skills" className="px-4 py-2 text-sm font-medium text-gray-700">Cancel</a>
        <button type="submit" className="px-5 py-2.5 rounded-md bg-[#4f46e5] text-white text-sm font-medium hover:bg-[#4338ca]">
          {skill ? "Save Changes" : "Create Skill"}
        </button>
      </div>
    </form>
  );
}
