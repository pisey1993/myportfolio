# Portfolio

A personal portfolio site — home, about, projects, blog, video blog, and contact form — with an admin panel for managing content, including a Gemini-AI-powered "Generate from AI News" feature for blog posts.

Built with **Next.js (App Router) + TypeScript**, **Tailwind CSS**, **Drizzle ORM + Postgres**, and **Auth.js**, deployable to **Vercel**.

## Setup

### 1. Install dependencies

```bash
npm install
```

### 2. Provision services

This app needs a Postgres database and (for avatar uploads) blob storage. The easiest path is via Vercel:

1. Create a project on [vercel.com](https://vercel.com) (or run `vercel link` from this directory)
2. Add **Vercel Postgres** (or connect a Neon database) — copy the `DATABASE_URL` it gives you
3. Add **Vercel Blob** storage — copy the `BLOB_READ_WRITE_TOKEN` it gives you

### 3. Configure environment variables

Copy `.env.local.example` to `.env.local` and fill in:

```bash
cp .env.local.example .env.local
```

| Variable | Purpose |
|---|---|
| `DATABASE_URL` | Postgres connection string |
| `BLOB_READ_WRITE_TOKEN` | Vercel Blob token, for avatar uploads |
| `NEXTAUTH_SECRET` | Random string — generate with `openssl rand -base64 32` |
| `NEXTAUTH_URL` | `http://localhost:3000` locally |
| `ADMIN_EMAIL` / `ADMIN_PASSWORD` | Used once by `scripts/seed.ts` to create your admin login |
| `GEMINI_API_KEY` / `GEMINI_MODEL` | Already set — powers the AI post generator |
| `RESEND_API_KEY` / `CONTACT_NOTIFY_EMAIL` | Optional — email notification when someone submits the contact form. Without these, messages still save to the database. |

### 4. Create the database schema and seed initial content

```bash
npm run db:push
npm run db:seed
```

`db:seed` reads `data-export.json` (a one-time export from the original database) into Postgres, and creates your admin login from `ADMIN_EMAIL`/`ADMIN_PASSWORD`.

### 5. Run locally

```bash
npm run dev
```

Visit `http://localhost:3000` for the site, `http://localhost:3000/admin/login` for the admin panel.

### 6. Deploy

Push to GitHub and import the repo in Vercel, or run `vercel deploy` from this directory. Add the same environment variables in the Vercel project settings.

## Project structure

- `app/(site)/` — public pages (home, about, projects, blog, video-blog, contact)
- `app/admin/` — admin panel (dashboard, CRUD for projects/posts/skills/experiences, messages, settings), gated by `middleware.ts`
- `lib/db/` — Drizzle schema and query helpers
- `lib/gemini.ts`, `lib/hacker-news.ts`, `lib/images.ts` — the AI post generator: pulls a real, on-topic Hacker News headline, asks Gemini to write about it, and finds a matching cover photo
- `scripts/seed.ts` — one-time data migration + admin user creation

## Notes

- There's no public registration page — a single admin account is created by the seed script. To reset the password, update `ADMIN_PASSWORD` and re-run a modified seed (or update the `admin_users` row directly).
- The original Laravel app also had a raw SQL / schema-editing admin tool; it was intentionally not ported here as a security simplification. Use your database host's own dashboard (Neon/Vercel Postgres) for ad-hoc data inspection.
