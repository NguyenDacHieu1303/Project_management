<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::create([
            'user_id' => 1,
            'student_code' => '2251060001',
            'class' => '64CNTT1',
            'major' => 'Công nghệ thông tin',
            'course' => 'K64',
            'phone' => '0123456789',
        ]);
    }
}
