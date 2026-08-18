<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // 1. Tài khoản Admin (Toàn quyền)
        User::firstOrCreate(
            ['email' => 'admin@tlu.edu.vn'],
            [
                'name' => 'Quản trị viên Hệ thống',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );

        // 2. Tài khoản Giảng viên (Duyệt đơn)
        User::firstOrCreate(
            ['email' => 'giangvien@tlu.edu.vn'],
            [
                'name' => 'Thầy Nguyễn Văn A',
                'password' => Hash::make('123456'),
                'role' => 'lecturer',
            ]
        );

        // 3. Tài khoản Sinh viên demo (Đăng ký đề tài)
        $studentUser = User::firstOrCreate(
            ['email' => 'sinhvien@tlu.edu.vn'],
            [
                'name' => 'Sinh viên Demo',
                'password' => Hash::make('123456'),
                'role' => 'student',
            ]
        );

        // Tạo hồ sơ sinh viên tương ứng để liên kết với user
        Student::firstOrCreate(
            ['user_id' => $studentUser->id],
            [
                'student_code' => '2251060001',
                'class' => '64CNTT1',
                'major' => 'Công nghệ thông tin',
                'course' => 'K64',
                'phone' => '0900000001',
            ]
        );
    }
}
