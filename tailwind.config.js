import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/masmerise/livewire-toaster/resources/views/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        colors:{
            'primario': {
                '50': '#f1f7fa',
                '100': '#dcebf1',
                '200': '#bdd8e4',
                '300': '#90bcd0',
                '400': '#649db9',
                '500': '#407b9a',
                '600': '#386582',
                '700': '#32546c',
                '800': '#30485a',
                '900': '#2c3d4d',
                '950': '#192733',
            },
            'secundario': {
                '50': '#faf6ec',
                '100': '#f3e8ce',
                '200': '#e9cf9f',
                '300': '#dcaf68',
                '400': '#d0923f',
                '500': '#c17e31',
                '600': '#985925',
                '700': '#854723',
                '800': '#6f3b24',
                '900': '#603223',
                '950': '#371811',
            },
            
            
        }
        },
    },

    plugins: [forms],
};
