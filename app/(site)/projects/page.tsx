import Link from "next/link";
import { getAllProjects } from "@/lib/db/queries";
import MediaPlaceholder from "@/components/site/MediaPlaceholder";

export default async function ProjectsPage() {
  const projects = await getAllProjects();

  return (
    <>
      <section className="relative overflow-hidden">
        <div className="absolute inset-0 -z-10">
          <div className="absolute top-0 left-1/2 -translate-x-1/2 w-[50rem] h-[20rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full" />
        </div>
        <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-12">
          <p className="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">Portfolio</p>
          <h1 className="text-4xl font-extrabold text-slate-900 dark:text-white">Projects</h1>
          <p className="mt-3 text-slate-600 dark:text-slate-400">Things I&apos;ve built and shipped.</p>
        </div>
      </section>

      <section className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        {projects.length === 0 ? (
          <p className="text-slate-500">No projects yet — check back soon.</p>
        ) : (
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {projects.map((project) => (
              <Link
                key={project.id}
                href={`/projects/${project.slug}`}
                className="group relative block rounded-2xl border border-slate-200 dark:border-white/10 shadow-sm overflow-hidden hover:border-slate-300 dark:hover:border-white/20 hover:shadow-md hover:-translate-y-1 transition duration-300 bg-white dark:bg-slate-900"
              >
                {project.isFeatured && (
                  <span className="absolute top-3 left-3 z-10 px-2 py-1 rounded-full text-[11px] font-semibold bg-slate-900/80 text-white backdrop-blur">
                    Featured
                  </span>
                )}
                <div className="aspect-video overflow-hidden">
                  {project.image ? (
                    // eslint-disable-next-line @next/next/no-img-element
                    <img src={project.image} alt={project.title} className="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
                  ) : (
                    <MediaPlaceholder title={project.title} className="w-full h-full group-hover:scale-105 transition duration-500" />
                  )}
                </div>
                <div className="p-5">
                  <h2 className="font-semibold text-slate-900 dark:text-white group-hover:text-fuchsia-600 dark:group-hover:text-fuchsia-400 transition">{project.title}</h2>
                  <p className="mt-1 text-sm text-slate-600 dark:text-slate-400 line-clamp-2">{project.summary}</p>
                </div>
              </Link>
            ))}
          </div>
        )}
      </section>
    </>
  );
}
