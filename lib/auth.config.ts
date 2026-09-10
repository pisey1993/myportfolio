import type { NextAuthConfig } from "next-auth";

// Edge-safe config only: no providers (which pull in the Postgres driver via
// their authorize() callbacks) — this is what middleware.ts uses, since
// Next.js middleware runs on the Edge runtime where Node-only APIs aren't
// available. lib/auth.ts extends this with the real Credentials provider
// for use everywhere else (Server Components, Route Handlers, Server Actions).
export const authConfig = {
  pages: { signIn: "/admin/login" },
  providers: [],
  callbacks: {
    authorized({ auth, request }) {
      const isAdminRoute =
        request.nextUrl.pathname.startsWith("/admin") &&
        !request.nextUrl.pathname.startsWith("/admin/login");
      if (!isAdminRoute) return true;
      return !!auth?.user;
    },
  },
} satisfies NextAuthConfig;
