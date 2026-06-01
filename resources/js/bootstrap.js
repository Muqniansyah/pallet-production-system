// Mengimport axios untuk request HTTP (AJAX)
import axios from "axios";

// Mendaftarkan axios ke window agar bisa diakses global
window.axios = axios;

// Menambahkan header X-Requested-With agar Laravel mengenali request sebagai AJAX
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
