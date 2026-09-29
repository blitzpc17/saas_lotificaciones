import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
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
            colors: {
                brand: {
                    DEFAULT: 'rgb(var(--color-brand) / <alpha-value>)',
                    50: 'rgb(var(--color-brand) / 0.05)',
                    100: 'rgb(var(--color-brand) / 0.1)',
                    200: 'rgb(var(--color-brand) / 0.2)',
                    300: 'rgb(var(--color-brand) / 0.3)',
                    400: 'rgb(var(--color-brand) / 0.4)',
                    500: 'rgb(var(--color-brand) / 0.5)',
                    600: 'rgb(var(--color-brand) / <alpha-value>)', /* default */
                    700: 'rgb(var(--color-brand) / 0.8)', /* slightly darker */
                    800: 'rgb(var(--color-brand) / 0.9)',
                    900: 'rgb(var(--color-brand) / 1)',
                }
            }
        },
    },

    plugins: [forms],
};
