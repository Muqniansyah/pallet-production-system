<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MeetingRequest extends Model
{
    protected $fillable = [
        'client_id',
        'title',
        'description',
        'start_time',
        'duration',
        'status',
        'zoom_meeting_id',
        'join_url',
    ];

    // menghubungkan tabel meetings dengan tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
