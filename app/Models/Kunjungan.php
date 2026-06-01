<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan'; // memberitahu Laravel nama tabel yang digunakan model ini secara eksplisit.

    // daftar kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'client_id',
        'judul',
        'tanggal_kunjungan',
        'status',
        'keterangan'
    ];

    // menghubungkan tabel kunjungan dengan users sebagai klien (relasi m:1)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
