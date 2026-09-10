"use server";

import { z } from "zod";
import { eq } from "drizzle-orm";
import { redirect } from "next/navigation";
import { revalidatePath } from "next/cache";
import { db } from "@/lib/db/client";
import { skills } from "@/lib/db/schema";
import { setFlashCookie } from "@/lib/flash";

const schema = z.object({
  name: z.string().min(1).max(255),
  category: z.string().min(1).max(255),
  level: z.coerce.number().int().min(0).max(100),
  sortOrder: z.coerce.number().int().optional(),
});

function parse(formData: FormData) {
  return schema.parse({
    name: formData.get("name"),
    category: formData.get("category"),
    level: formData.get("level"),
    sortOrder: formData.get("sortOrder") || 0,
  });
}

export async function createSkill(formData: FormData) {
  const data = parse(formData);
  await db.insert(skills).values({ ...data, sortOrder: data.sortOrder ?? 0 });
  await setFlashCookie("Skill created.");
  revalidatePath("/admin/skills");
  redirect("/admin/skills");
}

export async function updateSkill(id: number, formData: FormData) {
  const data = parse(formData);
  await db.update(skills).set({ ...data, sortOrder: data.sortOrder ?? 0 }).where(eq(skills.id, id));
  await setFlashCookie("Skill updated.");
  revalidatePath("/admin/skills");
  redirect("/admin/skills");
}

export async function deleteSkill(id: number) {
  await db.delete(skills).where(eq(skills.id, id));
  await setFlashCookie("Skill deleted.");
  revalidatePath("/admin/skills");
}
