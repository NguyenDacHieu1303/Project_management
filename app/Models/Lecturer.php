<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lecturer_code',
        'specialization',
        'quota',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topicAssignments()
    {
        return $this->hasMany(TopicAssignment::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}