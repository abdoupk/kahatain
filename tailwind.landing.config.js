import forms from '@tailwindcss/forms'
import defaultTheme from 'tailwindcss/defaultTheme'


/** @type {import('tailwindcss').Config} */
export default {
    content: ['./resources/views/landing.blade.php'],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans]
            }
        }
    },

    plugins: [forms]
}
