<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'major',
        'semester',
        'status',
        'lecturer_id',
    ];

    public function assignment()
    {
        return $this->hasOne(TopicAssignment::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function registrations()
    {
        return $this->hasMany(TopicRegistration::class);
    }

    public function topicRegistrations()
    {
        return $this->hasMany(TopicRegistration::class);
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }
}
  
