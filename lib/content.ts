import fs from "fs";
import path from "path";
import { slugify } from "./format";
import { getRepoFile, putRepoFile } from "./github";
import { POST_TYPE_ARTICLE, POST_TYPE_VIDEO, type PostType } from "./post-types";

export { POST_TYPE_ARTICLE, POST_TYPE_VIDEO, type PostType } from "./post-types";

const DATA_PATH = path.join(process.cwd(), "lib", "data", "content.json");
const DATA_REPO_PATH = "lib/data/content.json";

type RawSiteSettings = {
  id: number;
  headline: string;
  tagline: string;
  hero_description: string;
  avatar_path: string | null;
  avatar_position_x: number;
  avatar_position_y: number;
  email: string | null;
  github_url: string | null;
  linkedin_url: string | null;
  twitter_url: string | null;
  telegram_url: string | null;
  created_at: string;
  updated_at: string;
};

type RawProject = {
  id: number;
  title: string;
  slug: string;
  summary: string;
  description: string | null;
  features: string | null;
  image: string | null;
  tech_stack: string | null;
  project_url: string | null;
  repo_url: string | null;
  is_featured: boolean;
  sort_order: number;
  created_at: string;
  updated_at: string;
};

type RawPost = {
  id: number;
  title: string;
  slug: string;
  excerpt: string | null;
  body: string;
  cover_image: string | null;
  video_url: string | null;
  type: PostType;
  is_published: boolean;
  published_at: string | null;
  created_at: string;
  updated_at: string;
};

type RawSkill = {
  id: number;
  name: string;
  category: string;
  level: number;
  sort_order: number;
  created_at: string;
  updated_at: string;
};

type RawExperience = {
  id: number;
  title: string;
  company: string;
  start_label: string;
  end_label: string | null;
  highlights: string | null;
  sort_order: number;
  created_at: string;
  updated_at: string;
};

type RawContent = {
  siteSettings: RawSiteSettings;
  projects: RawProject[];
  posts: RawPost[];
  skills: RawSkill[];
  experiences: RawExperience[];
};

export type SiteSettings = {
  headline: string;
  tagline: string;
  heroDescription: string;
  avatarPath: string | null;
  avatarPositionX: number;
  avatarPositionY: number;
  email: string | null;
  githubUrl: string | null;
  linkedinUrl: string | null;
  twitterUrl: string | null;
  telegramUrl: string | null;
};

export type Project = {
  id: number;
  title: string;
  slug: string;
  summary: string;
  description: string | null;
  features: string | null;
  image: string | null;
  techStack: string | null;
  projectUrl: string | null;
  repoUrl: string | null;
  isFeatured: boolean;
  sortOrder: number;
};

export type Post = {
  id: number;
  title: string;
  slug: string;
  excerpt: string | null;
  body: string;
  coverImage: string | null;
  videoUrl: string | null;
  type: PostType;
  isPublished: boolean;
  publishedAt: string | null;
};

export type Skill = {
  id: number;
  name: string;
  category: string;
  level: number;
  sortOrder: number;
};

export type Experience = {
  id: number;
  title: string;
  company: string;
  startLabel: string;
  endLabel: string | null;
  highlights: string | null;
  sortOrder: number;
};

function readRaw(): RawContent {
  const text = fs.readFileSync(DATA_PATH, "utf-8");
  return JSON.parse(text) as RawContent;
}

/**
 * Loads content for the admin panel (reads used to populate a mutation, or to render
 * admin pages). On a deployed instance (GITHUB_TOKEN set), reads the latest committed
 * version from GitHub rather than the bundled file — so admin pages and saves reflect the
 * most recent change even before this deployment's redeploy has finished.
 */
async function readAdminContent(): Promise<RawContent> {
  if (process.env.GITHUB_TOKEN) {
    const file = await getRepoFile(DATA_REPO_PATH);
    if (!file) throw new Error(`${DATA_REPO_PATH} not found in the repo.`);
    return JSON.parse(file.content) as RawContent;
  }
  return readRaw();
}

/**
 * Persists a mutation. Locally this writes lib/data/content.json to disk directly.
 * On a deployed instance it commits the file to GitHub instead (Vercel's serverless
 * filesystem is read-only) — that commit triggers a normal auto-redeploy, so the change
 * goes live a minute or two later rather than instantly.
 */
