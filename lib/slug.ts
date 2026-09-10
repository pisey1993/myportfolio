import { and, eq, ne } from "drizzle-orm";
import { db } from "./db/client";
import { projects, posts } from "./db/schema";
import { slugify } from "./format";

export async function uniqueProjectSlug(title: string, excludeId?: number): Promise<string> {
  const base = slugify(title);
  let slug = base;
  let i = 1;

  while (true) {
    const condition = excludeId ? and(eq(projects.slug, slug), ne(projects.id, excludeId)) : eq(projects.slug, slug);
    const [existing] = await db.select({ id: projects.id }).from(projects).where(condition).limit(1);
    if (!existing) return slug;
    slug = `${base}-${i}`;
    i++;
  }
}

export async function uniquePostSlug(title: string, excludeId?: number): Promise<string> {
  const base = slugify(title);
  let slug = base;
  let i = 1;

  while (true) {
    const condition = excludeId ? and(eq(posts.slug, slug), ne(posts.id, excludeId)) : eq(posts.slug, slug);
    const [existing] = await db.select({ id: posts.id }).from(posts).where(condition).limit(1);
    if (!existing) return slug;
    slug = `${base}-${i}`;
    i++;
  }
}
