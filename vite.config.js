import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        vue(),
    ],
    server: {
        host: '0.0.0.0',
        origin: 'http://localhost:5173',
        cors: {
            origin: ['http://localhost', 'http://localhost:80', 'http://127.0.0.1'],
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
