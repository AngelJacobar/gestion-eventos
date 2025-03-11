import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin'
import manifestSRI from 'vite-plugin-manifest-sri';

export default defineConfig({
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler'
            },
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        manifestSRI(),
    ],
});
