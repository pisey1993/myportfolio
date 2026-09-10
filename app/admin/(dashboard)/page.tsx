import Link from "next/link";
import { getDashboardStats, getRecentMessages } from "@/lib/db/queries";
import { formatDate } from "@/lib/format";
import PageHeader from "@/components/admin/PageHeader";

export default async function AdminDashboardPage() {
  const [stats, recentMessages] = await Promise.all([getDashboardStats(), getRecentMessages(5)]);

  const cards = [
    { label: "Projects", value: stats.projects, href: "/admin/projects" },
    { label: "Posts", value: stats.posts, href: "/admin/posts" },
    { label: "Skills", value: stats.skills, href: "/admin/skills" },
    { label: "Unread Messages", value: stats.unreadMessages, href: "/admin/messages" },
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

        <div className="bg-white border border-[#e2e8f0] rounded-xl overflow-hidden">
          <div className="px-4 py-3 border-b border-[#e2e8f0] flex items-center justify-between">
            <h2 className="font-semibold text-[#0f172a] text-sm">Recent Messages</h2>
            <Link href="/admin/messages" className="text-[13px] text-[#4f46e5] hover:text-[#4338ca]">View all</Link>
          </div>
          {recentMessages.length === 0 ? (
            <p className="px-4 py-8 text-[13px] text-[#64748b]">No messages yet.</p>
          ) : (
            <ul className="divide-y divide-[#f1f5f9]">
              {recentMessages.map((message) => (
                <li key={message.id}>
                  <Link href={`/admin/messages/${message.id}`} className="flex items-center justify-between px-4 py-3 hover:bg-[#f8fafc]">
                    <div className="flex items-center gap-2 min-w-0">
                      {!message.readAt && <span className="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0" />}
                      <div className="min-w-0">
                        <p className="text-[13px] font-medium text-[#0f172a] truncate">{message.name}</p>
                        <p className="text-[12px] text-[#64748b] truncate">{message.subject || message.message.slice(0, 60)}</p>
                      </div>
                    </div>
                    <span className="text-[12px] text-[#94a3b8] shrink-0 ml-3">{formatDate(message.createdAt)}</span>
                  </Link>
                </li>
              ))}
            </ul>
          )}
        </div>
      </div>
    </>
  );
}
