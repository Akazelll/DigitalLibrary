import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: false,

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
                // Palet Baru yang Lebih Kontras dan Profesional
                'base': '#f3f4f6',      // Latar belakang utama (Abu-abu muda DINGIN)
                'surface': '#ffffff',   // Latar belakang untuk card, input, dropdown (Putih bersih)
                'primary': '#4f46e5',   // Warna utama untuk tombol & link (Biru Indigo yang kuat)
                'highlight': '#e0e7ff', // Warna untuk hover/focus (Biru Indigo sangat muda)

                'text-main': '#111827',    // Warna teks utama (Hampir hitam)
                'text-subtle': '#6b7280',// Warna teks sekunder/abu-abu

                // Warna Status Notifikasi
                'danger': '#e11d48',
                'success': '#16a34a',
                'warning': '#f59e0b',
                'info': '#0ea5e9',
            },
            animation: {
                'fadeIn': 'fadeIn 1s ease-out forwards',
            },
            keyframes: {
                fadeIn: {
                    'from': { opacity: 0, transform: 'translateY(20px)' },
                    'to': { opacity: 1, transform: 'translateY(0)' },
                }
            },
        },
    },

    plugins: [forms],
};