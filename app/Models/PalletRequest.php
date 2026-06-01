<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PalletRequest extends Model
{
    // daftar kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'client_id',
        'jenis_palet',
        'qty',
        'file_desain',
        'alamat_kirim',
        'catatan',
        'status',
        'keterangan',
    ];

    // menghubungkan tabel palletrequest dengan users sebagai klien (relasi m:1)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // menghubungkan tabel palletrequest dengan pesanan (relasi 1:1)
    public function pesanan()
    {
        return $this->hasOne(Pesanan::class);
    }
}
