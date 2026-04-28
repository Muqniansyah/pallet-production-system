<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hpp extends Model
{
    protected $fillable = [
        'order_id',
        'file_hpp',
        'keterangan'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
