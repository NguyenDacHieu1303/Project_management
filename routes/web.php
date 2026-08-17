<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TopicRegistrationController;

Route::resource('students', StudentController::class);
Route::resource('topics', TopicController::class);
// Thêm nhóm Route cho Đăng ký đề tài
Route::resource('topic-registrations', TopicRegistrationController::class)->only(['index', 'store']);
// Thêm 1 route riêng để xử lý nút Duyệt / Từ chối đơn
Route::put('topic-registrations/{id}/update-status', [TopicRegistrationController::class, 'updateStatus'])->name('topic-registrations.update_status');
Route::get('/', function () {
    return view('welcome');
});
