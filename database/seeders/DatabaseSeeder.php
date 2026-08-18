<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,                      // 1. Tạo tài khoản Admin
            LecturerSeeder::class,                  // 2. Tạo 15 giảng viên
            StudentSeeder::class,                   // 3. Tạo 50 sinh viên
            TopicSeeder::class,                     // 4. Tạo 20 đề tài
            TopicAssignmentSeeder::class,           // 5. Phân công giảng viên hướng dẫn
            TopicRegistrationSeeder::class,         // 6. Sinh viên đăng ký đề tài
            MilestoneSeeder::class,                 // 7. Tạo các mốc nộp cho mỗi đề tài
            MilestoneSubmissionSeeder::class,       // 8. Sinh viên nộp bài cho các mốc
        ]);
    }
}
