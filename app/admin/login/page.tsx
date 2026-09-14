import Link from "next/link";
import LoginForm from "./LoginForm";

export default function AdminLoginPage() {
  return (
    <div className="min-h-screen flex items-center justify-center bg-slate-50 px-4">
      <div className="w-full max-w-sm">
        <div className="flex items-center justify-center gap-2 mb-8">
          <span className="w-9 h-9 rounded-full bg-gradient-to-tr from-pink-600 to-fuchsia-400 flex items-center justify-center text-white font-bold">P</span>
          <span className="font-bold text-lg text-slate-900">Pisey</span>
        </div>

        <div className="bg-white border border-slate-200 rounded-2xl shadow-sm p-8">
          <h1 className="text-xl font-semibold text-slate-900">Welcome back</h1>
          <p className="text-sm text-slate-500 mt-1 mb-6">Sign in to manage your site.</p>
          <LoginForm />
        </div>

        <p className="text-center mt-6">
          <Link href="/" className="text-sm text-slate-500 hover:text-slate-900">&larr; Back to site</Link>
        </p>
      </div>
    </div>
  );
}
