import raw from "./data/content.json";

export const POST_TYPE_ARTICLE = "article" as const;
export const POST_TYPE_VIDEO = "video" as const;
export type PostType = typeof POST_TYPE_ARTICLE | typeof POST_TYPE_VIDEO;

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

const settings: SiteSettings = {
  headline: raw.siteSettings.headline,
  tagline: raw.siteSettings.tagline,
  heroDescription: raw.siteSettings.hero_description,
  avatarPath: raw.siteSettings.avatar_path,
  avatarPositionX: raw.siteSettings.avatar_position_x,
  avatarPositionY: raw.siteSettings.avatar_position_y,
  email: raw.siteSettings.email,
  githubUrl: raw.siteSettings.github_url,
  linkedinUrl: raw.siteSettings.linkedin_url,
  twitterUrl: raw.siteSettings.twitter_url,
  telegramUrl: raw.siteSettings.telegram_url,
};

const projects: Project[] = [...raw.projects]
  .map((p) => ({
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
  }))
  .sort((a, b) => a.sortOrder - b.sortOrder || b.id - a.id);

const posts: Post[] = [...raw.posts]
  .map((p) => ({
    id: p.id,
    title: p.title,
    slug: p.slug,
    excerpt: p.excerpt,
    body: p.body,
    coverImage: p.cover_image,
    videoUrl: p.video_url,
    type: p.type as PostType,
    isPublished: p.is_published,
    publishedAt: p.published_at,
  }))
  .filter((p) => p.isPublished)
  .sort((a, b) => (b.publishedAt ?? "").localeCompare(a.publishedAt ?? ""));

const skills: Skill[] = [...raw.skills]
  .map((s) => ({
    id: s.id,
    name: s.name,
    category: s.category,
    level: s.level,
    sortOrder: s.sort_order,
  }))
  .sort((a, b) => a.sortOrder - b.sortOrder || a.name.localeCompare(b.name));

const experiences: Experience[] = [...raw.experiences]
  .map((e) => ({
    id: e.id,
    title: e.title,
    company: e.company,
    startLabel: e.start_label,
    endLabel: e.end_label,
    highlights: e.highlights,
    sortOrder: e.sort_order,
  }))
  .sort((a, b) => a.sortOrder - b.sortOrder || b.id - a.id);

export function getSiteSettings(): SiteSettings {
  return settings;
}

export function avatarUrl(s: { avatarPath: string | null }): string | null {
  if (!s.avatarPath) return null;
  return s.avatarPath.startsWith("http") ? s.avatarPath : `/${s.avatarPath.replace(/^\/+/, "")}`;
}

export function getFeaturedProjects(limit = 3): Project[] {
  return projects.filter((p) => p.isFeatured).slice(0, limit);
}

export function getAllProjects(): Project[] {
  return projects;
}

export function getProjectBySlug(slug: string): Project | null {
  return projects.find((p) => p.slug === slug) ?? null;
}

export function getLatestArticles(limit = 3): Post[] {
  return posts.filter((p) => p.type === POST_TYPE_ARTICLE).slice(0, limit);
}

export function getArticles(page = 1, perPage = 6): Post[] {
  const articles = posts.filter((p) => p.type === POST_TYPE_ARTICLE);
  return articles.slice((page - 1) * perPage, (page - 1) * perPage + perPage);
}

export function getVideoPosts(page = 1, perPage = 6): Post[] {
  const videos = posts.filter((p) => p.type === POST_TYPE_VIDEO);
  return videos.slice((page - 1) * perPage, (page - 1) * perPage + perPage);
}

export function getPostBySlug(slug: string): Post | null {
  return posts.find((p) => p.slug === slug) ?? null;
}

export function getAllPosts(): Post[] {
  return posts;
}

export function getSkills(): Skill[] {
  return skills;
}

export function getExperiences(): Experience[] {
  return experiences;
}
