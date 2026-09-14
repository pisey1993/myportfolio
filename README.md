# Portfolio

A personal portfolio site — home, about, projects, blog, video blog, and contact — plus an admin panel for editing content, backed by a single JSON file instead of a database.

Built with **Next.js (App Router) + TypeScript** and **Tailwind CSS**.

## Content & admin

All content (site settings, projects, blog posts, skills, experience) lives in [`lib/data/content.json`](lib/data/content.json) and is read/written through [`lib/content.ts`](lib/content.ts). There's no database — the JSON file *is* the database.

The admin panel at `/admin` lets you edit that content through a UI (same CRUD screens as the original Postgres-backed version — projects, posts, skills, experience, settings) instead of hand-editing JSON.

**Locally**, saves write straight to `lib/data/content.json` on disk — just run `npm run dev` and use `/admin`.

**On Vercel** (or anywhere else with a read-only filesystem), saves instead commit `lib/data/content.json` to this GitHub repo via the GitHub API, which triggers Vercel's normal auto-redeploy. See "Deploying the admin panel" below to enable this — without it, the admin panel on a deployed instance shows a banner and saving is disabled, since there'd be nowhere to persist the write.

Either way, a save is not instant on the deployed site: locally it's a file write; on Vercel it's a git commit followed by a ~1–2 minute redeploy before the change is live (the admin panel itself always reads the latest committed content, though, even mid-redeploy).

The contact page lists your social/contact links and includes a simple form that opens the visitor's email client via a `mailto:` link (built client-side) — no server involved in sending messages.

## Setup

### 1. Install dependencies

```bash
npm install
```

### 2. Configure the admin password

```bash
cp .env.local.example .env.local
```

Set `ADMIN_PASSWORD` in `.env.local` to whatever you want to log in with at `/admin`.

### 3. Run locally

```bash
npm run dev
```

Visit `http://localhost:3000` for the site, `http://localhost:3000/admin` for the admin panel.

### 4. Build

```bash
npm run build
npm start
```

## Deploying the admin panel (Vercel)

To make `/admin` work — not just view, but actually save — on Vercel:

1. Create a GitHub **personal access token** with write access to this repo:
   - Fine-grained token (recommended): scope it to this repository only, with **Contents: Read and write** permission.
   - Or a classic token with the `repo` scope (or `public_repo` if this repo is public).
2. In your Vercel project → **Settings → Environment Variables**, add:
   - `ADMIN_PASSWORD` — same as your local one, or a different one for production.
   - `SESSION_SECRET` — a random string (optional; falls back to `ADMIN_PASSWORD`).
   - `GITHUB_TOKEN` — the token from step 1.
   - `GITHUB_REPO` — `owner/repo` (defaults to `pisey1993/myportfolio` if unset).
   - `GITHUB_BRANCH` — defaults to `main` if unset.
3. Redeploy. `/admin` on the live site will now save by committing to GitHub, and each save triggers a fresh deploy automatically.

Keep `GITHUB_TOKEN` unset in your local `.env.local` unless you specifically want to test the GitHub-commit path locally — without it, local saves just write the file to disk directly, which is faster and doesn't touch GitHub.

## Project structure

- `app/(site)/` — public pages (home, about, projects, blog, video-blog, contact)
- `app/admin/` — admin panel (dashboard, CRUD for projects/posts/skills/experiences, settings), gated by `middleware.ts`
- `lib/content.ts` — reads and writes content; the public site's query functions read the bundled `lib/data/content.json` directly, while the admin's read/mutation functions go through GitHub when `GITHUB_TOKEN` is set (falling back to direct disk read/write locally)
- `lib/github.ts` — thin wrapper around the GitHub Contents API used by `lib/content.ts` when `GITHUB_TOKEN` is set
- `lib/data/content.json` — all site content (projects, posts, skills, experience, settings) — the "database"
- `lib/session.ts` — signs/verifies the admin session cookie (no database of admin users — just one password in `ADMIN_PASSWORD`)
