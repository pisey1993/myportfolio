"use server";

import { z } from "zod";
import { redirect } from "next/navigation";
import { revalidatePath } from "next/cache";
import {
  createProject as createProjectRecord,
  updateProject as updateProjectRecord,
  deleteProject as deleteProjectRecord,
} from "@/lib/content";

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
  const data = schema.parse({
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

  return {
    title: data.title,
    summary: data.summary,
    description: data.description || null,
    features: data.features || null,
    image: data.image || null,
    techStack: data.techStack || null,
    projectUrl: data.projectUrl || null,
    repoUrl: data.repoUrl || null,
    isFeatured: data.isFeatured,
    sortOrder: data.sortOrder ?? 0,
  };
}

export async function createProject(formData: FormData) {
  await createProjectRecord(parse(formData));
  revalidatePath("/admin/projects");
  revalidatePath("/", "layout");
  redirect("/admin/projects");
}

export async function updateProject(id: number, formData: FormData) {
  await updateProjectRecord(id, parse(formData));
  revalidatePath("/admin/projects");
  revalidatePath("/", "layout");
  redirect("/admin/projects");
}

export async function deleteProject(id: number) {
  await deleteProjectRecord(id);
  revalidatePath("/admin/projects");
  revalidatePath("/", "layout");
}
