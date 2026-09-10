import { getSiteSettings, getExperiences, getSkills, avatarUrl } from "@/lib/db/queries";
import Avatar from "@/components/site/Avatar";
import SocialLinks from "@/components/site/SocialLinks";

const RESPONSIBILITIES = [
  "Leading enterprise IT strategy and the internal technology team",
  "Owning the Insurance Core System, CRM, customer portal, and agent portal architecture, uptime, and roadmap",
  "Designing and shipping AI-powered features, including a Google Gemini assistant and automated market intelligence reporting",
  "Translating business problems into coding solutions using AI coding tools",
  "Auditing support request flows and designing the IT Service Level Agreement (SLA) framework",
  "Building and mentoring development teams",
  "Bridging business stakeholders and technical teams",
  "Managing the IT Support Request System end to end",
];

export default async function AboutPage() {
  const [settings, experiences, skills] = await Promise.all([
    getSiteSettings(),
    getExperiences(),
    getSkills(),
  ]);

  return (
    <section className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
      <div className="anim-stagger flex flex-col sm:flex-row items-start gap-8">
        <Avatar
          size="md"
          data={{
            headline: settings.headline,
            avatarUrl: avatarUrl(settings),
            avatarPositionX: settings.avatarPositionX,
            avatarPositionY: settings.avatarPositionY,
          }}
        />
        <div>
          <p className="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">About</p>
          <h1 className="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">Hi, I&apos;m {settings.headline}</h1>
          <div className="mt-5 space-y-4 text-slate-600 dark:text-slate-400 whitespace-pre-line">{settings.heroDescription}</div>

          <ul className="mt-6 space-y-2">
            {RESPONSIBILITIES.map((item) => (
              <li key={item} className="flex items-start gap-2 text-sm text-slate-700 dark:text-slate-300">
                <svg className="w-5 h-5 text-fuchsia-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" strokeWidth={2} viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                {item}
              </li>
            ))}
          </ul>

          <SocialLinks links={settings} className="mt-6" />
        </div>
      </div>

      {experiences.length > 0 && (
        <div className="mt-20">
          <h2 className="text-2xl font-bold text-slate-900 dark:text-white mb-8">Experience</h2>
          <div className="relative pl-8">
            <div className="absolute left-[7px] top-2 bottom-2 w-px bg-slate-200 dark:bg-white/10" />
            <div className="space-y-10">
              {experiences.map((exp) => {
                const isCurrent = !exp.endLabel;
                return (
                  <div key={exp.id} className="relative">
                    <span
                      className={`absolute -left-8 top-1.5 w-3.5 h-3.5 rounded-full border-2 ${
                        isCurrent ? "bg-fuchsia-500 border-fuchsia-500" : "bg-white dark:bg-slate-950 border-slate-300 dark:border-white/20"
                      }`}
                    />
                    <p className="text-xs text-slate-500">{exp.startLabel} – {exp.endLabel || "Present"}</p>
                    <h3 className="font-semibold text-slate-900 dark:text-white">{exp.title}</h3>
                    <p className="text-sm bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent font-medium">{exp.company}</p>
                    {exp.highlights && (
                      <ul className="mt-2 space-y-1 text-sm text-slate-600 dark:text-slate-400 list-disc list-inside">
                        {exp.highlights.split("\n").filter(Boolean).map((line) => (
                          <li key={line}>{line.trim()}</li>
                        ))}
                      </ul>
                    )}
                  </div>
                );
              })}
            </div>
          </div>
        </div>
      )}

      {skills.length > 0 && (
        <div className="mt-20">
          <h2 className="text-2xl font-bold text-slate-900 dark:text-white mb-8">Skills</h2>
          <div className="grid sm:grid-cols-2 gap-x-8 gap-y-5">
            {skills.map((skill) => (
              <div key={skill.id}>
                <div className="flex justify-between text-sm mb-1">
                  <span className="font-medium text-slate-900 dark:text-white">{skill.name}</span>
                  <span className="text-slate-500">{skill.level}%</span>
                </div>
                <div className="h-1.5 rounded-full bg-slate-100 dark:bg-white/10 overflow-hidden">
                  <div className="h-full rounded-full bg-gradient-to-r from-pink-500 to-fuchsia-400" style={{ width: `${skill.level}%` }} />
                </div>
              </div>
            ))}
          </div>
        </div>
      )}
    </section>
  );
}
