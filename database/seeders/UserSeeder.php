<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
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
       User::create([
            'name' => 'Quản trị viên Hệ thống',
            'email' => 'admin@gmail.com', // Cố định email để dễ đăng nhập
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);
    }
}
