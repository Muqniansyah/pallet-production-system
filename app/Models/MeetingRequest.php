<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MeetingRequest extends Model
{
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

    // menghubungkan tabel meetings dengan tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
