import { notFound } from "next/navigation";
import { getMessageById } from "@/lib/db/queries";
import { formatDate } from "@/lib/format";
import PageHeader from "@/components/admin/PageHeader";
import { deleteMessage, markAsRead } from "../actions";

export default async function AdminMessageShowPage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params;
  const message = await getMessageById(Number(id));
  if (!message) notFound();

  if (!message.readAt) {
    await markAsRead(message.id);
  }

  return (
    <>
      <PageHeader title="Message" />
      <div className="px-4 sm:px-6 lg:px-8 pb-8">
        <div className="max-w-2xl bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
          <dl className="grid grid-cols-2 gap-4 text-[13px]">
            <div>
              <dt className="text-[#94a3b8] font-medium">From</dt>
              <dd className="text-[#0f172a] mt-0.5">{message.name}</dd>
            </div>
            <div>
              <dt className="text-[#94a3b8] font-medium">Email</dt>
              <dd className="mt-0.5"><a href={`mailto:${message.email}`} className="text-[#4f46e5] hover:underline">{message.email}</a></dd>
            </div>
            {message.subject && (
              <div className="col-span-2">
                <dt className="text-[#94a3b8] font-medium">Subject</dt>
                <dd className="text-[#0f172a] mt-0.5">{message.subject}</dd>
              </div>
            )}
            <div className="col-span-2">
              <dt className="text-[#94a3b8] font-medium">Received</dt>
              <dd className="text-[#0f172a] mt-0.5">{formatDate(message.createdAt, { year: "numeric", month: "long", day: "numeric", hour: "numeric", minute: "2-digit" })}</dd>
            </div>
          </dl>

          <p className="mt-6 text-[14px] text-[#334155] whitespace-pre-line border-t border-[#f1f5f9] pt-6">{message.message}</p>

          <div className="mt-6 pt-6 border-t border-[#f1f5f9] flex justify-between">
            <a
              href={`mailto:${message.email}?subject=${encodeURIComponent(`Re: ${message.subject || ""}`)}`}
              className="px-4 py-2 rounded-md border border-[#e2e8f0] text-[13px] font-medium text-[#0f172a] hover:bg-[#f8fafc]"
            >
              Reply by Email
            </a>
            <form action={deleteMessage.bind(null, message.id)}>
              <button type="submit" className="px-4 py-2 rounded-md text-[13px] font-medium text-[#dc2626] hover:bg-red-50">Delete</button>
            </form>
          </div>
        </div>
      </div>
    </>
  );
}
