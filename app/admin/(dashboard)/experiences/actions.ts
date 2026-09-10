"use server";

import { z } from "zod";
import { eq } from "drizzle-orm";
import { redirect } from "next/navigation";
import { revalidatePath } from "next/cache";
import { db } from "@/lib/db/client";
import { experiences } from "@/lib/db/schema";
import { setFlashCookie } from "@/lib/flash";

const schema = z.object({
  title: z.string().min(1).max(255),
  company: z.string().min(1).max(255),
  startLabel: z.string().min(1).max(255),
  endLabel: z.string().max(255).optional().or(z.literal("")),
  highlights: z.string().optional().or(z.literal("")),
  sortOrder: z.coerce.number().int().optional(),
});

function parse(formData: FormData) {
  return schema.parse({
    title: formData.get("title"),
    company: formData.get("company"),
    startLabel: formData.get("startLabel"),
    endLabel: formData.get("endLabel") ?? "",
    highlights: formData.get("highlights") ?? "",
    sortOrder: formData.get("sortOrder") || 0,
  });
}

export async function createExperience(formData: FormData) {
  const data = parse(formData);
  await db.insert(experiences).values({
    ...data,
    endLabel: data.endLabel || null,
    highlights: data.highlights || null,
    sortOrder: data.sortOrder ?? 0,
  });
  await setFlashCookie("Experience created.");
  revalidatePath("/admin/experiences");
  redirect("/admin/experiences");
}

export async function updateExperience(id: number, formData: FormData) {
  const data = parse(formData);
  await db
    .update(experiences)
    .set({ ...data, endLabel: data.endLabel || null, highlights: data.highlights || null, sortOrder: data.sortOrder ?? 0 })
    .where(eq(experiences.id, id));
  await setFlashCookie("Experience updated.");
  revalidatePath("/admin/experiences");
  redirect("/admin/experiences");
}

export async function deleteExperience(id: number) {
  await db.delete(experiences).where(eq(experiences.id, id));
  await setFlashCookie("Experience deleted.");
  revalidatePath("/admin/experiences");
}
