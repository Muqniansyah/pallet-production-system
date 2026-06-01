<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MeetingRequest extends Model
{
    // daftar kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'client_id',
        'judul',
        'deskripsi',
        'start_time',
        'durasi',
        'status',
        'keterangan',
        'zoom_meeting_id',
        'start_url',
        'join_url',
    ];

    // menghubungkan tabel meetings dengan users sebagai klien (relasi m:1)
    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
