<?php

// Import kelas yang dibutuhkan untuk membuat migrasi
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel hpps saat migrasi dijalankan
    public function up(): void
    {
        Schema::create('hpps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->string('file_hpp');
            $table->timestamps();
        });
    }

    // Menghapus tabel hpps saat migrasi dibatalkan (rollback)
    public function down(): void
    {
        Schema::dropIfExists('hpps');
    }
};
