<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // 2. Xử lý đăng nhập
    public function login(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Gọi Auth::attempt() để Laravel tự động kiểm tra DB
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/')->with('success', 'Đăng nhập thành công!');
        }

        // Nếu sai mật khẩu thì đá về trang cũ kèm báo lỗi
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    // 3. Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $user->id,
            'student_code' => 'SV' . str_pad((string) (Student::max('id') + 1), 6, '0', STR_PAD_LEFT),
            'class' => 'Chưa cập nhật',
            'major' => 'Chưa cập nhật',
            'course' => date('Y'),
            'phone' => null,
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Đăng ký thành công!');
    }
}