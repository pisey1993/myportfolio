import { drizzle } from "drizzle-orm/postgres-js";
import postgres from "postgres";
import * as schema from "./schema";

declare global {
  var _pgClient: ReturnType<typeof postgres> | undefined;
}

const connectionString = process.env.DATABASE_URL;

if (!connectionString) {
  throw new Error(
    "DATABASE_URL is not set. Provision a Postgres database (e.g. Vercel Postgres / Neon) and add it to .env.local.",
  );
}

// Reuse the connection across hot-reloads in dev to avoid exhausting connections.
const client = globalThis._pgClient ?? postgres(connectionString, { max: 5 });
if (process.env.NODE_ENV !== "production") {
  globalThis._pgClient = client;
}

export const db = drizzle(client, { schema });
