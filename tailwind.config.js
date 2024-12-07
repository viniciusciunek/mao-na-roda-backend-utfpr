/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.{phtml, php, html}"],
  theme: {
    extend: {
        colors: {
            primaryBlue: "#0e3087",
            darkBlue: "#14285F"
        },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
