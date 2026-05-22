<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hpp extends Model
{
    protected $fillable = [
        'pesanan_id',
        'file_hpp',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
