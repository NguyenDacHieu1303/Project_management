<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Milestone;
use App\Models\Student;
use App\Models\MilestoneSubmission;
use Carbon\Carbon;

class MilestoneSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lấy danh sách sinh viên và milestones
        $students = Student::all();
        $milestones = Milestone::all();

        if ($students->isEmpty() || $milestones->isEmpty()) {
            return;
        }

        // Tạo submission cho mỗi sinh viên và milestone
        foreach ($milestones as $milestone) {
            foreach ($students as $student) {
                
                // 60% sinh viên nộp bài cho milestone này
                if (rand(1, 100) <= 60) {
                    MilestoneSubmission::create([
                        'milestone_id' => $milestone->id,
                        'student_id' => $student->id,
                        'file_path' => 'submissions/milestone_' . $milestone->id . '_student_' . $student->id . '.pdf',
                        'note' => 'Bài nộp cho ' . $milestone->title,
                        'submitted_at' => Carbon::now()->subDays(rand(1, 20)),
                    ]);
                }
            }
        }
    }
}
