export default function PageHeader({ title, actions }: { title: string; actions?: React.ReactNode }) {
  return (
    <div className="px-4 sm:px-6 lg:px-8 pt-6 pb-2 flex items-center flex-wrap gap-3">
      <h1 className="text-2xl font-semibold tracking-tight text-[#0f172a]">{title}</h1>
      {actions}
    </div>
  );
}
