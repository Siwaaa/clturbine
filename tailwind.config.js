const colors = require('tailwindcss/colors')

module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
        colors: {
            gray: colors.trueGray,
        },
    },
  },

  variants: {
    extend: {
        backgroundOpacity: ['active'],
        backgroundColor: ['active'],
        scale: ['active']
    },
  },
  plugins: [],
}
