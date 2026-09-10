import { getSiteSettings } from "@/lib/db/queries";
import { readFlash } from "@/lib/flash";
import Header from "@/components/site/Header";
import Footer from "@/components/site/Footer";
import { ToastRegion } from "@/components/site/Toast";
import ScrollReveal from "@/components/site/ScrollReveal";

export default async function SiteLayout({ children }: { children: React.ReactNode }) {
  const [settings, flash] = await Promise.all([getSiteSettings(), readFlash()]);

  return (
    <>
      <Header headline={settings.headline} />

      <main className="animate__animated animate__fadeIn">{children}</main>

      <ScrollReveal />
      <ToastRegion flash={flash} />

      <Footer
        data={{
          headline: settings.headline,
          tagline: settings.tagline,
          githubUrl: settings.githubUrl,
          linkedinUrl: settings.linkedinUrl,
          twitterUrl: settings.twitterUrl,
          telegramUrl: settings.telegramUrl,
          email: settings.email,
        }}
      />
    </>
  );
}

export const dynamic = "force-dynamic";
