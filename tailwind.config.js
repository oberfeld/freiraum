/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./resources/**/*.php", "./resources/**/*.html"],
  theme: {
    extend: {},
  },
  plugins: [require("@tailwindcss/typography")],
};

