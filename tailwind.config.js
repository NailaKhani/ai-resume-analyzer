import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Outfit', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            maxWidth: {
                'desktop': '1440px',
            },
            colors: {
                'purple-bg': '#FAF5FF',
            },
        },
    },

    plugins: [forms],
};
