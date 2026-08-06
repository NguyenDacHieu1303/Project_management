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

    public function milestone()
    {
        return $this->belongsTo(Milestone::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}