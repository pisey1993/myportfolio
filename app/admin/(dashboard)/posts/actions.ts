"use server";

import { z } from "zod";
import { eq } from "drizzle-orm";
import { redirect } from "next/navigation";
import { revalidatePath } from "next/cache";
import { db } from "@/lib/db/client";
import { posts, POST_TYPE_ARTICLE, POST_TYPE_VIDEO } from "@/lib/db/schema";
import { uniquePostSlug } from "@/lib/slug";
import { setFlashCookie } from "@/lib/flash";
import { generatePostFromNews } from "@/lib/gemini";

const schema = z.object({
  title: z.string().min(1).max(255),
  excerpt: z.string().max(255).optional().or(z.literal("")),
  body: z.string().min(1),
  coverImage: z.string().max(2048).optional().or(z.literal("")),
  videoUrl: z.string().max(2048).optional().or(z.literal("")),
  type: z.enum([POST_TYPE_ARTICLE, POST_TYPE_VIDEO]),
  isPublished: z.boolean(),
  publishedAt: z.string().optional().or(z.literal("")),
});

function parse(formData: FormData) {
  return schema.parse({
    title: formData.get("title"),
    excerpt: formData.get("excerpt") ?? "",
    body: formData.get("body"),
    coverImage: formData.get("coverImage") ?? "",
    videoUrl: formData.get("videoUrl") ?? "",
    type: formData.get("type"),
    isPublished: formData.get("isPublished") === "on",
    publishedAt: formData.get("publishedAt") ?? "",
  });
}

function resolvePublishedAt(data: ReturnType<typeof schema.parse>, existingPublishedAt?: Date | null) {
  if (data.publishedAt) return new Date(data.publishedAt);
  if (data.isPublished) return existingPublishedAt ?? new Date();
  return existingPublishedAt ?? null;
}

export async function createPost(formData: FormData) {
  const data = parse(formData);
  const slug = await uniquePostSlug(data.title);

  await db.insert(posts).values({
    ...data,
    slug,
    excerpt: data.excerpt || null,
    coverImage: data.coverImage || null,
    videoUrl: data.videoUrl || null,
    publishedAt: resolvePublishedAt(data),
  });

  await setFlashCookie("Post created.");
  revalidatePath("/admin/posts");
  redirect("/admin/posts");
}

export async function updatePost(id: number, formData: FormData) {
  const data = parse(formData);
  const [existing] = await db.select().from(posts).where(eq(posts.id, id)).limit(1);
  const slug = existing && existing.title !== data.title ? await uniquePostSlug(data.title, id) : existing?.slug;

  await db
    .update(posts)
    .set({
      ...data,
      slug,
      excerpt: data.excerpt || null,
      coverImage: data.coverImage || null,
      videoUrl: data.videoUrl || null,
      publishedAt: resolvePublishedAt(data, existing?.publishedAt),
      updatedAt: new Date(),
    })
    .where(eq(posts.id, id));

  await setFlashCookie("Post updated.");
  revalidatePath("/admin/posts");
  redirect("/admin/posts");
}

export async function deletePost(id: number) {
  await db.delete(posts).where(eq(posts.id, id));
  await setFlashCookie("Post deleted.");
  revalidatePath("/admin/posts");
}

export async function generateAndCreatePost() {
  let data;
  try {
    data = await generatePostFromNews();
  } catch (error) {
    await setFlashCookie(error instanceof Error ? error.message : "Could not generate a post.", "error");
    redirect("/admin/posts");
  }

  const slug = await uniquePostSlug(data.title);
  const [post] = await db
    .insert(posts)
    .values({
      title: data.title,
      slug,
      excerpt: data.excerpt,
      body: data.body,
      coverImage: data.imageUrl,
      type: POST_TYPE_ARTICLE,
      isPublished: false,
    })
    .returning();

  await setFlashCookie("Draft generated. Review and publish when ready.");
  revalidatePath("/admin/posts");
  redirect(`/admin/posts/${post!.id}/edit`);
}
