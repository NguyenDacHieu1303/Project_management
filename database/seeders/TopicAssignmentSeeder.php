<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TopicAssignment;
use App\Models\Lecturer;
use App\Models\Topic;
use Carbon\Carbon;

class TopicAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Lấy toàn bộ danh sách giảng viên và đề tài
        $lecturers = Lecturer::all();
        $topics = Topic::all();

        // Nếu DB chưa có giảng viên hoặc đề tài thì dừng lại
        if ($lecturers->isEmpty() || $topics->isEmpty()) {
            return;
        }

        // 2. Lặp qua từng đề tài
        foreach ($topics as $topic) {
            
            // 70% xác suất để phân công 1 giảng viên cho đề tài này
            if (rand(1, 100) <= 70) {
                
                // Bốc ngẫu nhiên 1 giảng viên
                $randomLecturer = $lecturers->random();
                
                // Tạo phân công
                TopicAssignment::create([
                    'topic_id' => $topic->id,
                    'lecturer_id' => $randomLecturer->id,
                    'assigned_at' => Carbon::now()->subDays(rand(1, 30)), // Ngày phân công random
                ]);
            }
        }
    }
}
