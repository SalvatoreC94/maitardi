import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                'brand-wine': '#54162B',   // bordeaux profondo
                'brand-red': '#B4182D',    // rosso caldo
                'brand-peach': '#FDA481',  // pesca chiaro
                'brand-blue': '#37415C',   // blu classico
                'brand-navy': '#242E49',   // blu notte medio
                'brand-dark': '#181A2F',   // blu notte scuro
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
