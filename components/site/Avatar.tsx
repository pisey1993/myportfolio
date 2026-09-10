type AvatarData = {
  headline: string;
  avatarUrl: string | null;
  avatarPositionX: number;
  avatarPositionY: number;
};

const SIZES = {
  md: "w-32 h-32 text-2xl sm:w-44 sm:h-44 sm:text-4xl",
  lg: "w-40 h-40 text-4xl sm:w-56 sm:h-56 sm:text-6xl",
};

export default function Avatar({ data, size = "lg" }: { data: AvatarData; size?: keyof typeof SIZES }) {
  const initial = (data.headline || "P").slice(0, 1).toUpperCase();
  const objectPosition = `${data.avatarPositionX}% ${data.avatarPositionY}%`;

  return (
    <div className={`relative shrink-0 ${SIZES[size]}`}>
      <div className="absolute -inset-2 rounded-full bg-gradient-to-tr from-pink-600 via-fuchsia-500 to-orange-400 opacity-50 blur-xl" />
      <div className="relative w-full h-full rounded-full p-1 bg-gradient-to-tr from-pink-600 to-fuchsia-400">
        <div className="w-full h-full rounded-full overflow-hidden bg-white dark:bg-slate-900 ring-4 ring-white dark:ring-slate-950">
          {data.avatarUrl ? (
            // eslint-disable-next-line @next/next/no-img-element
            <img src={data.avatarUrl} alt={data.headline} className="w-full h-full object-cover" style={{ objectPosition }} />
          ) : (
            <div className="w-full h-full flex items-center justify-center bg-slate-100 dark:bg-slate-800 font-bold text-fuchsia-600 dark:text-fuchsia-400">
              {initial}
            </div>
          )}
        </div>
      </div>
    </div>
  );
}
