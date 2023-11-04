/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    container: {
      center:true
    },
    extend: {
      colors: {
        primary: "#3060FF",
        white: "#ffffff",
        black: "#000000",
        red: "#ed174f",
        yellow: "#CA9C1C",
        orange: "#FF8C00",
        green: "#008000"
      },
    },
  },
  plugins: [],
}

