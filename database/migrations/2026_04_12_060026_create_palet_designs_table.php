<?php

// FILE: database/migrations/xxxx_xx_xx_create_palet_designs_table.php
// Jalankan: php artisan migrate

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('palet_designs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // === Dimensi Utama Palet ===
            $table->decimal('dimensi_panjang', 10, 2)->nullable();
            $table->decimal('dimensi_lebar', 10, 2)->nullable();

            // === Papan Atas ===
            $table->decimal('papan_atas_tebal', 10, 2)->nullable();
            $table->decimal('papan_atas_lebar', 10, 2)->nullable();
            $table->integer('papan_atas_jumlah')->nullable();
            $table->decimal('papan_atas_gap', 10, 2)->nullable();
            $table->string('papan_atas_arah', 20)->nullable(); // horizontal/vertical

            // === Lapisan Tengah ===
            $table->string('lapisan_tengah_tipe', 50)->nullable();
            $table->decimal('lapisan_tengah_tinggi', 10, 2)->nullable();
            $table->decimal('lapisan_tengah_lebar', 10, 2)->nullable();
            $table->integer('lapisan_tengah_jumlah')->nullable();
            $table->string('lapisan_tengah_susunan', 50)->nullable();
            $table->string('lapisan_tengah_arah', 20)->nullable();

            // === Papan Bawah ===
            $table->decimal('papan_bawah_tebal', 10, 2)->nullable();
            $table->decimal('papan_bawah_lebar', 10, 2)->nullable();
            $table->integer('papan_bawah_jumlah')->nullable();
            $table->string('papan_bawah_arah', 20)->nullable();
            $table->string('papan_bawah_pola', 50)->nullable();
            $table->decimal('papan_bawah_gap_manual', 10, 2)->nullable();

            // === Kalibrasi & Gesture ===
            $table->decimal('kalibrasi_lebar_tangan', 10, 2)->nullable();
            $table->string('mode_tracking', 20)->nullable(); // mode1/mode2

            // === Dimensi Terdeteksi (Hand Gesture ML) ===
            $table->decimal('gesture_x', 10, 2)->nullable();
            $table->decimal('gesture_y', 10, 2)->nullable();
            $table->decimal('gesture_z', 10, 2)->nullable();

            // === Hasil Kalkulasi / Output ===
            $table->json('hasil_kalkulasi')->nullable(); // simpan semua output sebagai JSON
            $table->json('raw_payload')->nullable();     // backup seluruh data mentah dari netlify

            // === Meta ===
            $table->string('session_id', 100)->nullable(); // track sesi user
            $table->timestamp('last_updated_at')->nullable(); // kapan terakhir berubah
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('palet_designs');
    }
};
