# Portfolio

A personal portfolio site — home, about, projects, blog, video blog, and contact — built as a fully **static site** with no backend, no database, and no server-side runtime required.

Built with **Next.js (App Router) + TypeScript** and **Tailwind CSS**, exported via `next export` (`output: "export"`) to plain HTML/CSS/JS.

## Content

All content (site settings, projects, blog posts, skills, experience) lives in [`lib/data/content.json`](lib/data/content.json) and is read at build time by [`lib/content.ts`](lib/content.ts). To update the site, edit that JSON file and rebuild — there's no admin panel or database.

The contact page lists your social/contact links and includes a simple form that opens the visitor's email client via a `mailto:` link (built client-side) — no server is involved in sending messages.

## Setup

### 1. Install dependencies

```bash
npm install
```

### 2. Run locally

```bash
npm run dev
```

Visit `http://localhost:3000`.

### 3. Build the static site

```bash
npm run build
```

This produces a fully static export in the `out/` directory — ready to deploy to any static host (GitHub Pages, Netlify, Cloudflare Pages, S3, Vercel static hosting, etc.). Preview it locally with:

```bash
npx serve out
```

Optionally set `NEXT_PUBLIC_SITE_URL` (e.g. in a `.env.local`) to the site's public URL — it's used to build absolute links for the blog post share buttons.

## Project structure

- `app/(site)/` — public pages (home, about, projects, blog, video-blog, contact)
- `lib/content.ts` — reads and shapes the static content from `lib/data/content.json`
- `lib/data/content.json` — all site content (projects, posts, skills, experience, settings)
