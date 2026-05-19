<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokKayu extends Model
{
    protected $table = 'stok_kayu';

    protected $fillable = [
        'produk_kayu_id',
        'stok'
    ];

    public function produk()
    {
        return $this->belongsTo(ProdukKayu::class, 'produk_kayu_id');
    }
}
