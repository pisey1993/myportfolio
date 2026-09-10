import { config } from "dotenv";
config({ path: ".env.local" });

import { readFileSync } from "node:fs";
import path from "node:path";
import bcrypt from "bcryptjs";

type ExportedData = {
  siteSettings: Record<string, unknown>;
  projects: Record<string, unknown>[];
  posts: Record<string, unknown>[];
  skills: Record<string, unknown>[];
  experiences: Record<string, unknown>[];
};

async function main() {
  // Dynamic import so DATABASE_URL (loaded above) is set before lib/db/client
  // evaluates it — a static top-level import would be hoisted above config().
  const { db } = await import("../lib/db/client");
  const { adminUsers, experiences, POST_TYPE_ARTICLE, POST_TYPE_VIDEO, posts, projects, siteSettings, skills } =
    await import("../lib/db/schema");

  const dataPath = path.join(process.cwd(), "data-export.json");
  const data: ExportedData = JSON.parse(readFileSync(dataPath, "utf-8"));

  console.log("Seeding site_settings...");
  await db.insert(siteSettings).values({
    headline: data.siteSettings.headline as string,
    tagline: data.siteSettings.tagline as string,
    heroDescription: data.siteSettings.hero_description as string,
    avatarPath: data.siteSettings.avatar_path ? "/avatars/pisey.png" : null,
    avatarPositionX: (data.siteSettings.avatar_position_x as number) ?? 50,
    avatarPositionY: (data.siteSettings.avatar_position_y as number) ?? 50,
    email: (data.siteSettings.email as string) ?? null,
    githubUrl: (data.siteSettings.github_url as string) ?? null,
    linkedinUrl: (data.siteSettings.linkedin_url as string) ?? null,
    twitterUrl: (data.siteSettings.twitter_url as string) ?? null,
    telegramUrl: (data.siteSettings.telegram_url as string) ?? null,
  });

  console.log(`Seeding ${data.projects.length} projects...`);
  for (const p of data.projects) {
    await db.insert(projects).values({
      title: p.title as string,
      slug: p.slug as string,
      summary: p.summary as string,
      description: (p.description as string) ?? null,
      features: (p.features as string) ?? null,
      image: (p.image as string) ?? null,
      techStack: (p.tech_stack as string) ?? null,
      projectUrl: (p.project_url as string) ?? null,
      repoUrl: (p.repo_url as string) ?? null,
      isFeatured: !!p.is_featured,
      sortOrder: (p.sort_order as number) ?? 0,
    });
  }

  console.log(`Seeding ${data.posts.length} posts...`);
  for (const p of data.posts) {
    await db.insert(posts).values({
      title: p.title as string,
      slug: p.slug as string,
      excerpt: (p.excerpt as string) ?? null,
      body: p.body as string,
      coverImage: (p.cover_image as string) ?? null,
      videoUrl: (p.video_url as string) ?? null,
      type: p.type === "video" ? POST_TYPE_VIDEO : POST_TYPE_ARTICLE,
      isPublished: !!p.is_published,
      publishedAt: p.published_at ? new Date(p.published_at as string) : null,
    });
  }

  console.log(`Seeding ${data.skills.length} skills...`);
  for (const s of data.skills) {
    await db.insert(skills).values({
      name: s.name as string,
      category: (s.category as string) ?? "General",
      level: (s.level as number) ?? 80,
      sortOrder: (s.sort_order as number) ?? 0,
    });
  }

  console.log(`Seeding ${data.experiences.length} experiences...`);
  for (const e of data.experiences) {
    await db.insert(experiences).values({
      title: e.title as string,
      company: e.company as string,
      startLabel: e.start_label as string,
      endLabel: (e.end_label as string) ?? null,
      highlights: (e.highlights as string) ?? null,
      sortOrder: (e.sort_order as number) ?? 0,
    });
  }

  const adminEmail = process.env.ADMIN_EMAIL;
  const adminPassword = process.env.ADMIN_PASSWORD;
  if (adminEmail && adminPassword) {
    console.log(`Seeding admin user ${adminEmail}...`);
    const passwordHash = await bcrypt.hash(adminPassword, 10);
    await db.insert(adminUsers).values({ email: adminEmail, passwordHash });
  } else {
    console.warn("ADMIN_EMAIL/ADMIN_PASSWORD not set — skipping admin user creation.");
  }

  console.log("Done.");
  process.exit(0);
}

main().catch((error) => {
  console.error(error);
  process.exit(1);
});
