<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokKayu extends Model
{
    protected $table = 'stok_kayu'; // memberitahu Laravel nama tabel yang digunakan model ini secara eksplisit.

    // daftar kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'produk_kayu_id',
        'admin_id',
        'stok'
    ];

    // menghubungkan tabel stok_kayu dengan produk_kayu sebagai produk_kayu_id (relasi 1:1)
    public function produk()
    {
        return $this->belongsTo(ProdukKayu::class, 'produk_kayu_id');
    }

    // menghubungkan tabel stok_kayu dengan users sebagai admin (relasi m:1)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
