import { stringHash } from "@/lib/format";

const PALETTES = [
  "from-pink-600 to-fuchsia-600",
  "from-fuchsia-600 to-purple-600",
  "from-orange-500 to-pink-600",
  "from-purple-600 to-pink-500",
  "from-rose-600 to-fuchsia-600",
];

export default function MediaPlaceholder({ title = "", className = "" }: { title?: string; className?: string }) {
  const gradient = PALETTES[title ? stringHash(title) % PALETTES.length : 0];
  const initial = (title || "?").slice(0, 1).toUpperCase();
  const patternId = `dots-${stringHash(title || "placeholder")}`;

  return (
    <div className={`relative flex items-center justify-center overflow-hidden bg-gradient-to-br ${gradient} ${className}`}>
      <svg className="absolute inset-0 w-full h-full opacity-20" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <pattern id={patternId} x="0" y="0" width="18" height="18" patternUnits="userSpaceOnUse">
            <circle cx="2" cy="2" r="1.6" fill="white" />
          </pattern>
        </defs>
        <rect width="100%" height="100%" fill={`url(#${patternId})`} />
      </svg>
      <span className="relative text-white/90 font-bold text-5xl tracking-tight select-none">{initial}</span>
    </div>
  );
}
