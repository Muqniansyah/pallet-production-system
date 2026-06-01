<?php

// Import kelas yang dibutuhkan untuk membuat migrasi
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel pesanan saat migrasi dijalankan
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pallet_request_id')->constrained()->onDelete('cascade');
            $table->string('nama_project');
            $table->integer('qty');
            $table->enum('status', ['pending', 'deal', 'batal'])->default('pending');
            $table->timestamps();
        });
    }

    // Menghapus tabel pesanan saat migrasi dibatalkan (rollback)
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
