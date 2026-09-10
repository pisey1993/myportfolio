"use client";

import { useActionState } from "react";
import { loginAction } from "./actions";

export default function LoginForm() {
  const [state, formAction, pending] = useActionState(
    async (_prev: { error?: string } | undefined, formData: FormData) => loginAction(formData),
    undefined,
  );

  return (
    <form action={formAction} className="space-y-5">
      <div>
        <label htmlFor="email" className="block text-sm font-medium text-slate-700 dark:text-slate-300">Email Address</label>
        <input type="email" name="email" id="email" required autoFocus className="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/10 dark:bg-white/5 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 text-sm" />
      </div>
      <div>
        <label htmlFor="password" className="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
        <input type="password" name="password" id="password" required className="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/10 dark:bg-white/5 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 text-sm" />
      </div>
      {state?.error && <p className="text-sm text-red-600">{state.error}</p>}
      <button
        type="submit"
        disabled={pending}
        className="w-full inline-flex justify-center items-center px-6 py-3 rounded-full bg-gradient-to-r from-pink-600 to-fuchsia-500 text-white text-sm font-semibold hover:opacity-90 transition disabled:opacity-60"
      >
        {pending ? "Signing in…" : "Log In"}
      </button>
    </form>
  );
}
