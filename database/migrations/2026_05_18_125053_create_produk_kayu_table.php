<?php

// Import kelas yang dibutuhkan untuk membuat migrasi
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel produk_kayu saat migrasi dijalankan
    public function up(): void
    {
        Schema::create('produk_kayu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama_produk');
            $table->string('gambar')->nullable();
            $table->string('satuan')->default('PCS');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    // Menghapus tabel produk_kayu saat migrasi dibatalkan (rollback)
    public function down(): void
    {
        Schema::dropIfExists('produk_kayu');
    }
};
