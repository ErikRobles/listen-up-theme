module.exports = {
  important: true,
  content: [
  "./template-parts/**/*.php",
    "./*.php",
      "./js/*.js"
  ],
theme: {
  extend: {},
},
plugins: [
      require('@tailwindcss/typography')
 ],
}
