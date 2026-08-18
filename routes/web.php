<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TopicRegistrationController;
use App\Http\Controllers\AuthController;

// ==========================================
// 1. PUBLIC (Khách vãng lai cũng vào được)
// ==========================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


// ==========================================
// 2. PRIVATE (Bắt buộc phải Đăng nhập)
// ==========================================
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- CHUNG: Ai cũng xem được ---
    Route::resource('topics', TopicController::class);
    Route::resource('topic-registrations', TopicRegistrationController::class)->only(['index', 'store']);


    // --- PHÒNG CỦA ADMIN ---
    Route::middleware(['role:admin'])->group(function () {
        // Chỉ Admin được thêm/sửa/xóa Sinh viên
        Route::resource('students', StudentController::class);
    });


    // --- PHÒNG CỦA GIẢNG VIÊN ---
    Route::middleware(['role:lecturer'])->group(function () {
        // Chỉ Giảng viên được duyệt đơn
        Route::put('topic-registrations/{id}/update-status', [TopicRegistrationController::class, 'updateStatus'])->name('topic-registrations.update_status');
    });


    // --- PHÒNG CỦA SINH VIÊN ---
    Route::middleware(['role:student'])->group(function () {
        Route::get('/topics/register-list', [App\Http\Controllers\TopicController::class, 'registerList'])->name('topics.register-list')->middleware(['auth']);
    });
});
