<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topic; // Gọi Model Topic
use Faker\Factory as Faker; // Gọi thư viện Faker

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Khởi tạo Faker với ngôn ngữ Tiếng Việt
        $faker = Faker::create('vi_VN');

        // Chuẩn bị sẵn các lựa chọn thực tế cho ngành IT của em
        $majors = ['Công nghệ phần mềm', 'Khoa học máy tính', 'Hệ thống thông tin', 'An toàn thông tin', 'Mạng máy tính'];
        $semesters = ['Học kỳ 1 - 2026', 'Học kỳ 2 - 2026', 'Học kỳ 1 - 2027', 'Học kỳ 2 - 2027'];
        $statuses = ['Open', 'Assigned', 'Closed'];

        // Vòng lặp tạo 20 đề tài
        for ($i = 0; $i < 20; $i++) {
            Topic::create([
                'title' => 'Xây dựng hệ thống ' . $faker->catchPhrase, 
                'description' => $faker->realText(200), // Random 1 đoạn văn khoảng 200 ký tự
                'major' => $faker->randomElement($majors), // Bốc ngẫu nhiên 1 chuyên ngành
                'semester' => $faker->randomElement($semesters), // Bốc ngẫu nhiên 1 học kỳ
                'status' => $faker->randomElement($statuses), // Bốc ngẫu nhiên trạng thái
            ]);
        }
    }
}