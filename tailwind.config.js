import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // WAJIB: Aktifkan mode gelap berbasis 'class'
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'base': '#f3f4f6',
                'surface': '#ffffff',
                'primary': '#4f46e5',
                'highlight': '#e0e7ff',
                'text-main': '#111827',
                'text-subtle': '#6b7280',
                
                // Warna Tema Gelap
                'dark-base': '#000000',
                'dark-surface': '#1A1A1A',
                'dark-primary': '#758bfd',
                'dark-highlight': '#758bfd',
                'dark-text-main': '#EDEDED',
                'dark-text-subtle': '#9D9D9D',

                // Warna Status
                'danger': '#e11d48',
                'success': '#16a34a',
                'warning': '#f59e0b',
                'info': '#0ea5e9',
            },
        },
    },

    plugins: [forms],
};