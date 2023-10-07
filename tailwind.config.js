import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./node_modules/tw-elements/dist/js/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // teal as primary
                primary: "#4da9a4",
                "primary-50": "#f2f8f8",
                "primary-100": "#e6f1f1",
                "primary-200": "#bfdfde",
                "primary-300": "#99cdca",
                "primary-400": "#4da9a4",
                "primary-500": "#008580",
                "primary-600": "#007772",
                "primary-700": "#006663",
                "primary-800": "#005555",
                "primary-900": "#004646",
            },
        },
    },

    plugins: [forms, require("tw-elements/dist/plugin.cjs")],
};
