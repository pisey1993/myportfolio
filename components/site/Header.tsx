"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { useEffect, useRef, useState } from "react";
import ThemeToggle from "./ThemeToggle";

const NAV_ITEMS = [
  { href: "/", label: "Home", match: (p: string) => p === "/" },
  { href: "/about", label: "About me", match: (p: string) => p.startsWith("/about") },
  { href: "/projects", label: "Projects", match: (p: string) => p.startsWith("/projects") },
  { href: "/blog", label: "Blog", match: (p: string) => p.startsWith("/blog") },
  { href: "/video-blog", label: "Video Blog", match: (p: string) => p.startsWith("/video-blog") },
];

const MOBILE_ITEMS = [...NAV_ITEMS, { href: "/contact", label: "Contact", match: (p: string) => p.startsWith("/contact") }];

export default function Header({ headline }: { headline: string }) {
  const pathname = usePathname();
  const [mobileNavOpen, setMobileNavOpen] = useState(false);
  const navRef = useRef<HTMLElement>(null);
  const indicatorRef = useRef<HTMLSpanElement>(null);

  function moveTo(el: HTMLElement) {
    if (!indicatorRef.current) return;
    indicatorRef.current.style.width = `${el.offsetWidth}px`;
    indicatorRef.current.style.transform = `translateX(${el.offsetLeft}px)`;
  }

  function resetToActive() {
    const active = navRef.current?.querySelector<HTMLElement>(".is-active");
    if (active) moveTo(active);
  }

  useEffect(() => {
    resetToActive();
    window.addEventListener("resize", resetToActive);
    return () => window.removeEventListener("resize", resetToActive);
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [pathname]);

  return (
    <header className="anim-fade-down sticky top-0 z-40 bg-white/90 dark:bg-slate-950/90 backdrop-blur border-b border-slate-200 dark:border-white/10">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-20">
          <Link href="/" className="flex items-center gap-2 font-bold text-lg text-slate-900 dark:text-white">
            <span className="w-8 h-8 rounded-full bg-gradient-to-tr from-pink-600 to-fuchsia-400 flex items-center justify-center text-sm">
              {headline.slice(0, 1).toUpperCase()}
            </span>
            {headline}
          </Link>

          <nav
            ref={navRef}
            onMouseLeave={resetToActive}
            className="hidden sm:flex items-center gap-1 text-sm font-medium text-slate-600 dark:text-slate-400 relative"
          >
            <span
              ref={indicatorRef}
              className="nav-indicator absolute left-0 bottom-0 h-full rounded-full bg-gradient-to-r from-pink-500/15 to-fuchsia-400/15 border border-pink-500/20 dark:border-fuchsia-400/20 transition-all duration-300 ease-out"
              style={{ width: 0 }}
            />
            {NAV_ITEMS.map((item) => {
              const active = item.match(pathname);
              return (
                <Link
                  key={item.href}
                  href={item.href}
                  onMouseEnter={(e) => moveTo(e.currentTarget)}
                  className={`relative z-10 px-3.5 py-2 rounded-full transition-colors duration-300 ease-out ${
                    active
                      ? "is-active text-slate-900 dark:text-white"
                      : "hover:text-slate-900 dark:hover:text-white"
                  }`}
                >
                  {item.label}
                </Link>
              );
            })}
          </nav>

          <div className="flex items-center gap-2">
            <ThemeToggle />

            <Link
              href="/contact"
              className="hidden sm:inline-flex items-center px-5 py-2.5 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-950 text-sm font-semibold hover:bg-slate-700 dark:hover:bg-slate-200 transition"
            >
              Contact Me
            </Link>

            <button
              onClick={() => setMobileNavOpen((v) => !v)}
              className="sm:hidden p-2 text-slate-900 dark:text-white"
              aria-label="Toggle menu"
            >
              <svg className="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                {mobileNavOpen ? (
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                ) : (
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                )}
              </svg>
            </button>
          </div>
        </div>

        {mobileNavOpen && (
          <div className="sm:hidden border-t border-slate-200 dark:border-white/10 py-4 space-y-1 text-sm font-medium">
            {MOBILE_ITEMS.map((item) => {
              const active = item.match(pathname);
              return (
                <Link
                  key={item.href}
                  href={item.href}
                  onClick={() => setMobileNavOpen(false)}
                  className={`block px-3 py-2 rounded-lg transition-all duration-300 ease-out ${
                    active
                      ? "bg-gradient-to-r from-pink-500/10 to-fuchsia-400/10 text-slate-900 dark:text-white"
                      : "text-slate-600 dark:text-slate-400 hover:bg-gradient-to-r hover:from-pink-500/10 hover:to-fuchsia-400/10 hover:text-slate-900 dark:hover:text-white"
                  }`}
                >
                  {item.label}
                </Link>
              );
            })}
          </div>
        )}
      </div>
    </header>
  );
}
