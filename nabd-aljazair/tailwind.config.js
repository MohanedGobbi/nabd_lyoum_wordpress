/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "class",
  content: [
    "./*.php",
    "./template-parts/**/*.php",
    "./inc/**/*.php",
    "./assets/js/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        ink: {
          950: "#0a0a0b",
          900: "#121214",
          800: "#1b1b1e",
          700: "#2a2a2e",
        },
        brand: {
          DEFAULT: "#e11d24",
          600: "#c8151c",
          700: "#a51117",
          50: "#fdecec",
        },
        category: {
          algeria: "#16181d",
          world: "#1d5fbf",
          economy: "#c8151c",
          sport: "#1f8a4c",
          tech: "#0f8fa8",
          politics: "#233a5e",
          society: "#b45309",
          culture: "#7c3aed",
          varieties: "#0d9488",
          video: "#334155",
        },
      },
      fontFamily: {
        body: ["Cairo", "Tahoma", "sans-serif"],
        display: ["Lalezar", "Cairo", "sans-serif"],
        logo: ["Rakkas", "Cairo", "serif"],
      },
      boxShadow: {
        card: "0 1px 2px 0 rgb(0 0 0 / 0.04), 0 2px 8px -2px rgb(0 0 0 / 0.06)",
        pop: "0 8px 24px -6px rgb(0 0 0 / 0.18)",
      },
    },
  },
  plugins: [],
};
