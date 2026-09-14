"use server";

import { z } from "zod";
import { redirect } from "next/navigation";
import { revalidatePath } from "next/cache";
import {
  createExperience as createExperienceRecord,
  updateExperience as updateExperienceRecord,
  deleteExperience as deleteExperienceRecord,
} from "@/lib/content";

const schema = z.object({
  title: z.string().min(1).max(255),
  company: z.string().min(1).max(255),
  startLabel: z.string().min(1).max(255),
  endLabel: z.string().max(255).optional().or(z.literal("")),
  highlights: z.string().optional().or(z.literal("")),
  sortOrder: z.coerce.number().int().optional(),
});

function parse(formData: FormData) {
  const data = schema.parse({
    title: formData.get("title"),
    company: formData.get("company"),
    startLabel: formData.get("startLabel"),
    endLabel: formData.get("endLabel") ?? "",
    highlights: formData.get("highlights") ?? "",
    sortOrder: formData.get("sortOrder") || 0,
  });

  return {
    title: data.title,
    company: data.company,
    startLabel: data.startLabel,
    endLabel: data.endLabel || null,
    highlights: data.highlights || null,
    sortOrder: data.sortOrder ?? 0,
  };
}

export async function createExperience(formData: FormData) {
  await createExperienceRecord(parse(formData));
  revalidatePath("/admin/experiences");
  revalidatePath("/", "layout");
  redirect("/admin/experiences");
}

export async function updateExperience(id: number, formData: FormData) {
  await updateExperienceRecord(id, parse(formData));
  revalidatePath("/admin/experiences");
  revalidatePath("/", "layout");
  redirect("/admin/experiences");
}

export async function deleteExperience(id: number) {
  await deleteExperienceRecord(id);
  revalidatePath("/admin/experiences");
  revalidatePath("/", "layout");
}
