import { auth } from "@/lib/auth";
import { getUnreadMessageCount } from "@/lib/db/queries";
import { readFlash } from "@/lib/flash";
import AdminShell from "@/components/admin/AdminShell";
import { ToastRegion } from "@/components/site/Toast";

export default async function AdminDashboardLayout({ children }: { children: React.ReactNode }) {
  const [session, unreadCount, flash] = await Promise.all([auth(), getUnreadMessageCount(), readFlash()]);

  return (
    <>
      <AdminShell userEmail={session?.user?.email ?? ""} unreadCount={unreadCount}>
        {children}
      </AdminShell>
      <ToastRegion flash={flash} />
    </>
  );
}

export const dynamic = "force-dynamic";
