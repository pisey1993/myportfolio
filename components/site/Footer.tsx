import Link from "next/link";
import SocialLinks, { type SocialLinksData } from "./SocialLinks";

type FooterData = SocialLinksData & { headline: string; tagline: string };

export default function Footer({ data }: { data: FooterData }) {
  return (
    <footer className="border-t border-slate-200 dark:border-white/10 mt-24">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div className="flex flex-col sm:flex-row justify-between gap-8">
          <div className="max-w-sm">
            <Link href="/" className="flex items-center gap-2 font-bold text-lg text-slate-900 dark:text-white">
              <span className="w-8 h-8 rounded-full bg-gradient-to-tr from-pink-600 to-fuchsia-400 flex items-center justify-center text-sm">
                {data.headline.slice(0, 1).toUpperCase()}
              </span>
              {data.headline}
            </Link>
            <p className="mt-3 text-sm text-slate-500 dark:text-slate-500">{data.tagline}.</p>
            <SocialLinks links={data} className="mt-5" />
          </div>

          <div>
            <p className="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">Site</p>
            <ul className="space-y-2 text-sm text-slate-600 dark:text-slate-400">
              <li><Link href="/about" className="hover:text-slate-900 dark:hover:text-white">About</Link></li>
              <li><Link href="/projects" className="hover:text-slate-900 dark:hover:text-white">Projects</Link></li>
              <li><Link href="/blog" className="hover:text-slate-900 dark:hover:text-white">Blog</Link></li>
              <li><Link href="/video-blog" className="hover:text-slate-900 dark:hover:text-white">Video Blog</Link></li>
              <li><Link href="/contact" className="hover:text-slate-900 dark:hover:text-white">Contact</Link></li>
            </ul>
          </div>
        </div>

        <div className="mt-12 pt-6 border-t border-slate-200 dark:border-white/10 text-sm text-slate-500">
          &copy; {new Date().getFullYear()} {data.headline}. All rights reserved.
        </div>
      </div>
    </footer>
  );
}
