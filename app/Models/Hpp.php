<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hpp extends Model
{
    // daftar kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'pesanan_id',
        'file_hpp',
    ];

    // menghubungkan tabel hpp dengan pesanan (relasi 1:1)
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
