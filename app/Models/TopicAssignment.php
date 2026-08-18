<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'lecturer_id',
        'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}