async function saveAfterMutation(data: RawContent, message: string): Promise<void> {
  const json = JSON.stringify(data, null, 4) + "\n";

  if (process.env.GITHUB_TOKEN) {
    const existing = await getRepoFile(DATA_REPO_PATH);
    await putRepoFile(DATA_REPO_PATH, json, message, existing?.sha);
    return;
  }

  try {
    fs.writeFileSync(DATA_PATH, json, "utf-8");
  } catch {
    throw new Error(
      "Could not save. Locally this writes to disk; on a deployed instance, set GITHUB_TOKEN (and optionally GITHUB_REPO) so saves commit to GitHub instead — see README.",
    );
  }
}

function nextId(items: { id: number }[]): number {
  return items.reduce((max, item) => Math.max(max, item.id), 0) + 1;
}

function uniqueSlug(base: string, taken: Set<string>): string {
  const root = slugify(base) || "untitled";
  let slug = root;
  let i = 1;
  while (taken.has(slug)) {
    slug = `${root}-${i}`;
    i++;
  }
  return slug;
}

function toSettings(s: RawSiteSettings): SiteSettings {
  return {
    headline: s.headline,
    tagline: s.tagline,
    heroDescription: s.hero_description,
    avatarPath: s.avatar_path,
    avatarPositionX: s.avatar_position_x,
    avatarPositionY: s.avatar_position_y,
    email: s.email,
    githubUrl: s.github_url,
    linkedinUrl: s.linkedin_url,
    twitterUrl: s.twitter_url,
    telegramUrl: s.telegram_url,
  };
}

function toProject(p: RawProject): Project {
  return {
    id: p.id,
    title: p.title,
    slug: p.slug,
    summary: p.summary,
    description: p.description,
    features: p.features,
    image: p.image,
    techStack: p.tech_stack,
    projectUrl: p.project_url,
    repoUrl: p.repo_url,
    isFeatured: p.is_featured,
    sortOrder: p.sort_order,
  };
}

function toPost(p: RawPost): Post {
  return {
    id: p.id,
    title: p.title,
    slug: p.slug,
    excerpt: p.excerpt,
    body: p.body,
    coverImage: p.cover_image,
    videoUrl: p.video_url,
    type: p.type,
    isPublished: p.is_published,
    publishedAt: p.published_at,
  };
}

function toSkill(s: RawSkill): Skill {
  return { id: s.id, name: s.name, category: s.category, level: s.level, sortOrder: s.sort_order };
}

function toExperience(e: RawExperience): Experience {
  return {
    id: e.id,
    title: e.title,
    company: e.company,
    startLabel: e.start_label,
    endLabel: e.end_label,
    highlights: e.highlights,
    sortOrder: e.sort_order,
  };
}

// ---- Public read queries (used by the public site) ----

export function getSiteSettings(): SiteSettings {
  return toSettings(readRaw().siteSettings);
}

export function avatarUrl(s: { avatarPath: string | null }): string | null {
  if (!s.avatarPath) return null;
  return s.avatarPath.startsWith("http") ? s.avatarPath : `/${s.avatarPath.replace(/^\/+/, "")}`;
}

export function getFeaturedProjects(limit = 3): Project[] {
  return getAllProjects()
    .filter((p) => p.isFeatured)
    .slice(0, limit);
}

export function getAllProjects(): Project[] {
  return [...readRaw().projects]
    .sort((a, b) => a.sort_order - b.sort_order || b.id - a.id)
    .map(toProject);
}

export function getProjectBySlug(slug: string): Project | null {
  const raw = readRaw().projects.find((p) => p.slug === slug);
  return raw ? toProject(raw) : null;
}

function publishedPosts(): RawPost[] {
  return readRaw().posts.filter((p) => p.is_published);
}

export function getLatestArticles(limit = 3): Post[] {
  return publishedPosts()
    .filter((p) => p.type === POST_TYPE_ARTICLE)
    .sort((a, b) => (b.published_at ?? "").localeCompare(a.published_at ?? ""))
    .slice(0, limit)
    .map(toPost);
}

export function getArticles(page = 1, perPage = 6): Post[] {
  const articles = publishedPosts()
    .filter((p) => p.type === POST_TYPE_ARTICLE)
    .sort((a, b) => (b.published_at ?? "").localeCompare(a.published_at ?? ""));
  return articles.slice((page - 1) * perPage, (page - 1) * perPage + perPage).map(toPost);
}

