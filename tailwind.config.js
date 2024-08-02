import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx,vue}',
        'node_modules/flowbite/**/*.{js,jsx,ts,tsx}',
    ],

    theme: {
        extend: {
            colors: {
                primary    : "#5740eb",
                secondary  : "#F8F8FF",
                ternary    : "#d4d6fc",
                accent     : "#f6f7f9",
                grey       : {
                       200 : "#d8d8d8",
                       100 : "#eeeeee"
                },
            },
            fontFamily: {
                light:      ["CriqueGrotesk Light"],
                regular:    ["CriqueGrotesk Regular"],
                medium:     ["CriqueGrotesk Medium"],
                semibold:   ["CriqueGrotesk SemiBold"],
                bold:       ["CriqueGrotesk Bold"],
            }
        },
    },

    plugins: [
        forms,
        require('flowbite/plugin'),
    ],
};
