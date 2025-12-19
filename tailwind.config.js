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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                gray: {
                    750: '#2d3748',
                    850: '#1a202c',
                    900: '#171923',
                    950: '#0d1117',
                },
                dark: {
                     bg: '#0f111a',
                     surface: '#181b25',
                     border: '#2a2f3e',
                     text: '#e2e8f0',
                     muted: '#94a3b8'
                },
                primary: {
                    500: '#3b82f6',
                    600: '#2563eb',
                    400: '#60a5fa'
                }
            }
        },
    },

    plugins: [forms],
};
