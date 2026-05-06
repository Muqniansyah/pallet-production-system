<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitSchedule extends Model
{
    protected $fillable = [
        'client_id',
        'title',
        'visit_date',
        'status',
        'note'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
