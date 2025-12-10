module.exports = {
  prefix: 'tw-',
  important: false,
  purge: {
    enabled: process.env.NODE_ENV === 'production',
    content: [
      './resources/views/**/*.blade.php',
      './resources/assets/js/**/*.vue',
      './resources/assets/js/**/*.js',
    ],
  },
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
  corePlugins: {
    preflight: false, // Disable Tailwind's base reset to avoid conflicts with Bootstrap 3
  },
}
