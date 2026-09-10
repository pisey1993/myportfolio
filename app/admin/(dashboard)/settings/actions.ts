"use server";

import { z } from "zod";
import { eq } from "drizzle-orm";
import { redirect } from "next/navigation";
import { revalidatePath } from "next/cache";
import { db } from "@/lib/db/client";
import { siteSettings } from "@/lib/db/schema";
import { getSiteSettings } from "@/lib/db/queries";
import { setFlashCookie } from "@/lib/flash";

const schema = z.object({
  headline: z.string().min(1).max(255),
  tagline: z.string().min(1).max(255),
  heroDescription: z.string().min(1).max(1000),
  email: z.string().email().max(255).optional().or(z.literal("")),
  githubUrl: z.string().url().max(2048).optional().or(z.literal("")),
  linkedinUrl: z.string().url().max(2048).optional().or(z.literal("")),
  twitterUrl: z.string().url().max(2048).optional().or(z.literal("")),
  telegramUrl: z.string().url().max(2048).optional().or(z.literal("")),
  avatarPositionX: z.coerce.number().int().min(0).max(100).optional(),
  avatarPositionY: z.coerce.number().int().min(0).max(100).optional(),
});

export async function updateSettings(formData: FormData) {
  const data = schema.parse({
    headline: formData.get("headline"),
    tagline: formData.get("tagline"),
    heroDescription: formData.get("heroDescription"),
    email: formData.get("email") ?? "",
    githubUrl: formData.get("githubUrl") ?? "",
    linkedinUrl: formData.get("linkedinUrl") ?? "",
    twitterUrl: formData.get("twitterUrl") ?? "",
    telegramUrl: formData.get("telegramUrl") ?? "",
    avatarPositionX: formData.get("avatarPositionX") || 50,
    avatarPositionY: formData.get("avatarPositionY") || 50,
  });

  const settings = await getSiteSettings();
  let avatarPath = settings.avatarPath;

  const removeAvatar = formData.get("removeAvatar") === "on";
  const file = formData.get("avatar") as File | null;

  if (removeAvatar) {
    avatarPath = null;
  } else if (file && file.size > 0) {
    if (file.size > 2 * 1024 * 1024) {
      throw new Error("Avatar must be 2MB or smaller.");
    }
    const { put } = await import("@vercel/blob");
    const blob = await put(`avatars/${Date.now()}-${file.name}`, file, { access: "public" });
    avatarPath = blob.url;
  }

  await db
    .update(siteSettings)
    .set({
      ...data,
      email: data.email || null,
      githubUrl: data.githubUrl || null,
      linkedinUrl: data.linkedinUrl || null,
      twitterUrl: data.twitterUrl || null,
      telegramUrl: data.telegramUrl || null,
      avatarPositionX: data.avatarPositionX ?? 50,
      avatarPositionY: data.avatarPositionY ?? 50,
      avatarPath,
      updatedAt: new Date(),
    })
    .where(eq(siteSettings.id, settings.id));

  await setFlashCookie("Settings updated.");
  revalidatePath("/", "layout");
  redirect("/admin/settings");
}
