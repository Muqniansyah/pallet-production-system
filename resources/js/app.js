// Menjalankan konfigurasi awal dari file bootstrap.js
import "./bootstrap";

// import anime js package lokal (diinstall via npm)
// import anime from "animejs";

// Mengimport dan menginisialisasi Alpine.js untuk interaktivitas UI
import Alpine from "alpinejs";

// Mendaftarkan Alpine.js ke window agar bisa diakses global
window.Alpine = Alpine;

// Menjalankan Alpine.js
Alpine.start();
