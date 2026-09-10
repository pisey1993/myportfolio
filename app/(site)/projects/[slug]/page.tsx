import Link from "next/link";
import { notFound } from "next/navigation";
import { getProjectBySlug } from "@/lib/db/queries";
import MediaPlaceholder from "@/components/site/MediaPlaceholder";

export default async function ProjectShowPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const project = await getProjectBySlug(slug);
  if (!project) notFound();

  const techStack = (project.techStack ?? "").split(",").map((t) => t.trim()).filter(Boolean);
  const features = (project.features ?? "").split("\n").map((f) => f.trim()).filter(Boolean);

  return (
    <article className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
      <Link href="/projects" className="text-sm text-slate-500 hover:text-slate-900 dark:hover:text-white">&larr; All projects</Link>

      <h1 className="mt-4 text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">{project.title}</h1>
      <p className="mt-2 text-slate-600 dark:text-slate-400">{project.summary}</p>

      {(project.projectUrl || project.repoUrl) && (
        <div className="mt-5 flex items-center gap-3">
          {project.projectUrl && (
            <a href={project.projectUrl} target="_blank" rel="noopener" className="inline-flex items-center px-5 py-2.5 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-950 text-sm font-semibold hover:bg-slate-700 dark:hover:bg-slate-200 transition">
              Live site
            </a>
          )}
          {project.repoUrl && (
            <a href={project.repoUrl} target="_blank" rel="noopener" className="inline-flex items-center px-5 py-2.5 rounded-full border border-slate-300 dark:border-white/20 text-sm font-semibold hover:bg-slate-50 dark:hover:bg-white/5 transition">
              Source code
            </a>
          )}
        </div>
      )}

      <div className="mt-8 aspect-video rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10">
        {project.image ? (
          // eslint-disable-next-line @next/next/no-img-element
          <img src={project.image} alt={project.title} className="w-full h-full object-cover" />
        ) : (
          <MediaPlaceholder title={project.title} className="w-full h-full" />
        )}
      </div>

      {techStack.length > 0 && (
        <div className="mt-6 flex flex-wrap gap-2">
          {techStack.map((tech) => (
            <span key={tech} className="px-3 py-1 rounded-full text-xs font-medium bg-slate-100 dark:bg-white/10 text-slate-700 dark:text-slate-300">
              {tech}
            </span>
          ))}
        </div>
      )}

      {project.description && (
        <div className="mt-8 prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 whitespace-pre-line">{project.description}</div>
      )}

      {features.length > 0 && (
        <div className="mt-10">
          <h2 className="text-xl font-bold text-slate-900 dark:text-white mb-4">Key Features</h2>
          <ul className="space-y-2">
            {features.map((feature) => (
              <li key={feature} className="flex items-start gap-2 text-sm text-slate-700 dark:text-slate-300">
                <svg className="w-5 h-5 text-fuchsia-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" strokeWidth={2} viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                {feature}
              </li>
            ))}
          </ul>
        </div>
      )}
    </article>
  );
}
