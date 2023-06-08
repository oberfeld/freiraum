/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./resources/**/*.php"],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}

