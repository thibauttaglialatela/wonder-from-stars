/** @type {import('tailwindcss').Config} */

module.exports = {
  content: [
    './node_modules/tw-elements/dist/js/**/*.js',
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('tw-elements/dist/plugin')
  ],
}

