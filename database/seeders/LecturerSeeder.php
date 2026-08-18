<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Lecturer;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Khởi tạo Faker tiếng Việt
        $faker = Faker::create('vi_VN');

        // Chuẩn bị danh sách chuyên ngành
        $specializations = ['Công nghệ phần mềm', 'Khoa học máy tính', 'Hệ thống thông tin', 'An toàn thông tin', 'Mạng máy tính'];

        // Tạo 15 giảng viên mẫu
        for ($i = 0; $i < 15; $i++) {
            DB::transaction(function () use ($faker, $specializations) {
                // 1. Tạo tài khoản User trước
                $user = User::create([
                    'name' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'password' => Hash::make('123456'), // Mật khẩu chung dễ test
                    'role' => 'lecturer',
                ]);

                // 2. Tạo hồ sơ Lecturer tương ứng
                Lecturer::create([
                    'user_id' => $user->id,
                    'lecturer_code' => $faker->unique()->numerify('GV####'),
                    'specialization' => $faker->randomElement($specializations),
                    'quota' => $faker->randomElement([3, 4, 5, 6]), // Số lượng sinh viên tối đa
                    'phone' => $faker->phoneNumber(),
                ]);
            });
        }
    }
}
