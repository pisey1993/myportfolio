import { drizzle, type PostgresJsDatabase } from "drizzle-orm/postgres-js";
import postgres from "postgres";
import * as schema from "./schema";

declare global {
  var _pgClient: ReturnType<typeof postgres> | undefined;
  var _drizzleDb: PostgresJsDatabase<typeof schema> | undefined;
}

/**
 * Lazily creates the connection on first real use, rather than at module
 * import time. Next.js's build "Collect page data" step imports every route
 * module (even fully dynamic ones) to analyze them — throwing here eagerly
 * would fail the build itself whenever DATABASE_URL isn't present at build
 * time, even though no query actually runs until a request comes in.
 */
function createDb(): PostgresJsDatabase<typeof schema> {
  const connectionString = process.env.DATABASE_URL;

  if (!connectionString) {
    throw new Error(
      "DATABASE_URL is not set. Provision a Postgres database (e.g. Vercel Postgres / Neon) and add it to your environment variables.",
    );
  }

  // Reuse the connection across hot-reloads in dev to avoid exhausting connections.
  const client = globalThis._pgClient ?? postgres(connectionString, { max: 5 });
  if (process.env.NODE_ENV !== "production") {
    globalThis._pgClient = client;
  }

  return drizzle(client, { schema });
}

export const db: PostgresJsDatabase<typeof schema> = new Proxy({} as PostgresJsDatabase<typeof schema>, {
  get(_target, prop, receiver) {
    const instance = (globalThis._drizzleDb ??= createDb());
    return Reflect.get(instance as object, prop, receiver);
  },
});
