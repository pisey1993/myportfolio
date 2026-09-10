import NextAuth from "next-auth";
import Credentials from "next-auth/providers/credentials";
import bcrypt from "bcryptjs";
import { authConfig } from "./auth.config";
import { findAdminByEmail } from "./db/queries";

export const { handlers, signIn, signOut, auth } = NextAuth({
  ...authConfig,
  session: { strategy: "jwt" },
  providers: [
    Credentials({
      credentials: {
        email: { label: "Email", type: "email" },
        password: { label: "Password", type: "password" },
      },
      async authorize(credentials) {
        const email = credentials?.email as string | undefined;
        const password = credentials?.password as string | undefined;
        if (!email || !password) return null;

        const admin = await findAdminByEmail(email);
        if (!admin) return null;

        const valid = await bcrypt.compare(password, admin.passwordHash);
        if (!valid) return null;

        return { id: String(admin.id), email: admin.email };
      },
    }),
  ],
});
