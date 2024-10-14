/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./templates/**/*.{html,twig}",
    "./assets/**/*.{js,jsx,ts,tsx,vue}",
  ],
  theme: {
    extend: {
      colors: {
        transparent: 'transparent',
        black: '#000',
        white: '#fff',
        gray: {
          100: '#f7fafc', // couleur de fond pour 'bg-nude'
          900: '#1a202c', // couleur du texte pour 'text-gray-800'
          500:'#505050'
        },
        burgundy: '#4A0013', // couleur personnalisée pour 'bg-burgundy'
        red:{
          500:'#4A0013'
        }
      },
    },
  },
  plugins: [],
}
