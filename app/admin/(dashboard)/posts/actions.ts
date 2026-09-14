"use server";

import { z } from "zod";
import { redirect } from "next/navigation";
import { revalidatePath } from "next/cache";
import {
  createPost as createPostRecord,
  updatePost as updatePostRecord,
  deletePost as deletePostRecord,
  POST_TYPE_ARTICLE,
  POST_TYPE_VIDEO,
} from "@/lib/content";

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
  const data = schema.parse({
    title: formData.get("title"),
    excerpt: formData.get("excerpt") ?? "",
    body: formData.get("body"),
    coverImage: formData.get("coverImage") ?? "",
    videoUrl: formData.get("videoUrl") ?? "",
    type: formData.get("type"),
    isPublished: formData.get("isPublished") === "on",
    publishedAt: formData.get("publishedAt") ?? "",
  });

  return {
    title: data.title,
    excerpt: data.excerpt || null,
    body: data.body,
    coverImage: data.coverImage || null,
    videoUrl: data.videoUrl || null,
    type: data.type,
    isPublished: data.isPublished,
    publishedAt: data.publishedAt || null,
  };
}

export async function createPost(formData: FormData) {
  await createPostRecord(parse(formData));
  revalidatePath("/admin/posts");
  revalidatePath("/", "layout");
  redirect("/admin/posts");
}

export async function updatePost(id: number, formData: FormData) {
  await updatePostRecord(id, parse(formData));
  revalidatePath("/admin/posts");
  revalidatePath("/", "layout");
  redirect("/admin/posts");
}

export async function deletePost(id: number) {
  await deletePostRecord(id);
  revalidatePath("/admin/posts");
  revalidatePath("/", "layout");
}
