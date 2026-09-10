"use client";

import { useEffect } from "react";
import { clearFlashCookie } from "@/lib/flash";

type ToastType = "success" | "error" | "info";

let region: HTMLDivElement | null = null;

/** Imperative toast, callable from anywhere on the client — mirrors the old global Toast() JS helper. */
export function showToast(message: string, type?: ToastType) {
  if (!region || !message) return;

  const el = document.createElement("div");
  el.className = `toast${type === "error" ? " is-error" : type === "success" ? " is-success" : ""}`;

  const msg = document.createElement("span");
  msg.className = "toast-msg";
  msg.textContent = message;

  const close = document.createElement("span");
  close.className = "toast-close";
  close.textContent = "×";

  el.appendChild(msg);
  el.appendChild(close);

  const remove = () => {
    el.classList.add("is-leaving");
    setTimeout(() => el.remove(), 220);
  };
  close.addEventListener("click", remove);
  region.appendChild(el);
  setTimeout(remove, 4200);
}

/** Reads a one-shot flash cookie (set by a Server Action right before redirect) and shows it as a toast. */
export function ToastRegion({ flash }: { flash?: { message: string; type?: ToastType } | null }) {
  useEffect(() => {
    if (flash?.message) {
      showToast(flash.message, flash.type);
      clearFlashCookie();
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [flash?.message]);

  return <div id="toast-region" ref={(el) => { region = el; }} aria-live="polite" />;
}
