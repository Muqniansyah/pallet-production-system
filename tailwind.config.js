import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

// Konfigurasi Tailwind CSS
export default {
    // Daftar file yang dipindai untuk mendeteksi class Tailwind yang dipakai
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            // Mengganti font default dengan Figtree
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    // Plugin Tailwind untuk styling form input
    plugins: [forms],
};
