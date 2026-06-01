<?php

// Import kelas yang dibutuhkan untuk membuat migrasi
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel stok_kayu saat migrasi dijalankan
    public function up(): void
    {
        Schema::create('stok_kayu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_kayu_id')->constrained('produk_kayu')->onDelete('cascade');
            $table->integer('stok')->default(0);
            $table->timestamps();
        });
    }

    // Menghapus tabel stok_kayu saat migrasi dibatalkan (rollback)
    public function down(): void
    {
        Schema::dropIfExists('stok_kayu');
    }
};
