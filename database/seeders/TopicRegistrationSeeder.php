<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TopicRegistration;
use App\Models\Student;
use App\Models\Topic;
use Carbon\Carbon;

class TopicRegistrationSeeder extends Seeder
{
    public function run()
    {
        // 1. Lấy toàn bộ danh sách sinh viên và đề tài hiện có
        $students = Student::all();
        $topics = Topic::all();

        // Nếu DB chưa có sinh viên hoặc đề tài thì dừng lại, không chạy lỗi
        if ($students->isEmpty() || $topics->isEmpty()) {
            return; 
        }

        $statuses = ['Pending', 'Approved', 'Rejected'];

        // 2. Lặp qua từng sinh viên, mỗi sinh viên chỉ xử lý 1 lần
        foreach ($students as $student) {
            
            // Dùng hàm ngẫu nhiên (tỉ lệ 70%) để quyết định xem sinh viên này có tham gia đăng ký đồ án không
            // Tránh việc sinh viên nào cũng có đơn, nhìn data sẽ bị "giả"
            if (rand(1, 100) <= 70) {
                
                // Bốc ngẫu nhiên 1 đề tài cho sinh viên này
                $randomTopic = $topics->random();
                
                // Bốc ngẫu nhiên 1 trạng thái
                $randomStatus = $statuses[array_rand($statuses)];

                // Tạo đơn đăng ký
                TopicRegistration::create([
                    'student_id' => $student->id,
                    'topic_id' => $randomTopic->id,
                    'status' => $randomStatus,
                    'registered_at' => Carbon::now()->subDays(rand(1, 30)), // Ngày đăng ký random lùi về quá khứ
                ]);
            }
        }
    }
}