import Link from "next/link";
import { getAllProjects } from "@/lib/db/queries";
import PageHeader from "@/components/admin/PageHeader";
import { deleteProject } from "./actions";

export default async function AdminProjectsPage() {
  const projects = await getAllProjects();

  return (
    <>
      <PageHeader
        title="Projects"
        actions={
          <Link href="/admin/projects/new" className="inline-flex items-center px-3 py-1 rounded-lg border border-[#4f46e5] text-[#4f46e5] text-[13px] font-medium hover:bg-[#eef2ff]">
            Add New
          </Link>
        }
      />

      <div className="px-4 sm:px-6 lg:px-8 pb-8">
        <div className="bg-white border border-[#e2e8f0] rounded-xl shadow-sm overflow-hidden">
          {projects.length === 0 ? (
            <p className="px-4 py-8 text-[13px] text-[#64748b]">No projects yet. <Link href="/admin/projects/new" className="text-[#4f46e5] hover:text-[#4338ca]">Add your first one</Link>.</p>
          ) : (
            <table className="min-w-full text-[13px]">
              <thead>
                <tr className="border-b border-[#e2e8f0]">
                  <th className="px-4 py-2 text-left font-semibold text-[#0f172a]">Title</th>
                  <th className="px-4 py-2 text-left font-semibold text-[#0f172a]">Featured</th>
                  <th className="px-4 py-2 text-left font-semibold text-[#0f172a]">Order</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-[#f1f5f9]">
                {projects.map((project) => (
                  <tr key={project.id} className="group hover:bg-[#f8fafc]">
                    <td className="px-4 py-3">
                      <Link href={`/admin/projects/${project.id}/edit`} className="font-medium text-[#4f46e5] hover:text-[#4338ca]">{project.title}</Link>
                      <div className="mt-1 text-[13px] text-[#4f46e5] opacity-0 group-hover:opacity-100 transition space-x-1">
                        <Link href={`/admin/projects/${project.id}/edit`} className="hover:text-[#4338ca] hover:underline">Edit</Link>
                        <span className="text-[#e2e8f0]">|</span>
                        <a href={`/projects/${project.slug}`} target="_blank" className="hover:text-[#4338ca] hover:underline">View</a>
                        <span className="text-[#e2e8f0]">|</span>
                        <form action={deleteProject.bind(null, project.id)} className="inline">
                          <button type="submit" className="text-[#b91c1c] hover:text-[#dc2626] hover:underline">Delete</button>
                        </form>
                      </div>
                    </td>
                    <td className="px-4 py-3 align-top text-[#64748b]">{project.isFeatured ? "Yes" : "—"}</td>
                    <td className="px-4 py-3 align-top text-[#64748b]">{project.sortOrder}</td>
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
