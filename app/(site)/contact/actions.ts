"use server";

import { z } from "zod";
import { redirect } from "next/navigation";
import { db } from "@/lib/db/client";
import { contactMessages } from "@/lib/db/schema";
import { setFlashCookie } from "@/lib/flash";

const schema = z.object({
  name: z.string().min(1).max(255),
  email: z.string().email().max(255),
  subject: z.string().max(255).optional().or(z.literal("")),
  message: z.string().min(1).max(5000),
});

export async function submitContactForm(formData: FormData) {
  const parsed = schema.safeParse({
    name: formData.get("name"),
    email: formData.get("email"),
    subject: formData.get("subject"),
    message: formData.get("message"),
  });

  if (!parsed.success) {
    await setFlashCookie("Please check the form for errors.", "error");
    redirect("/contact");
  }

  const { name, email, subject, message } = parsed.data;

  await db.insert(contactMessages).values({
    name,
    email,
    subject: subject || null,
    message,
  });

  let status = "Message sent successfully! I'll get back to you soon.";
  let type: "success" | "info" = "success";

  if (process.env.RESEND_API_KEY && process.env.CONTACT_NOTIFY_EMAIL) {
    try {
      const { Resend } = await import("resend");
      const resend = new Resend(process.env.RESEND_API_KEY);
      await resend.emails.send({
        from: "Portfolio Contact <onboarding@resend.dev>",
        to: process.env.CONTACT_NOTIFY_EMAIL,
        replyTo: email,
        subject: subject || `New message from ${name}`,
        text: message,
      });
    } catch (error) {
      console.warn("Contact message email failed:", error);
      status = "Thanks for reaching out! Your message was saved and I'll get back to you soon.";
      type = "info";
    }
  }

  await setFlashCookie(status, type);
  redirect("/contact");
}
