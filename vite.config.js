import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/style.css', 
                'resources/js/dashboard.js',
                'resources/js/bootstrap.js',
                'resources/js/login.js',
                'resources/js/admin.js'
            ],
            refresh: true,
        }),
    ],
});
