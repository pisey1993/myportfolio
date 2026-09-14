import { getSiteSettings } from "@/lib/content";
import ContactForm from "@/components/site/ContactForm";

export default function ContactPage() {
  const settings = getSiteSettings();

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
          <ContactForm email={settings.email} />
        </div>
      </div>
    </section>
  );
}
