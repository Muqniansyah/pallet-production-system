<?php

// FILE: app/Models/PaletDesign.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaletDesign extends Model
{
    protected $fillable = [
        'user_id',
        // Dimensi utama
        'dimensi_panjang',
        'dimensi_lebar',
        // Papan atas
        'papan_atas_tebal',
        'papan_atas_lebar',
        'papan_atas_jumlah',
        'papan_atas_gap',
        'papan_atas_arah',
        // Lapisan tengah
        'lapisan_tengah_tipe',
        'lapisan_tengah_tinggi',
        'lapisan_tengah_lebar',
        'lapisan_tengah_jumlah',
        'lapisan_tengah_susunan',
        'lapisan_tengah_arah',
        // Papan bawah
        'papan_bawah_tebal',
        'papan_bawah_lebar',
        'papan_bawah_jumlah',
        'papan_bawah_arah',
        'papan_bawah_pola',
        'papan_bawah_gap_manual',
        // Kalibrasi
        'kalibrasi_lebar_tangan',
        'mode_tracking',
        // Gesture
        'gesture_x',
        'gesture_y',
        'gesture_z',
        // Output
        'hasil_kalkulasi',
        'raw_payload',
        'session_id',
        'last_updated_at',
    ];

    protected $casts = [
        'hasil_kalkulasi' => 'array',
        'raw_payload'     => 'array',
        'last_updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
