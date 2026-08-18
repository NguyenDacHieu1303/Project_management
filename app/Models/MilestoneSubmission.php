<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilestoneSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'milestone_id',
        'student_id',
        'file_path',
        'note',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    /**
     * Relationship: MilestoneSubmission thuộc 1 Milestone
     */
    public function milestone()
    {
        return $this->belongsTo(Milestone::class);
    }

    /**
     * Relationship: MilestoneSubmission thuộc 1 Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
