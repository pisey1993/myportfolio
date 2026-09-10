import Link from "next/link";
import { getAllMessages } from "@/lib/db/queries";
import { formatDate } from "@/lib/format";
import PageHeader from "@/components/admin/PageHeader";

export default async function AdminMessagesPage() {
  const messages = await getAllMessages();

  return (
    <>
      <PageHeader title="Messages" />
      <div className="px-4 sm:px-6 lg:px-8 pb-8">
        <div className="bg-white border border-[#e2e8f0] rounded-xl shadow-sm overflow-hidden divide-y divide-[#f1f5f9]">
          {messages.length === 0 ? (
            <p className="px-4 py-8 text-[13px] text-[#64748b]">No messages yet.</p>
          ) : (
            messages.map((message) => (
              <Link key={message.id} href={`/admin/messages/${message.id}`} className="flex items-center justify-between px-4 py-3.5 hover:bg-[#f8fafc]">
                <div className="flex items-center gap-2.5 min-w-0">
                  {!message.readAt && <span className="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0" />}
                  <div className="min-w-0">
                    <p className="text-[13px] font-medium text-[#0f172a]">{message.name} <span className="text-[#94a3b8] font-normal">&lt;{message.email}&gt;</span></p>
                    <p className="text-[12px] text-[#64748b] truncate">{message.subject || message.message.slice(0, 80)}</p>
                  </div>
                </div>
                <span className="text-[12px] text-[#94a3b8] shrink-0 ml-3">{formatDate(message.createdAt)}</span>
              </Link>
            ))
          )}
        </div>
      </div>
    </>
  );
}
