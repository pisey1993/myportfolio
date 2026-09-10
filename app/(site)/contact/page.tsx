import { getSiteSettings } from "@/lib/db/queries";
import { submitContactForm } from "./actions";

export default async function ContactPage() {
  const settings = await getSiteSettings();

  const connectLinks = [
    settings.email && { label: "Email", value: settings.email, href: `mailto:${settings.email}` },
    settings.linkedinUrl && { label: "LinkedIn", value: "Connect on LinkedIn", href: settings.linkedinUrl },
    settings.telegramUrl && { label: "Telegram", value: "Message on Telegram", href: settings.telegramUrl },
    settings.githubUrl && { label: "GitHub", value: "Follow on GitHub", href: settings.githubUrl },
  ].filter(Boolean) as { label: string; value: string; href: string }[];

  return (
    <section className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
      <div className="grid sm:grid-cols-5 gap-12">
        <div className="sm:col-span-2">
          <p className="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">Get in touch</p>
          <h1 className="text-3xl font-extrabold text-slate-900 dark:text-white">Contact</h1>
          <p className="mt-3 text-slate-600 dark:text-slate-400">Have a project in mind or just want to say hi? Reach out.</p>

          <div className="mt-8 space-y-4">
            {connectLinks.map((link) => (
              <a key={link.label} href={link.href} target="_blank" rel="noopener" className="block">
                <p className="text-xs font-semibold text-slate-500 uppercase tracking-wide">{link.label}</p>
                <p className="text-sm text-slate-900 dark:text-white hover:text-fuchsia-600 dark:hover:text-fuchsia-400 transition">{link.value}</p>
              </a>
            ))}
          </div>
        </div>

        <div className="sm:col-span-3">
          <form action={submitContactForm} className="rounded-2xl border border-slate-200 dark:border-white/10 p-6 sm:p-8 space-y-5">
            <div>
              <label htmlFor="name" className="block text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
              <input type="text" name="name" id="name" required maxLength={255} className="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/10 dark:bg-white/5 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 text-sm" />
            </div>
            <div>
              <label htmlFor="email" className="block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
              <input type="email" name="email" id="email" required maxLength={255} className="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/10 dark:bg-white/5 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 text-sm" />
            </div>
            <div>
              <label htmlFor="subject" className="block text-sm font-medium text-slate-700 dark:text-slate-300">Subject</label>
              <input type="text" name="subject" id="subject" maxLength={255} className="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/10 dark:bg-white/5 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 text-sm" />
            </div>
            <div>
              <label htmlFor="message" className="block text-sm font-medium text-slate-700 dark:text-slate-300">Message</label>
              <textarea name="message" id="message" rows={5} required maxLength={5000} className="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/10 dark:bg-white/5 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 text-sm" />
            </div>
            <button type="submit" className="inline-flex items-center px-6 py-3 rounded-full bg-gradient-to-r from-pink-600 to-fuchsia-500 text-white text-sm font-semibold hover:opacity-90 transition">
              Send Message
            </button>
          </form>
        </div>
      </div>
    </section>
  );
}
