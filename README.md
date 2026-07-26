# SIPALET - Sistem Informasi Manajemen Produksi dan Desain Palet

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-v13.4.0-red?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-v8.3.12-blue?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/PostgreSQL-14.5-blue?style=for-the-badge&logo=postgresql" alt="PostgreSQL">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>

---

## 📖 Tentang SIPALET

**SIPALET** (Sistem Informasi Manajemen Produksi dan Desain Palet) adalah aplikasi berbasis web yang dikembangkan untuk **PT Menara Bekasi Lestari**, perusahaan yang bergerak di bidang perdagangan dan ekspor produk kayu, sebagai bagian dari penelitian skripsi yang berjudul **"Pengembangan Sistem Manajemen Produksi dan Desain Palet PT Menara Bekasi Lestari"**.

Sistem ini dirancang untuk mendigitalkan dan mengintegrasikan seluruh proses pengelolaan desain palet, pengajuan kebutuhan, pemantauan pesanan, penjadwalan koordinasi, hingga pengelolaan dokumen Harga Pokok Produksi (HPP) dalam satu platform terpusat.

---

## ✨ Fitur Utama

### 👨‍💼 Admin Perusahaan
- Pengelolaan akun & hak akses pengguna
- Peninjauan & persetujuan pengajuan desain palet
- Pengelolaan data pesanan
- Pengunggahan & pengelolaan dokumen HPP
- Pengaturan & konfirmasi jadwal pertemuan (Zoom Meeting)
- Pengaturan & konfirmasi jadwal kunjungan
- Pengelolaan stok & referensi produk kayu

### 👤 Klien
- Registrasi & login akun
- Melihat referensi & spesifikasi produk kayu
- Pembuatan desain palet (PaletView 3D)
- Pengajuan kebutuhan & desain palet
- Pemantauan status & rincian pesanan
- Akses & unduh dokumen HPP
- Pengajuan jadwal Zoom Meeting
- Pengajuan jadwal kunjungan
- Pusat informasi & bantuan

---

## 🛠️ Teknologi yang Digunakan

| Komponen | Teknologi |
|---|---|
| Backend Framework | Laravel 13.4.0 |
| Bahasa Pemrograman | PHP 8.3.12 |
| Database | PostgreSQL 14.5 |
| Web Server | Apache 2.4.62 (Laragon) |
| Frontend | Blade Template, CSS, JavaScript, Vite |
| Code Editor | Visual Studio Code |
| Browser | Google Chrome, Mozilla Firefox |

---

## ⚙️ Persyaratan Sistem

### Perangkat Lunak
- PHP >= 8.3.12
- Composer
- Node.js & NPM
- PostgreSQL 14.5
- Laravel 13.4.0
- Laragon (web server lokal)

### Perangkat Keras (Minimum)
- Prosesor: 2.20 GHz
- RAM: 12 GB
- Penyimpanan: SSD 224 GB
- Resolusi Layar: 1366 × 768 piksel
- Koneksi Internet: 10 Mbps

---

## 🚀 Cara Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/Muqniansyah/pallet-production-system.git
cd pallet-production-system
```

### 2. Install Dependency PHP
```bash
composer install
```

### 3. Install Dependency Frontend
```bash
npm install
```

### 4. Salin File Environment
```bash
cp .env.example .env
```

### 5. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database PostgreSQL kamu:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=sipalet
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 6. Generate Application Key
```bash
php artisan key:generate
```

### 7. Jalankan Migrasi Database
```bash
php artisan migrate
```

### 8. Jalankan Seeder (Opsional)
```bash
php artisan db:seed
```

### 9. Build Asset Frontend
```bash
# Untuk production
npm run build

# Untuk development
npm run dev
```

### 10. Jalankan Aplikasi
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

---

## 📁 Struktur Database

Sistem ini menggunakan 9 tabel utama:

- `users` — Data autentikasi dan peran pengguna
- `palet_designs` — Parameter desain palet
- `pallet_requests` — Pengajuan kebutuhan desain palet
- `pesanan` — Data pesanan produksi
- `hpps` — Dokumen Harga Pokok Produksi
- `meeting_requests` — Jadwal pertemuan daring (Zoom Meeting)
- `kunjungan` — Jadwal kunjungan lapangan
- `produk_kayu` — Referensi & stok produk kayu
- `stok_kayu` — Ketersediaan stok material

---

## 👨‍💻 Pengembang

**Muqniansyah Arifin**
Program Studi Informatika
Fakultas Teknik dan Informatika
Universitas Bina Sarana Informatika
Kampus Kaliabang Bekasi — 2026
