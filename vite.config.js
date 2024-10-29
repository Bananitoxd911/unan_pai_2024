import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '127.0.0.1', // Asegúrate de que esté configurado para localhost
        port: 8000, // O el puerto que estés utilizando
        https: false, // Cambia a true si estás usando HTTPS
    },
});
