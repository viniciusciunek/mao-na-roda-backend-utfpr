/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.{phtml, php, html}"],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
