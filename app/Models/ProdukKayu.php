<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukKayu extends Model
{
    protected $table = 'produk_kayu';

    protected $fillable = [
        'nama_produk',
        'gambar',
        'satuan',
        'keterangan'
    ];

    public function stok()
    {
        return $this->hasOne(StokKayu::class);
    }
}
