module.exports = {
  theme: {
    extend: {
      colors: {
        'w-opacity-700': 'rgba(250, 250, 250, .7)'
      },
      maxHeight: {
        '0': '0',
        '1/4': '25%',
        '1/2': '50%',
        '3/4': '75%',
        'full': '100%'
      }
    },
    fontFamily: {
      'nunito': ['Nunito', 'Sans-serif']
    }
  },
  variants: {},
  plugins: [
    function({ addUtilities }) {
      const newUtilities = {
        '.rotate-0': {
          transform: 'rotate(0deg)',
          transition: 'all 275ms'
        },
        '.rotate-90': {
          transform: 'rotate(90deg)',
          transition: 'all 275ms'
        },
        '.rotate-180': {
          transform: 'rotate(180deg)',
          transition: 'all 275ms'
        },
        '.rotate-270': {
          transform: 'rotate(270deg)',
          transition: 'all 275ms'
        },
        '.min-h-56': {
          'min-height': '14rem'
        },
        '.min-h-64': {
          'min-height': '16rem'
        },
      }
      addUtilities(newUtilities, ['responsive', 'hover'])
    }
  ]
}
