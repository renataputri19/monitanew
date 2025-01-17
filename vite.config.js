import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/nilai.css',  // Add this line
                'resources/js/app.js',
                'resources/js/nilai.js',    // Add this line
            ],
            refresh: true,
        }),
    ],
});