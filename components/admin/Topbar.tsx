"use client";

import { useState } from "react";
import { signOutAction } from "@/app/admin/actions";

export default function Topbar({ userEmail, onOpenMobile }: { userEmail: string; onOpenMobile: () => void }) {
  const [open, setOpen] = useState(false);
  const initial = userEmail.slice(0, 1).toUpperCase();

  return (
    <header className="h-16 shrink-0 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 gap-4">
      <button onClick={onOpenMobile} className="lg:hidden p-2 -ml-2 rounded-lg text-slate-500 hover:bg-slate-100">
        <svg className="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth={2} strokeLinecap="round" strokeLinejoin="round">
          <line x1="3" y1="6" x2="21" y2="6" /><line x1="3" y1="12" x2="21" y2="12" /><line x1="3" y1="18" x2="21" y2="18" />
        </svg>
      </button>

      <div className="flex-1" />

      <div className="flex items-center gap-3">
        <a href="/" target="_blank" rel="noopener" className="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 text-sm font-medium transition">
          Visit Site
        </a>

        <div className="w-px h-6 bg-slate-200 hidden sm:block" />

        <div className="relative">
          <button onClick={() => setOpen((v) => !v)} className="flex items-center gap-2.5 py-1 pl-1 pr-2 rounded-full hover:bg-slate-100 transition">
            <span className="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-[13px] font-semibold text-white shrink-0">
              {initial}
            </span>
            <span className="hidden sm:inline text-sm font-medium text-slate-900">{userEmail}</span>
          </button>

          {open && (
            <div className="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-slate-200 py-1.5 text-sm origin-top-right">
              <form action={signOutAction}>
                <button type="submit" className="w-full text-left flex items-center gap-2.5 px-3.5 py-2 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition">
                  Log Out
                </button>
              </form>
            </div>
          )}
        </div>
      </div>
    </header>
  );
}
