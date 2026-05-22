<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';

    protected $fillable = [
        'client_id',
        'judul',
        'tanggal_kunjungan',
        'status',
        'keterangan'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
