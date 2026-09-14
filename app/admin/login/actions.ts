"use server";

import { cookies } from "next/headers";
import { redirect } from "next/navigation";
import { ADMIN_SESSION_COOKIE, ADMIN_SESSION_MAX_AGE, createSessionValue, safeEqual } from "@/lib/session";

export async function loginAction(formData: FormData) {
  const password = String(formData.get("password") ?? "");
  const expected = process.env.ADMIN_PASSWORD;

  if (!expected) {
    return { error: "ADMIN_PASSWORD is not set. Add it to .env.local and restart the dev server." };
  }
  if (!password || !safeEqual(password, expected)) {
    return { error: "Incorrect password." };
  }

  const store = await cookies();
  store.set(ADMIN_SESSION_COOKIE, await createSessionValue(), {
    httpOnly: true,
    sameSite: "lax",
    maxAge: ADMIN_SESSION_MAX_AGE,
    path: "/",
  });

  redirect("/admin");
}
