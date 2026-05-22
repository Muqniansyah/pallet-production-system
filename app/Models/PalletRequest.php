<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PalletRequest extends Model
{
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

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function pesanan()
    {
        return $this->hasOne(Pesanan::class);
    }
}
