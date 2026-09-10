"use client";

type Project = {
  title: string;
  summary: string;
  description: string | null;
  features: string | null;
  image: string | null;
  techStack: string | null;
  projectUrl: string | null;
  repoUrl: string | null;
  isFeatured: boolean;
  sortOrder: number;
};

const inputClass = "mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]";
const labelClass = "block text-[13px] font-semibold text-[#0f172a]";

export default function ProjectForm({ project, action }: { project?: Project; action: (formData: FormData) => void }) {
  return (
    <form action={action} className="space-y-6">
      <div>
        <label htmlFor="title" className={labelClass}>Title</label>
        <input type="text" name="title" id="title" defaultValue={project?.title} required maxLength={255} className={inputClass} />
      </div>

      <div>
        <label htmlFor="summary" className={labelClass}>Summary</label>
        <input type="text" name="summary" id="summary" defaultValue={project?.summary} required maxLength={255} className={inputClass} />
        <p className="mt-1 text-[12px] text-[#94a3b8]">Shown in cards and listings.</p>
      </div>

      <div>
        <label htmlFor="description" className={labelClass}>Description</label>
        <textarea name="description" id="description" rows={6} defaultValue={project?.description ?? ""} className={inputClass} />
      </div>

      <div>
        <label htmlFor="features" className={labelClass}>Key Features</label>
        <textarea name="features" id="features" rows={8} defaultValue={project?.features ?? ""} className={inputClass} />
        <p className="mt-1 text-[12px] text-[#94a3b8]">One feature per line. Shown as a bullet list on the project page.</p>
      </div>

      <div className="grid sm:grid-cols-2 gap-6">
        <div>
          <label htmlFor="projectUrl" className={labelClass}>Live URL</label>
          <input type="url" name="projectUrl" id="projectUrl" defaultValue={project?.projectUrl ?? ""} placeholder="https://" className={inputClass} />
        </div>
        <div>
          <label htmlFor="repoUrl" className={labelClass}>Repository URL</label>
          <input type="url" name="repoUrl" id="repoUrl" defaultValue={project?.repoUrl ?? ""} placeholder="https://" className={inputClass} />
        </div>
      </div>

      <div>
        <label htmlFor="image" className={labelClass}>Image URL</label>
        <input type="text" name="image" id="image" defaultValue={project?.image ?? ""} placeholder="https://" maxLength={2048} className={inputClass} />
      </div>

      <div>
        <label htmlFor="techStack" className={labelClass}>Tech Stack</label>
        <input type="text" name="techStack" id="techStack" defaultValue={project?.techStack ?? ""} placeholder="Laravel, MySQL, Tailwind CSS" className={inputClass} />
        <p className="mt-1 text-[12px] text-[#94a3b8]">Comma-separated.</p>
      </div>

      <div className="grid sm:grid-cols-2 gap-6 items-end">
        <div className="flex items-center gap-2">
          <input type="checkbox" name="isFeatured" id="isFeatured" defaultChecked={project?.isFeatured} className="rounded-[2px] border-[#94a3b8] text-[#4f46e5] focus:ring-[#4f46e5] focus:ring-offset-0" />
          <label htmlFor="isFeatured" className="text-[13px] font-semibold text-[#0f172a]">Featured on homepage</label>
        </div>
        <div>
          <label htmlFor="sortOrder" className={labelClass}>Sort Order</label>
          <input type="number" name="sortOrder" id="sortOrder" defaultValue={project?.sortOrder ?? 0} className={inputClass} />
        </div>
      </div>

      <div className="flex justify-end gap-3">
        <a href="/admin/projects" className="px-4 py-2 text-sm font-medium text-gray-700">Cancel</a>
        <button type="submit" className="px-5 py-2.5 rounded-md bg-[#4f46e5] text-white text-sm font-medium hover:bg-[#4338ca]">
          {project ? "Save Changes" : "Create Project"}
        </button>
      </div>
    </form>
  );
}
