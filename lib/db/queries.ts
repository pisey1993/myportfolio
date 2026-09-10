import { and, desc, eq, isNull } from "drizzle-orm";
import { db } from "./client";
import {
  adminUsers,
  contactMessages,
  experiences,
  POST_TYPE_ARTICLE,
  POST_TYPE_VIDEO,
  posts,
  projects,
  siteSettings,
  skills,
} from "./schema";

export async function getSiteSettings() {
  const [row] = await db.select().from(siteSettings).limit(1);
  if (row) return row;

  // Mirrors SiteSetting::current()'s firstOrCreate behavior.
  const [created] = await db
    .insert(siteSettings)
    .values({
      headline: "Portfolio",
      tagline: "Software Developer",
      heroDescription:
        "A software developer building web applications. I enjoy turning ideas into clean, working products.",
    })
    .returning();

  if (!created) {
    throw new Error("Failed to create default site settings row.");
  }

  return created;
}

export function avatarUrl(settings: { avatarPath: string | null }): string | null {
  if (!settings.avatarPath) return null;
  return settings.avatarPath.startsWith("http")
    ? settings.avatarPath
    : `/${settings.avatarPath.replace(/^\/+/, "")}`;
}

export async function getFeaturedProjects(limit = 3) {
  return db
    .select()
    .from(projects)
    .where(eq(projects.isFeatured, true))
    .orderBy(projects.sortOrder, desc(projects.id))
    .limit(limit);
}

export async function getAllProjects() {
  return db.select().from(projects).orderBy(projects.sortOrder, desc(projects.id));
}

export async function getProjectBySlug(slug: string) {
  const [row] = await db.select().from(projects).where(eq(projects.slug, slug)).limit(1);
  return row ?? null;
}

function publishedFilter() {
  return and(eq(posts.isPublished, true));
}

export async function getLatestArticles(limit = 3) {
  return db
    .select()
    .from(posts)
    .where(and(eq(posts.isPublished, true), eq(posts.type, POST_TYPE_ARTICLE)))
    .orderBy(desc(posts.publishedAt))
    .limit(limit);
}

export async function getArticles(page = 1, perPage = 6) {
  return db
    .select()
    .from(posts)
    .where(and(eq(posts.isPublished, true), eq(posts.type, POST_TYPE_ARTICLE)))
    .orderBy(desc(posts.publishedAt))
    .limit(perPage)
    .offset((page - 1) * perPage);
}

export async function getVideoPosts(page = 1, perPage = 6) {
  return db
    .select()
    .from(posts)
    .where(and(eq(posts.isPublished, true), eq(posts.type, POST_TYPE_VIDEO)))
    .orderBy(desc(posts.publishedAt))
    .limit(perPage)
    .offset((page - 1) * perPage);
}

export async function getPostBySlug(slug: string) {
  const [row] = await db
    .select()
    .from(posts)
    .where(and(eq(posts.slug, slug), publishedFilter()))
    .limit(1);
  return row ?? null;
}

export async function getSkills() {
  return db.select().from(skills).orderBy(skills.sortOrder, skills.name);
}

export async function getExperiences() {
  return db.select().from(experiences).orderBy(experiences.sortOrder, desc(experiences.id));
}

export async function getUnreadMessageCount() {
  const rows = await db.select().from(contactMessages).where(isNull(contactMessages.readAt));
  return rows.length;
}

export async function getDashboardStats() {
  const [projectRows, postRows, skillRows] = await Promise.all([
    db.select().from(projects),
    db.select().from(posts),
    db.select().from(skills),
  ]);
  const unreadMessages = await getUnreadMessageCount();

  return {
    projects: projectRows.length,
    posts: postRows.length,
    skills: skillRows.length,
    unreadMessages,
  };
}

export async function getRecentMessages(limit = 5) {
  return db.select().from(contactMessages).orderBy(desc(contactMessages.createdAt)).limit(limit);
}

export async function getAllMessages() {
  return db.select().from(contactMessages).orderBy(desc(contactMessages.createdAt));
}

export async function getMessageById(id: number) {
  const [row] = await db.select().from(contactMessages).where(eq(contactMessages.id, id)).limit(1);
  return row ?? null;
}

export async function findAdminByEmail(email: string) {
  const [row] = await db.select().from(adminUsers).where(eq(adminUsers.email, email)).limit(1);
  return row ?? null;
}
