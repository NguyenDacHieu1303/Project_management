<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TopicRegistrationController;
use App\Http\Controllers\AuthController;

Route::resource('students', StudentController::class);
Route::resource('topics', TopicController::class);
// Thêm nhóm Route cho Đăng ký đề tài
Route::resource('topic-registrations', TopicRegistrationController::class)->only(['index', 'store']);
// Thêm 1 route riêng để xử lý nút Duyệt / Từ chối đơn
Route::put('topic-registrations/{id}/update-status', [TopicRegistrationController::class, 'updateStatus'])->name('topic-registrations.update_status');


// Các Route dành cho Đăng nhập / Đăng xuất
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);

Route::get('/', function () {
    return view('welcome');
});
