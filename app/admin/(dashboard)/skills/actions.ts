"use server";

import { z } from "zod";
import { redirect } from "next/navigation";
import { revalidatePath } from "next/cache";
import {
  createSkill as createSkillRecord,
  updateSkill as updateSkillRecord,
  deleteSkill as deleteSkillRecord,
} from "@/lib/content";

const schema = z.object({
  name: z.string().min(1).max(255),
  category: z.string().min(1).max(255),
  level: z.coerce.number().int().min(0).max(100),
  sortOrder: z.coerce.number().int().optional(),
});

function parse(formData: FormData) {
  const data = schema.parse({
    name: formData.get("name"),
    category: formData.get("category"),
    level: formData.get("level"),
    sortOrder: formData.get("sortOrder") || 0,
  });
  return { ...data, sortOrder: data.sortOrder ?? 0 };
}

export async function createSkill(formData: FormData) {
  await createSkillRecord(parse(formData));
  revalidatePath("/admin/skills");
  revalidatePath("/", "layout");
  redirect("/admin/skills");
}

export async function updateSkill(id: number, formData: FormData) {
  await updateSkillRecord(id, parse(formData));
  revalidatePath("/admin/skills");
  revalidatePath("/", "layout");
  redirect("/admin/skills");
}

export async function deleteSkill(id: number) {
  await deleteSkillRecord(id);
  revalidatePath("/admin/skills");
  revalidatePath("/", "layout");
}