export function getVideoPosts(page = 1, perPage = 6): Post[] {
  const videos = publishedPosts()
    .filter((p) => p.type === POST_TYPE_VIDEO)
    .sort((a, b) => (b.published_at ?? "").localeCompare(a.published_at ?? ""));
  return videos.slice((page - 1) * perPage, (page - 1) * perPage + perPage).map(toPost);
}

export function getPostBySlug(slug: string): Post | null {
  const raw = publishedPosts().find((p) => p.slug === slug);
  return raw ? toPost(raw) : null;
}

export function getAllPosts(): Post[] {
  return publishedPosts()
    .sort((a, b) => (b.published_at ?? "").localeCompare(a.published_at ?? ""))
    .map(toPost);
}

export function getSkills(): Skill[] {
  return [...readRaw().skills]
    .sort((a, b) => a.sort_order - b.sort_order || a.name.localeCompare(b.name))
    .map(toSkill);
}

export function getExperiences(): Experience[] {
  return [...readRaw().experiences]
    .sort((a, b) => a.sort_order - b.sort_order || b.id - a.id)
    .map(toExperience);
}

// ---- Admin read queries ----
// These read the latest content — on a deployed instance (GITHUB_TOKEN set), that means
// fetching from GitHub directly rather than this deployment's bundled file, so the admin
// panel never shows stale data while waiting for a save's redeploy to finish. The public
// site functions above intentionally don't do this — they stay fast and read the bundle.

export async function getAllProjectsForAdmin(): Promise<Project[]> {
  const raw = await readAdminContent();
  return [...raw.projects].sort((a, b) => a.sort_order - b.sort_order || b.id - a.id).map(toProject);
}

export async function getAllPostsForAdmin(): Promise<Post[]> {
  const raw = await readAdminContent();
  return [...raw.posts].sort((a, b) => b.created_at.localeCompare(a.created_at)).map(toPost);
}

export async function getSkillsForAdmin(): Promise<Skill[]> {
  const raw = await readAdminContent();
  return [...raw.skills].sort((a, b) => a.sort_order - b.sort_order || a.name.localeCompare(b.name)).map(toSkill);
}

export async function getExperiencesForAdmin(): Promise<Experience[]> {
  const raw = await readAdminContent();
  return [...raw.experiences].sort((a, b) => a.sort_order - b.sort_order || b.id - a.id).map(toExperience);
}

export async function getSiteSettingsForAdmin(): Promise<SiteSettings> {
  const raw = await readAdminContent();
  return toSettings(raw.siteSettings);
}

export async function getProjectById(id: number): Promise<Project | null> {
  const raw = (await readAdminContent()).projects.find((p) => p.id === id);
  return raw ? toProject(raw) : null;
}

export async function getPostById(id: number): Promise<Post | null> {
  const raw = (await readAdminContent()).posts.find((p) => p.id === id);
  return raw ? toPost(raw) : null;
}

export async function getSkillById(id: number): Promise<Skill | null> {
  const raw = (await readAdminContent()).skills.find((s) => s.id === id);
  return raw ? toSkill(raw) : null;
}

export async function getExperienceById(id: number): Promise<Experience | null> {
  const raw = (await readAdminContent()).experiences.find((e) => e.id === id);
  return raw ? toExperience(raw) : null;
}

export async function getDashboardStats() {
  const raw = await readAdminContent();
  return {
    projects: raw.projects.length,
    posts: raw.posts.length,
    skills: raw.skills.length,
    experiences: raw.experiences.length,
  };
}

// ---- Mutations (admin only — writes lib/data/content.json to disk) ----

export type ProjectInput = {
  title: string;
  summary: string;
  description: string | null;
  features: string | null;
  image: string | null;
  techStack: string | null;
  projectUrl: string | null;
  repoUrl: string | null;
  isFeatured: boolean;
  sortOrder: number;
};

export async function createProject(data: ProjectInput): Promise<Project> {
  const raw = await readAdminContent();
  const now = new Date().toISOString();
  const slug = uniqueSlug(data.title, new Set(raw.projects.map((p) => p.slug)));
  const record: RawProject = {
    id: nextId(raw.projects),
    title: data.title,
    slug,
    summary: data.summary,
    description: data.description,
    features: data.features,
    image: data.image,
    tech_stack: data.techStack,
    project_url: data.projectUrl,
    repo_url: data.repoUrl,
    is_featured: data.isFeatured,
    sort_order: data.sortOrder,
    created_at: now,
    updated_at: now,
  };
  raw.projects.push(record);
  await saveAfterMutation(raw, `Add project: ${data.title}`);
  return toProject(record);
}

