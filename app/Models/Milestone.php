<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'title',
        'deadline',
        'order_number',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Relationship: Milestone thuộc 1 Topic
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Relationship: Milestone có nhiều MilestoneSubmission
     */
    public function submissions()
    {
        return $this->hasMany(MilestoneSubmission::class);
    }
}
