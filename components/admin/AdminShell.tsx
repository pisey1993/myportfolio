"use client";

import { useState } from "react";
import Sidebar from "./Sidebar";
import Topbar from "./Topbar";

export default function AdminShell({
  userEmail,
  unreadCount,
  children,
}: {
  userEmail: string;
  unreadCount: number;
  children: React.ReactNode;
}) {
  const [mobileOpen, setMobileOpen] = useState(false);

  return (
    <div className="flex h-screen overflow-hidden bg-slate-50 text-slate-900 text-sm">
      <Sidebar unreadCount={unreadCount} mobileOpen={mobileOpen} onCloseMobile={() => setMobileOpen(false)} />

      <div className="flex-1 min-w-0 flex flex-col overflow-hidden">
        <Topbar userEmail={userEmail} onOpenMobile={() => setMobileOpen(true)} />

        <div className="flex-1 overflow-y-auto">
          <main className="animate__animated animate__fadeIn">{children}</main>
        </div>
      </div>
    </div>
  );
}
