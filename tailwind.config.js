/** @type {import('tailwindcss').Config} */
module.exports = {
  mode: "jit",
  content: [
    "./*.{php,html}",
    "./**/*.php",
    "./template-parts/**/*.php",
    "./inc/**/*.php",
    "./js/**/*.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};


