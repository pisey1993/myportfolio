"use server";

import { z } from "zod";
import { eq } from "drizzle-orm";
import { redirect } from "next/navigation";
import { revalidatePath } from "next/cache";
import { db } from "@/lib/db/client";
import { projects } from "@/lib/db/schema";
import { uniqueProjectSlug } from "@/lib/slug";
import { setFlashCookie } from "@/lib/flash";

const schema = z.object({
  title: z.string().min(1).max(255),
  summary: z.string().min(1).max(255),
  description: z.string().optional().or(z.literal("")),
  features: z.string().optional().or(z.literal("")),
  image: z.string().max(2048).optional().or(z.literal("")),
  techStack: z.string().max(255).optional().or(z.literal("")),
  projectUrl: z.string().url().max(2048).optional().or(z.literal("")),
  repoUrl: z.string().url().max(2048).optional().or(z.literal("")),
  isFeatured: z.boolean(),
  sortOrder: z.coerce.number().int().optional(),
});

function parse(formData: FormData) {
  return schema.parse({
    title: formData.get("title"),
    summary: formData.get("summary"),
    description: formData.get("description") ?? "",
    features: formData.get("features") ?? "",
    image: formData.get("image") ?? "",
    techStack: formData.get("techStack") ?? "",
    projectUrl: formData.get("projectUrl") ?? "",
    repoUrl: formData.get("repoUrl") ?? "",
    isFeatured: formData.get("isFeatured") === "on",
    sortOrder: formData.get("sortOrder") || 0,
  });
}

export async function createProject(formData: FormData) {
  const data = parse(formData);
  const slug = await uniqueProjectSlug(data.title);

  await db.insert(projects).values({
    ...data,
    slug,
    description: data.description || null,
    features: data.features || null,
    image: data.image || null,
    techStack: data.techStack || null,
    projectUrl: data.projectUrl || null,
    repoUrl: data.repoUrl || null,
    sortOrder: data.sortOrder ?? 0,
  });

  await setFlashCookie("Project created.");
  revalidatePath("/admin/projects");
  redirect("/admin/projects");
}

export async function updateProject(id: number, formData: FormData) {
  const data = parse(formData);
  const [existing] = await db.select().from(projects).where(eq(projects.id, id)).limit(1);
  const slug = existing && existing.title !== data.title ? await uniqueProjectSlug(data.title, id) : existing?.slug;

  await db
    .update(projects)
    .set({
      ...data,
      slug,
      description: data.description || null,
      features: data.features || null,
      image: data.image || null,
      techStack: data.techStack || null,
      projectUrl: data.projectUrl || null,
      repoUrl: data.repoUrl || null,
      sortOrder: data.sortOrder ?? 0,
      updatedAt: new Date(),
    })
    .where(eq(projects.id, id));

  await setFlashCookie("Project updated.");
  revalidatePath("/admin/projects");
  redirect("/admin/projects");
}

export async function deleteProject(id: number) {
  await db.delete(projects).where(eq(projects.id, id));
  await setFlashCookie("Project deleted.");
  revalidatePath("/admin/projects");
}
