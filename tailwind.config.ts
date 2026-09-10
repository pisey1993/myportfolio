import type { Config } from "tailwindcss";
import forms from "@tailwindcss/forms";

export default {
  darkMode: "class",
  content: ["./app/**/*.{ts,tsx}", "./components/**/*.{ts,tsx}"],
  theme: {
    extend: {
      fontFamily: {
        sans: ["var(--font-figtree)", "ui-sans-serif", "system-ui", "sans-serif"],
      },
    },
  },
  plugins: [forms],
} satisfies Config;
