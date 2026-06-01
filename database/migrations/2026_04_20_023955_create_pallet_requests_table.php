<?php

// Import kelas yang dibutuhkan untuk membuat migrasi
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel pallet_requests saat migrasi dijalankan
    public function up(): void
    {
        Schema::create('pallet_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->string('jenis_palet');
            $table->integer('qty');
            $table->string('file_desain')->nullable();
            $table->text('alamat_kirim');
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    // Menghapus tabel pallet_requests saat migrasi dibatalkan (rollback)
    public function down(): void
    {
        Schema::dropIfExists('pallet_requests');
    }
};
