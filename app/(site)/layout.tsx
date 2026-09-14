import { getSiteSettings } from "@/lib/content";
import Header from "@/components/site/Header";
import Footer from "@/components/site/Footer";
import { ToastRegion } from "@/components/site/Toast";
import ScrollReveal from "@/components/site/ScrollReveal";

export default function SiteLayout({ children }: { children: React.ReactNode }) {
  const settings = getSiteSettings();

  return (
    <>
      <Header headline={settings.headline} />

      <main className="animate__animated animate__fadeIn">{children}</main>

      <ScrollReveal />
      <ToastRegion />

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
