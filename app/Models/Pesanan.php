<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan'; // memberitahu Laravel nama tabel yang digunakan model ini secara eksplisit.

    // daftar kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'client_id',
        'pallet_request_id',
        'nama_project',
        'qty',
        'status'
    ];

    // menghubungkan tabel pesanan dengan users sebagai klien (relasi m:1)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // menghubungkan tabel pesanan dengan pallet request (relasi 1:1)
    public function palletRequest()
    {
        return $this->belongsTo(PalletRequest::class);
    }

    // menghubungkan tabel pesanan dengan HPP sebagai pesanan_id (relasi 1:1)
    public function hpp()
    {
        return $this->hasOne(Hpp::class, 'pesanan_id');
    }
}
