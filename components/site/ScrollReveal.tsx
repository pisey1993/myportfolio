"use client";

import { useEffect } from "react";
import { usePathname } from "next/navigation";

/**
 * Toggles .is-visible on .anim-stagger / [data-reveal] elements as they
 * scroll in and out of view (two-way, not a one-time reveal) — mirrors the
 * IntersectionObserver in the original app's app.js. A fallback timer force-
 * reveals everything after 8s in case the observer never fires.
 */
export default function ScrollReveal() {
  const pathname = usePathname();

  useEffect(() => {
    const els = document.querySelectorAll(".anim-stagger, [data-reveal]");
    if (els.length === 0) return;

    if (!("IntersectionObserver" in window)) {
      els.forEach((el) => el.classList.add("is-visible"));
      return;
    }

    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          entry.target.classList.toggle("is-visible", entry.isIntersecting);
        });
      },
      { threshold: 0.15, rootMargin: "0px 0px -40px 0px" },
    );

    els.forEach((el) => io.observe(el));

    const fallback = setTimeout(() => {
      els.forEach((el) => el.classList.add("is-visible"));
    }, 8000);

    return () => {
      io.disconnect();
      clearTimeout(fallback);
    };
  }, [pathname]);

  return null;
}
