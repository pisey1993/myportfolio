import type { Metadata } from "next";
import { Figtree } from "next/font/google";
import "./globals.css";

const figtree = Figtree({
  subsets: ["latin"],
  variable: "--font-figtree",
  weight: ["400", "500", "600", "700", "800"],
});

export const metadata: Metadata = {
  title: "Portfolio",
  description: "Personal portfolio, projects, and blog.",
};

const DARK_MODE_BOOT_SCRIPT = `
(function () {
  if (localStorage.getItem('theme') !== 'light') {
    document.documentElement.classList.add('dark');
  }
})();
`;

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en" className={figtree.variable} suppressHydrationWarning>
      <head>
        <script dangerouslySetInnerHTML={{ __html: DARK_MODE_BOOT_SCRIPT }} />
      </head>
      <body className="font-sans antialiased bg-white text-slate-900 dark:bg-slate-950 dark:text-white">
        {children}
      </body>
    </html>
  );
}
