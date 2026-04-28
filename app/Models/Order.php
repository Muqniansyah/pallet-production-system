<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'pallet_request_id',
        'nama_project',
        'qty',
        'status'
    ];

    // relasi ke client (user)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // relasi ke pallet request
    public function palletRequest()
    {
        return $this->belongsTo(PalletRequest::class);
    }

    // relasi ke HPP
    public function hpp()
    {
        return $this->hasOne(Hpp::class);
    }
}
