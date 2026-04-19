<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('palet_designs', function (Blueprint $table) {
            // Tambahkan kolom yang belum ada, cek dulu mana yang kurang
            if (!Schema::hasColumn('palet_designs', 'session_id')) {
                $table->string('session_id', 100)->nullable();
            }
            if (!Schema::hasColumn('palet_designs', 'raw_payload')) {
                $table->json('raw_payload')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('palet_designs', function (Blueprint $table) {
            $table->dropColumnIfExists('session_id');
            $table->dropColumnIfExists('raw_payload');
        });
    }
};
