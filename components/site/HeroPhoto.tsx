type HeroPhotoData = {
  headline: string;
  avatarUrl: string | null;
  avatarPositionX: number;
  avatarPositionY: number;
};

export default function HeroPhoto({ data }: { data: HeroPhotoData }) {
  const initial = (data.headline || "P").slice(0, 1).toUpperCase();
  const objectPosition = `${data.avatarPositionX}% ${data.avatarPositionY}%`;

  return (
    <div className="relative aspect-square w-full max-w-md mx-auto">
      <div className="absolute -inset-6 rounded-[2rem] bg-gradient-to-tr from-pink-600 via-fuchsia-500 to-orange-400 opacity-60 blur-2xl" />
      <div className="relative w-full h-full rounded-[1.75rem] overflow-hidden border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900">
        {data.avatarUrl ? (
          // eslint-disable-next-line @next/next/no-img-element
          <img
            src={data.avatarUrl}
            alt={data.headline}
            className="absolute inset-0 w-full h-full object-cover"
            style={{ objectPosition }}
          />
        ) : (
          <>
            <div className="absolute inset-0 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-950" />
            <div className="absolute inset-0 flex items-center justify-center">
              <span
                className="text-slate-200 dark:text-white/10 font-extrabold leading-none select-none"
                style={{ fontSize: "min(28vw, 14rem)" }}
              >
                {initial}
              </span>
            </div>
          </>
        )}
      </div>
    </div>
  );
}
