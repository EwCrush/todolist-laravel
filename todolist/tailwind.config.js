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
        green: "#008000",
        pink: "#FF69B4",
        sidebarselected: "#ecf1fe",
        border: "#f8f8f8"
      },
      width:{
        content: "98%"
      }
    },
  },
  plugins: [
    
  ],
}