export async function updateProject(id: number, data: ProjectInput): Promise<Project> {
  const raw = await readAdminContent();
  const existing = raw.projects.find((p) => p.id === id);
  if (!existing) throw new Error("Project not found.");

  const slug =
    existing.title !== data.title
      ? uniqueSlug(data.title, new Set(raw.projects.filter((p) => p.id !== id).map((p) => p.slug)))
      : existing.slug;

  Object.assign(existing, {
    title: data.title,
    slug,
    summary: data.summary,
    description: data.description,
    features: data.features,
    image: data.image,
    tech_stack: data.techStack,
    project_url: data.projectUrl,
    repo_url: data.repoUrl,
    is_featured: data.isFeatured,
    sort_order: data.sortOrder,
    updated_at: new Date().toISOString(),
  });

  await saveAfterMutation(raw, `Update project: ${data.title}`);
  return toProject(existing);
}

export async function deleteProject(id: number): Promise<void> {
  const raw = await readAdminContent();
  const existing = raw.projects.find((p) => p.id === id);
  raw.projects = raw.projects.filter((p) => p.id !== id);
  await saveAfterMutation(raw, `Delete project: ${existing?.title ?? id}`);
}

export type PostInput = {
  title: string;
  excerpt: string | null;
  body: string;
  coverImage: string | null;
  videoUrl: string | null;
  type: PostType;
  isPublished: boolean;
  publishedAt: string | null;
};

function resolvePublishedAt(data: PostInput, existing: string | null): string | null {
  if (data.publishedAt) return new Date(data.publishedAt).toISOString();
  if (data.isPublished) return existing ?? new Date().toISOString();
  return existing;
}

export async function createPost(data: PostInput): Promise<Post> {
  const raw = await readAdminContent();
  const now = new Date().toISOString();
  const slug = uniqueSlug(data.title, new Set(raw.posts.map((p) => p.slug)));
  const record: RawPost = {
    id: nextId(raw.posts),
    title: data.title,
    slug,
    excerpt: data.excerpt,
    body: data.body,
    cover_image: data.coverImage,
    video_url: data.videoUrl,
    type: data.type,
    is_published: data.isPublished,
    published_at: resolvePublishedAt(data, null),
    created_at: now,
    updated_at: now,
  };
  raw.posts.push(record);
  await saveAfterMutation(raw, `Add post: ${data.title}`);
  return toPost(record);
}

export async function updatePost(id: number, data: PostInput): Promise<Post> {
  const raw = await readAdminContent();
  const existing = raw.posts.find((p) => p.id === id);
  if (!existing) throw new Error("Post not found.");

  const slug =
    existing.title !== data.title
      ? uniqueSlug(data.title, new Set(raw.posts.filter((p) => p.id !== id).map((p) => p.slug)))
      : existing.slug;

  Object.assign(existing, {
    title: data.title,
    slug,
    excerpt: data.excerpt,
    body: data.body,
    cover_image: data.coverImage,
    video_url: data.videoUrl,
    type: data.type,
    is_published: data.isPublished,
    published_at: resolvePublishedAt(data, existing.published_at),
    updated_at: new Date().toISOString(),
  });

  await saveAfterMutation(raw, `Update post: ${data.title}`);
  return toPost(existing);
}

export async function deletePost(id: number): Promise<void> {
  const raw = await readAdminContent();
  const existing = raw.posts.find((p) => p.id === id);
  raw.posts = raw.posts.filter((p) => p.id !== id);
  await saveAfterMutation(raw, `Delete post: ${existing?.title ?? id}`);
}

export type SkillInput = { name: string; category: string; level: number; sortOrder: number };

export async function createSkill(data: SkillInput): Promise<Skill> {
  const raw = await readAdminContent();
  const now = new Date().toISOString();
  const record: RawSkill = {
    id: nextId(raw.skills),
    name: data.name,
    category: data.category,
    level: data.level,
    sort_order: data.sortOrder,
    created_at: now,
    updated_at: now,
  };
  raw.skills.push(record);
  await saveAfterMutation(raw, `Add skill: ${data.name}`);
  return toSkill(record);
}

