<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
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

        // Tạo 50 sinh viên mẫu
        for ($i = 0; $i < 50; $i++) {
            DB::transaction(function () use ($faker) {
                $email = $faker->unique()->safeEmail();

                // 1. Tạo hoặc lấy tài khoản User trước
                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $faker->name(),
                        'password' => Hash::make('123456'),
                        'role' => 'student',
                    ]
                );

                // 2. Tạo hồ sơ Student tương ứng
                $studentCode = $faker->unique()->numerify('225106####');

                Student::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'student_code' => $studentCode,
                        'class' => $faker->randomElement(['64CNTT1', '64CNTT2', '63HTTT', '63CNPM']),
                        'major' => 'Công nghệ thông tin',
                        'course' => 'K64',
                        'phone' => $faker->phoneNumber(),
                    ]
                );
            });
        }
    }
}