import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        watch: {
            // Aktifkan polling untuk meningkatkan stabilitas di lingkungan tertentu (seperti WSL/VM)
            usePolling: true,
            
            // PENTING: Mengabaikan file .env agar server Vite tidak restart
            // setiap kali perubahan pada .env terdeteksi.
            ignored: ['**/.env**'], 
        },
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: ['resources/views/**'],
        }),
    ],
});