<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukKayu extends Model
{
    protected $table = 'produk_kayu'; // memberitahu Laravel nama tabel yang digunakan model ini secara eksplisit.

    // daftar kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'nama_produk',
        'gambar',
        'satuan',
        'keterangan'
    ];

    // menghubungkan tabel produk_kayu dengan stok_kayu (relasi 1:1)
    public function stok()
    {
        return $this->hasOne(StokKayu::class);
    }
}
