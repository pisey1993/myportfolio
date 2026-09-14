import Link from "next/link";
import { getDashboardStats } from "@/lib/content";
import PageHeader from "@/components/admin/PageHeader";

export default async function AdminDashboardPage() {
  const stats = await getDashboardStats();

  const cards = [
    { label: "Projects", value: stats.projects, href: "/admin/projects" },
    { label: "Posts", value: stats.posts, href: "/admin/posts" },
    { label: "Skills", value: stats.skills, href: "/admin/skills" },
    { label: "Experience", value: stats.experiences, href: "/admin/experiences" },
  ];

  return (
    <>
      <PageHeader title="Dashboard" />

      <div className="px-4 sm:px-6 lg:px-8 pb-8 space-y-6">
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
          {cards.map((card) => (
            <Link key={card.label} href={card.href} className="bg-white border border-[#e2e8f0] rounded-xl p-5 hover:border-[#4f46e5] transition">
              <p className="text-3xl font-bold text-[#0f172a]">{card.value}</p>
              <p className="text-[13px] text-[#64748b] mt-1">{card.label}</p>
            </Link>
          ))}
        </div>

        <div className="bg-white border border-[#e2e8f0] rounded-xl p-5 text-[13px] text-[#64748b]">
          Content lives in <code>lib/data/content.json</code>.{" "}
          {process.env.GITHUB_TOKEN
            ? "Edits made here are committed straight to GitHub, which redeploys the public site automatically."
            : "Edits made here are written straight to that file — commit and push to redeploy the public site with your changes."}
        </div>
      </div>
    </>
  );
}
