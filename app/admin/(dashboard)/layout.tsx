import AdminShell from "@/components/admin/AdminShell";

export default function AdminDashboardLayout({ children }: { children: React.ReactNode }) {
  const isDeployed = Boolean(process.env.VERCEL);
  const githubConfigured = Boolean(process.env.GITHUB_TOKEN);

  return (
    <AdminShell>
      {isDeployed && !githubConfigured && (
        <div className="bg-amber-50 border-b border-amber-200 text-amber-800 text-[13px] px-4 sm:px-6 lg:px-8 py-2.5">
          Saving is disabled on this deployment — set <code>GITHUB_TOKEN</code> in your environment so saves commit to GitHub instead of writing to disk (see README), or run the admin panel locally with <code>npm run dev</code>.
        </div>
      )}
      {isDeployed && githubConfigured && (
        <div className="bg-indigo-50 border-b border-indigo-200 text-indigo-800 text-[13px] px-4 sm:px-6 lg:px-8 py-2.5">
          Saves here commit straight to GitHub and trigger a redeploy — the public site picks up each change in about a minute or two, not instantly.
        </div>
      )}
      {children}
    </AdminShell>
  );
}
