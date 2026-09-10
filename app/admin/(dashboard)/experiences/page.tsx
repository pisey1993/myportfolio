import Link from "next/link";
import { getExperiences } from "@/lib/db/queries";
import PageHeader from "@/components/admin/PageHeader";
import { deleteExperience } from "./actions";

export default async function AdminExperiencesPage() {
  const experiences = await getExperiences();

  return (
    <>
      <PageHeader
        title="Experience"
        actions={
          <Link href="/admin/experiences/new" className="inline-flex items-center px-3 py-1 rounded-lg border border-[#4f46e5] text-[#4f46e5] text-[13px] font-medium hover:bg-[#eef2ff]">
            Add New
          </Link>
        }
      />
      <div className="px-4 sm:px-6 lg:px-8 pb-8">
        <div className="bg-white border border-[#e2e8f0] rounded-xl shadow-sm overflow-hidden">
          {experiences.length === 0 ? (
            <p className="px-4 py-8 text-[13px] text-[#64748b]">No experience entries yet. <Link href="/admin/experiences/new" className="text-[#4f46e5] hover:text-[#4338ca]">Add your first one</Link>.</p>
          ) : (
            <table className="min-w-full text-[13px]">
              <thead>
                <tr className="border-b border-[#e2e8f0]">
                  <th className="px-4 py-2 text-left font-semibold text-[#0f172a]">Role</th>
                  <th className="px-4 py-2 text-left font-semibold text-[#0f172a]">Company</th>
                  <th className="px-4 py-2 text-left font-semibold text-[#0f172a]">Dates</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-[#f1f5f9]">
                {experiences.map((exp) => (
                  <tr key={exp.id} className="group hover:bg-[#f8fafc]">
                    <td className="px-4 py-3">
                      <Link href={`/admin/experiences/${exp.id}/edit`} className="font-medium text-[#4f46e5] hover:text-[#4338ca]">{exp.title}</Link>
                      <div className="mt-1 text-[13px] text-[#4f46e5] opacity-0 group-hover:opacity-100 transition space-x-1">
                        <Link href={`/admin/experiences/${exp.id}/edit`} className="hover:text-[#4338ca] hover:underline">Edit</Link>
                        <span className="text-[#e2e8f0]">|</span>
                        <form action={deleteExperience.bind(null, exp.id)} className="inline">
                          <button type="submit" className="text-[#b91c1c] hover:text-[#dc2626] hover:underline">Delete</button>
                        </form>
                      </div>
                    </td>
                    <td className="px-4 py-3 align-top text-[#64748b]">{exp.company}</td>
                    <td className="px-4 py-3 align-top text-[#64748b]">{exp.startLabel} — {exp.endLabel || "Present"}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>
      </div>
    </>
  );
}
