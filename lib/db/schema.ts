import {
  pgTable,
  serial,
  text,
  varchar,
  boolean,
  integer,
  timestamp,
} from "drizzle-orm/pg-core";

export const siteSettings = pgTable("site_settings", {
  id: serial("id").primaryKey(),
  headline: varchar("headline", { length: 255 }).notNull(),
  tagline: varchar("tagline", { length: 255 }).notNull(),
  heroDescription: text("hero_description").notNull(),
  avatarPath: varchar("avatar_path", { length: 2048 }),
  avatarPositionX: integer("avatar_position_x").notNull().default(50),
  avatarPositionY: integer("avatar_position_y").notNull().default(50),
  email: varchar("email", { length: 255 }),
  githubUrl: varchar("github_url", { length: 2048 }),
  linkedinUrl: varchar("linkedin_url", { length: 2048 }),
  twitterUrl: varchar("twitter_url", { length: 2048 }),
  telegramUrl: varchar("telegram_url", { length: 2048 }),
  updatedAt: timestamp("updated_at").notNull().defaultNow(),
});

export const projects = pgTable("projects", {
  id: serial("id").primaryKey(),
  title: varchar("title", { length: 255 }).notNull(),
  slug: varchar("slug", { length: 255 }).notNull().unique(),
  summary: varchar("summary", { length: 255 }).notNull(),
  description: text("description"),
  features: text("features"),
  image: varchar("image", { length: 2048 }),
  techStack: varchar("tech_stack", { length: 255 }),
  projectUrl: varchar("project_url", { length: 2048 }),
  repoUrl: varchar("repo_url", { length: 2048 }),
  isFeatured: boolean("is_featured").notNull().default(false),
  sortOrder: integer("sort_order").notNull().default(0),
  createdAt: timestamp("created_at").notNull().defaultNow(),
  updatedAt: timestamp("updated_at").notNull().defaultNow(),
});

export const POST_TYPE_ARTICLE = "article" as const;
export const POST_TYPE_VIDEO = "video" as const;
export type PostType = typeof POST_TYPE_ARTICLE | typeof POST_TYPE_VIDEO;

export const posts = pgTable("posts", {
  id: serial("id").primaryKey(),
  title: varchar("title", { length: 255 }).notNull(),
  slug: varchar("slug", { length: 255 }).notNull().unique(),
  excerpt: varchar("excerpt", { length: 255 }),
  body: text("body").notNull(),
  coverImage: varchar("cover_image", { length: 2048 }),
  videoUrl: varchar("video_url", { length: 2048 }),
  type: varchar("type", { length: 20 }).notNull().default(POST_TYPE_ARTICLE),
  isPublished: boolean("is_published").notNull().default(false),
  publishedAt: timestamp("published_at"),
  createdAt: timestamp("created_at").notNull().defaultNow(),
  updatedAt: timestamp("updated_at").notNull().defaultNow(),
});

export const skills = pgTable("skills", {
  id: serial("id").primaryKey(),
  name: varchar("name", { length: 255 }).notNull(),
  category: varchar("category", { length: 255 }).notNull().default("General"),
  level: integer("level").notNull().default(80),
  sortOrder: integer("sort_order").notNull().default(0),
});

export const experiences = pgTable("experiences", {
  id: serial("id").primaryKey(),
  title: varchar("title", { length: 255 }).notNull(),
  company: varchar("company", { length: 255 }).notNull(),
  startLabel: varchar("start_label", { length: 255 }).notNull(),
  endLabel: varchar("end_label", { length: 255 }),
  highlights: text("highlights"),
  sortOrder: integer("sort_order").notNull().default(0),
});

export const contactMessages = pgTable("contact_messages", {
  id: serial("id").primaryKey(),
  name: varchar("name", { length: 255 }).notNull(),
  email: varchar("email", { length: 255 }).notNull(),
  subject: varchar("subject", { length: 255 }),
  message: text("message").notNull(),
  readAt: timestamp("read_at"),
  createdAt: timestamp("created_at").notNull().defaultNow(),
});

export const adminUsers = pgTable("admin_users", {
  id: serial("id").primaryKey(),
  email: varchar("email", { length: 255 }).notNull().unique(),
  passwordHash: varchar("password_hash", { length: 255 }).notNull(),
});
