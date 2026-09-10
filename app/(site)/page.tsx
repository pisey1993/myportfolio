import Link from "next/link";
import { getSiteSettings, getFeaturedProjects, getLatestArticles, getSkills, avatarUrl } from "@/lib/db/queries";
import HeroPhoto from "@/components/site/HeroPhoto";
import SocialLinks from "@/components/site/SocialLinks";
import MediaPlaceholder from "@/components/site/MediaPlaceholder";
import { formatDate } from "@/lib/format";

const SERVICES = [
  {
    title: "IT Leadership & Strategy",
    description: "Leading enterprise technology strategy and modernization initiatives end to end.",
  },
  {
    title: "AI-Powered Development",
    description: "Designing and shipping AI-powered features, from assistants to automated reporting.",
  },
  {
    title: "System Modernization",
    description: "Migrating legacy systems to modern, maintainable web platforms with zero disruption.",
  },
  {
    title: "Business Analysis & Support Ops",
    description: "Translating business problems into working software and well-run support operations.",
  },
];

export default async function HomePage() {
  const [settings, featuredProjects, latestPosts, skills] = await Promise.all([
    getSiteSettings(),
    getFeaturedProjects(3),
    getLatestArticles(3),
    getSkills(),
  ]);

  const avatar = avatarUrl(settings);

  return (
    <>
      <section className="relative overflow-hidden">
        <div className="absolute inset-0 -z-10">
          <div className="absolute top-0 right-0 w-[40rem] h-[40rem] bg-gradient-to-br from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full" />
        </div>
        <div className="anim-stagger grid sm:grid-cols-2 gap-12 items-center max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-20">
          <div>
            <p className="text-sm font-medium bg-gradient-to-r from-pink-500 via-fuchsia-400 to-orange-300 bg-clip-text text-transparent mb-2">
              {settings.tagline}
            </p>
            <h1 className="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white">Hi, I&apos;m {settings.headline}</h1>
            <p className="mt-5 text-slate-600 dark:text-slate-400 max-w-lg">{settings.heroDescription}</p>
            <div className="mt-8 flex items-center gap-3">
              <Link href="/contact" className="group inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-pink-600 to-fuchsia-500 text-white text-sm font-semibold hover:opacity-90 transition">
                Get In Touch
                <span className="inline-block transition-transform group-hover:translate-x-1">→</span>
              </Link>
              <Link href="/projects" className="inline-flex items-center px-6 py-3 rounded-full border border-slate-300 dark:border-white/20 text-sm font-semibold hover:bg-slate-50 dark:hover:bg-white/5 transition">
                View Work
              </Link>
            </div>
            <SocialLinks links={settings} className="mt-8" />
          </div>
          <HeroPhoto
            data={{
              headline: settings.headline,
              avatarUrl: avatar,
              avatarPositionX: settings.avatarPositionX,
              avatarPositionY: settings.avatarPositionY,
            }}
          />
        </div>
      </section>

      {skills.length > 0 && (
        <section className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {SERVICES.map((service) => (
              <div key={service.title} className="relative rounded-2xl border border-slate-200 dark:border-white/10 p-6 overflow-hidden">
                <div className="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-pink-500 to-fuchsia-400" />
                <h3 className="font-semibold text-slate-900 dark:text-white">{service.title}</h3>
                <p className="mt-2 text-sm text-slate-600 dark:text-slate-400">{service.description}</p>
              </div>
            ))}
          </div>
        </section>
      )}

      {featuredProjects.length > 0 && (
        <section className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
          <div className="flex items-end justify-between mb-8">
            <div>
              <p className="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">Selected work</p>
              <h2 className="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">Featured Projects</h2>
            </div>
            <Link href="/projects" className="text-sm font-medium text-fuchsia-600 dark:text-fuchsia-400 hover:text-fuchsia-700 dark:hover:text-fuchsia-300 shrink-0">
              View all →
            </Link>
          </div>
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {featuredProjects.map((project) => (
              <Link
                key={project.id}
                href={`/projects/${project.slug}`}
                className="group block rounded-2xl border border-slate-200 dark:border-white/10 shadow-sm overflow-hidden hover:border-slate-300 dark:hover:border-white/20 hover:shadow-md hover:-translate-y-1 transition duration-300 bg-white dark:bg-slate-900"
              >
                <div className="aspect-video overflow-hidden">
                  {project.image ? (
                    // eslint-disable-next-line @next/next/no-img-element
                    <img src={project.image} alt={project.title} className="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
                  ) : (
                    <MediaPlaceholder title={project.title} className="w-full h-full group-hover:scale-105 transition duration-500" />
                  )}
                </div>
                <div className="p-5">
                  <h3 className="font-semibold text-slate-900 dark:text-white group-hover:text-fuchsia-600 dark:group-hover:text-fuchsia-400 transition">{project.title}</h3>
                  <p className="mt-1 text-sm text-slate-600 dark:text-slate-400 line-clamp-2">{project.summary}</p>
                </div>
              </Link>
            ))}
          </div>
        </section>
      )}

      {latestPosts.length > 0 && (
        <section className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
          <div className="flex items-end justify-between mb-8">
            <div>
              <p className="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">Writing</p>
              <h2 className="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">From the Blog</h2>
            </div>
            <Link href="/blog" className="text-sm font-medium text-fuchsia-600 dark:text-fuchsia-400 hover:text-fuchsia-700 dark:hover:text-fuchsia-300 shrink-0">
              View all →
            </Link>
          </div>
          <div className="grid sm:grid-cols-3 gap-6">
            {latestPosts.map((post) => (
              <Link
                key={post.id}
                href={`/blog/${post.slug}`}
                className="group block rounded-2xl border border-slate-200 dark:border-white/10 shadow-sm overflow-hidden hover:border-slate-300 dark:hover:border-white/20 hover:shadow-md hover:-translate-y-1 transition duration-300 bg-white dark:bg-slate-900"
              >
                <div className="aspect-[16/10] overflow-hidden">
                  {post.coverImage ? (
                    // eslint-disable-next-line @next/next/no-img-element
                    <img src={post.coverImage} alt={post.title} className="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
                  ) : (
                    <MediaPlaceholder title={post.title} className="w-full h-full group-hover:scale-105 transition duration-500" />
                  )}
                </div>
                <div className="p-5">
                  <p className="text-xs text-slate-500 mb-1">{post.publishedAt && formatDate(post.publishedAt, { year: "numeric", month: "short", day: "numeric" })}</p>
                  <h3 className="font-semibold text-slate-900 dark:text-white group-hover:text-fuchsia-600 dark:group-hover:text-fuchsia-400 transition">{post.title}</h3>
                  {post.excerpt && <p className="mt-1 text-sm text-slate-600 dark:text-slate-400 line-clamp-2">{post.excerpt}</p>}
                </div>
              </Link>
            ))}
          </div>
        </section>
      )}

      <section className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <div className="relative rounded-3xl overflow-hidden p-10 sm:p-16 text-center bg-gradient-to-br from-pink-600 via-fuchsia-600 to-orange-500">
          <h2 className="text-2xl sm:text-3xl font-bold text-white">Have a project in mind?</h2>
          <Link href="/contact" className="mt-6 inline-flex items-center px-6 py-3 rounded-full bg-white text-slate-900 text-sm font-semibold hover:bg-slate-100 transition">
            Get in touch
          </Link>
        </div>
      </section>
    </>
  );
}
