"use client";

type Experience = { title: string; company: string; startLabel: string; endLabel: string | null; highlights: string | null; sortOrder: number };

const inputClass = "mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]";
const labelClass = "block text-[13px] font-semibold text-[#0f172a]";

export default function ExperienceForm({ experience, action }: { experience?: Experience; action: (formData: FormData) => void }) {
  return (
    <form action={action} className="space-y-6">
      <div>
        <label htmlFor="title" className={labelClass}>Title</label>
        <input type="text" name="title" id="title" defaultValue={experience?.title} required maxLength={255} className={inputClass} />
      </div>
      <div>
        <label htmlFor="company" className={labelClass}>Company</label>
        <input type="text" name="company" id="company" defaultValue={experience?.company} required maxLength={255} className={inputClass} />
      </div>
      <div className="grid sm:grid-cols-2 gap-6">
        <div>
          <label htmlFor="startLabel" className={labelClass}>Start</label>
          <input type="text" name="startLabel" id="startLabel" defaultValue={experience?.startLabel} required placeholder="e.g. January 2025 or 2018" className={inputClass} />
        </div>
        <div>
          <label htmlFor="endLabel" className={labelClass}>End</label>
          <input type="text" name="endLabel" id="endLabel" defaultValue={experience?.endLabel ?? ""} placeholder="Leave blank for Present" className={inputClass} />
          <p className="mt-1 text-[12px] text-[#94a3b8]">Blank shows as &apos;Present&apos;.</p>
        </div>
      </div>
      <div>
        <label htmlFor="highlights" className={labelClass}>Highlights</label>
        <textarea name="highlights" id="highlights" rows={6} defaultValue={experience?.highlights ?? ""} className={inputClass} />
        <p className="mt-1 text-[12px] text-[#94a3b8]">One bullet point per line.</p>
      </div>
      <div>
        <label htmlFor="sortOrder" className={`${labelClass} max-w-[160px]`}>Sort Order</label>
        <input type="number" name="sortOrder" id="sortOrder" defaultValue={experience?.sortOrder ?? 0} className={`${inputClass} max-w-[160px]`} />
        <p className="mt-1 text-[12px] text-[#94a3b8]">Lower numbers show first (1 = most recent).</p>
      </div>
      <div className="flex justify-end gap-3">
        <a href="/admin/experiences" className="px-4 py-2 text-sm font-medium text-gray-700">Cancel</a>
        <button type="submit" className="px-5 py-2.5 rounded-md bg-[#4f46e5] text-white text-sm font-medium hover:bg-[#4338ca]">
          {experience ? "Save Changes" : "Create Experience"}
        </button>
      </div>
    </form>
  );
}
