"use server";

import { cookies } from "next/headers";

export type FlashType = "success" | "error" | "info";
export type Flash = { message: string; type?: FlashType };

/** Sets a one-shot flash cookie, read by <ToastRegion> on the next page render. */
export async function setFlashCookie(message: string, type?: FlashType) {
  const store = await cookies();
  store.set("flash", JSON.stringify({ message, type } satisfies Flash), {
    httpOnly: false,
    maxAge: 10,
    path: "/",
  });
}

/**
 * Read-only — safe to call from a Server Component (layouts render on every
 * navigation, and Next.js forbids mutating cookies there). Deletion happens
 * separately via clearFlashCookie(), called from the client after the toast
 * has been shown, since that runs as a Server Action.
 */
export async function readFlash(): Promise<Flash | null> {
  const store = await cookies();
  const raw = store.get("flash")?.value;
  if (!raw) return null;
  try {
    return JSON.parse(raw) as Flash;
  } catch {
    return null;
  }
}

export async function clearFlashCookie() {
  const store = await cookies();
  store.delete("flash");
}
