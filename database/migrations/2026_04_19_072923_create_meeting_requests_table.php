<?php

// Import kelas yang dibutuhkan untuk membuat migrasi
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel meeting_requests saat migrasi dijalankan
    public function up(): void
    {
        Schema::create('meeting_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->dateTime('start_time');
            $table->integer('durasi'); // menit
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->string('zoom_meeting_id')->nullable();
            $table->text('start_url')->nullable();
            $table->text('join_url')->nullable();
            $table->timestamps();
        });
    }

    // Menghapus tabel meeting_requests saat migrasi dibatalkan (rollback)
    public function down(): void
    {
        Schema::dropIfExists('meeting_requests');
    }
};