export async function updateSkill(id: number, data: SkillInput): Promise<Skill> {
  const raw = await readAdminContent();
  const existing = raw.skills.find((s) => s.id === id);
  if (!existing) throw new Error("Skill not found.");
  Object.assign(existing, {
    name: data.name,
    category: data.category,
    level: data.level,
    sort_order: data.sortOrder,
    updated_at: new Date().toISOString(),
  });
  await saveAfterMutation(raw, `Update skill: ${data.name}`);
  return toSkill(existing);
}

export async function deleteSkill(id: number): Promise<void> {
  const raw = await readAdminContent();
  const existing = raw.skills.find((s) => s.id === id);
  raw.skills = raw.skills.filter((s) => s.id !== id);
  await saveAfterMutation(raw, `Delete skill: ${existing?.name ?? id}`);
}

export type ExperienceInput = {
  title: string;
  company: string;
  startLabel: string;
  endLabel: string | null;
  highlights: string | null;
  sortOrder: number;
};

export async function createExperience(data: ExperienceInput): Promise<Experience> {
  const raw = await readAdminContent();
  const now = new Date().toISOString();
  const record: RawExperience = {
    id: nextId(raw.experiences),
    title: data.title,
    company: data.company,
    start_label: data.startLabel,
    end_label: data.endLabel,
    highlights: data.highlights,
    sort_order: data.sortOrder,
    created_at: now,
    updated_at: now,
  };
  raw.experiences.push(record);
  await saveAfterMutation(raw, `Add experience: ${data.title}`);
  return toExperience(record);
}

export async function updateExperience(id: number, data: ExperienceInput): Promise<Experience> {
  const raw = await readAdminContent();
  const existing = raw.experiences.find((e) => e.id === id);
  if (!existing) throw new Error("Experience not found.");
  Object.assign(existing, {
    title: data.title,
    company: data.company,
    start_label: data.startLabel,
    end_label: data.endLabel,
    highlights: data.highlights,
    sort_order: data.sortOrder,
    updated_at: new Date().toISOString(),
  });
  await saveAfterMutation(raw, `Update experience: ${data.title}`);
  return toExperience(existing);
}

export async function deleteExperience(id: number): Promise<void> {
  const raw = await readAdminContent();
  const existing = raw.experiences.find((e) => e.id === id);
  raw.experiences = raw.experiences.filter((e) => e.id !== id);
  await saveAfterMutation(raw, `Delete experience: ${existing?.title ?? id}`);
}

export type SiteSettingsInput = {
  headline: string;
  tagline: string;
  heroDescription: string;
  email: string | null;
  githubUrl: string | null;
  linkedinUrl: string | null;
  twitterUrl: string | null;
  telegramUrl: string | null;
  avatarPositionX: number;
  avatarPositionY: number;
  avatarPath: string | null;
};

export async function updateSiteSettings(data: SiteSettingsInput): Promise<SiteSettings> {
  const raw = await readAdminContent();
  raw.siteSettings = {
    ...raw.siteSettings,
    headline: data.headline,
    tagline: data.tagline,
    hero_description: data.heroDescription,
    email: data.email,
    github_url: data.githubUrl,
    linkedin_url: data.linkedinUrl,
    twitter_url: data.twitterUrl,
    telegram_url: data.telegramUrl,
    avatar_position_x: data.avatarPositionX,
    avatar_position_y: data.avatarPositionY,
    avatar_path: data.avatarPath,
    updated_at: new Date().toISOString(),
  };
  await saveAfterMutation(raw, "Update site settings");
  return toSettings(raw.siteSettings);
}

/**
 * Saves an uploaded avatar image. Locally this writes to public/avatars/ on disk.
 * On a deployed instance it commits the file to GitHub (same as saveAfterMutation) —
 * the new avatar goes live once that commit's auto-redeploy finishes.
 */
export async function saveAvatarFile(filename: string, buffer: Buffer): Promise<void> {
  if (process.env.GITHUB_TOKEN) {
    await putRepoFile(`public/avatars/${filename}`, buffer, `Update avatar: ${filename}`);
    return;
  }

  const dir = path.join(process.cwd(), "public", "avatars");
  fs.mkdirSync(dir, { recursive: true });
  fs.writeFileSync(path.join(dir, filename), buffer);
}
