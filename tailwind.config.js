/** @type {import('tailwindcss').Config} */
import defaultTheme from 'tailwindcss/defaultTheme';
import colors from 'tailwindcss/colors';
import forms from '@tailwindcss/forms'; // <-- Import plugin forms

export default {
    darkMode: "class",

    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {

                brand: {
                    50: "#eef9ff", 100: "#dbf2ff", 200: "#bfe6ff", 300: "#94d6ff",
                    400: "#5fc0ff", 500: "#2aa7ff", 600: "#1b90ef", 700: "#1770be", 800: "#155e9b", 900: "#134f7f",
                },
            },
            boxShadow: { soft: "0 12px 30px rgba(42,167,255,.18)" },
            borderRadius: { "3xl": "1.5rem" },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans], // Pastikan Figtree ada di sini
                display: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        forms // <-- Gunakan plugin yang sudah di-import
    ],
};