<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan'; // memberitahu Laravel nama tabel yang digunakan model ini secara eksplisit.

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
        return $this->hasOne(Hpp::class, 'pesanan_id');
    }
}
