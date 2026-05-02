<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PalletRequest extends Model
{
    protected $fillable = [
        'client_id',
        'nama_project',
        'jenis_palet',
        'qty',
        'file_desain',
        'alamat_kirim',
        'catatan',
        'status',
        'rejection_note',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
