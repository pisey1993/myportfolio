"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { useState } from "react";

const NAV_ITEMS = [
  { href: "/admin", label: "Dashboard", match: (p: string) => p === "/admin" },
  { href: "/admin/experiences", label: "Experience", match: (p: string) => p.startsWith("/admin/experiences") },
  { href: "/admin/projects", label: "Projects", match: (p: string) => p.startsWith("/admin/projects") },
  { href: "/admin/posts", label: "Posts", match: (p: string) => p.startsWith("/admin/posts") },
  { href: "/admin/skills", label: "Skills", match: (p: string) => p.startsWith("/admin/skills") },
  { href: "/admin/messages", label: "Messages", match: (p: string) => p.startsWith("/admin/messages") },
  { href: "/admin/settings", label: "Settings", match: (p: string) => p.startsWith("/admin/settings") },
];

export default function Sidebar({ unreadCount, mobileOpen, onCloseMobile }: { unreadCount: number; mobileOpen: boolean; onCloseMobile: () => void }) {
  const pathname = usePathname();
  const [collapsed, setCollapsed] = useState(false);

  return (
    <>
      {mobileOpen && (
        <div className="fixed inset-0 bg-slate-900/50 z-40 lg:hidden" onClick={onCloseMobile} />
      )}

      <aside
        className={`fixed top-0 bottom-0 left-0 z-50 bg-slate-900 flex flex-col shrink-0 transform transition-[transform,width] duration-200 ease-in-out lg:translate-x-0 lg:static ${
          mobileOpen ? "translate-x-0" : "-translate-x-full"
        } ${collapsed ? "lg:w-[76px]" : "lg:w-64"} w-64`}
      >
        <div className="h-16 flex items-center gap-2.5 px-4 shrink-0">
          <span className="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white font-bold text-sm shrink-0">P</span>
          {!collapsed && <span className="font-semibold text-white">Pisey</span>}
        </div>

        <nav className="flex-1 overflow-y-auto py-4 px-3 space-y-1">
          {NAV_ITEMS.map((item) => {
            const active = item.match(pathname);
            const badge = item.href === "/admin/messages" && unreadCount > 0 ? unreadCount : null;
            return (
              <Link
                key={item.href}
                href={item.href}
                title={collapsed ? item.label : undefined}
                className={`flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition ${
                  active ? "bg-indigo-600 text-white shadow-sm shadow-indigo-900/40" : "text-slate-400 hover:bg-white/5 hover:text-white"
                }`}
              >
                <span className="w-2 h-2 rounded-full bg-current shrink-0" />
                {!collapsed && <span className="flex-1">{item.label}</span>}
                {badge && (
                  collapsed
                    ? <span className="w-1.5 h-1.5 rounded-full bg-rose-500" />
                    : <span className="px-1.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-500 text-white">{badge}</span>
                )}
              </Link>
            );
          })}
        </nav>

        <button
          onClick={() => setCollapsed((v) => !v)}
          className="hidden lg:flex items-center gap-2 px-4 py-4 text-slate-400 hover:text-white text-sm border-t border-white/5"
        >
          <span className={`inline-block transition-transform ${collapsed ? "rotate-180" : ""}`}>&larr;</span>
          {!collapsed && "Collapse menu"}
        </button>
      </aside>
    </>
  );
}
