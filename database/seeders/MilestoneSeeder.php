<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\Milestone;
use Carbon\Carbon;

class MilestoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Danh sách các mốc tiêu chuẩn cho đồ án
        $milestoneNames = [
            ['title' => 'Đề cương', 'days_from_now' => 14],
            ['title' => 'Giữa kỳ', 'days_from_now' => 45],
            ['title' => 'Cuối kỳ', 'days_from_now' => 90],
        ];

        // Lấy tất cả đề tài
        $topics = Topic::all();

        // Tạo milestones cho mỗi đề tài
        foreach ($topics as $topic) {
            foreach ($milestoneNames as $index => $milestoneName) {
                Milestone::create([
                    'topic_id' => $topic->id,
                    'title' => $milestoneName['title'],
                    'deadline' => Carbon::now()->addDays($milestoneName['days_from_now']),
                    'order_number' => $index + 1,
                ]);
            }
        }
    }
}
