import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

// Konfigurasi Vite untuk Laravel
export default defineConfig({
    plugins: [
        laravel({
            // File CSS dan JS utama yang dikompilasi oleh Vite
            input: ["resources/css/app.css", "resources/js/app.js"],
            // Auto reload halaman saat ada perubahan pada file blade
            refresh: true,
        }),
    ],
});
