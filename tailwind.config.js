const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    darkMode: 'class',

    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/vuetailwind.js',
        'node_modules/vue-tailwind/dist/*.js'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            opacity: ['disabled'],
            cursor: ['disabled'],
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
