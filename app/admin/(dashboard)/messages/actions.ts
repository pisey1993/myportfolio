"use server";

import { eq } from "drizzle-orm";
import { redirect } from "next/navigation";
import { revalidatePath } from "next/cache";
import { db } from "@/lib/db/client";
import { contactMessages } from "@/lib/db/schema";
import { setFlashCookie } from "@/lib/flash";

export async function markAsRead(id: number) {
  await db
    .update(contactMessages)
    .set({ readAt: new Date() })
    .where(eq(contactMessages.id, id));
}

export async function deleteMessage(id: number) {
  await db.delete(contactMessages).where(eq(contactMessages.id, id));
  await setFlashCookie("Message deleted.");
  revalidatePath("/admin/messages");
  redirect("/admin/messages");
}
