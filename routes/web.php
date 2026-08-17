<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TopicRegistrationController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\TopicAssignmentController;


Route::resource('students', StudentController::class);
Route::resource('topics', TopicController::class);
// Thêm nhóm Route cho Đăng ký đề tài
Route::resource('topic-registrations', TopicRegistrationController::class)->only(['index', 'store']);
// Thêm 1 route riêng để xử lý nút Duyệt / Từ chối đơn
Route::put('topic-registrations/{id}/update-status', [TopicRegistrationController::class, 'updateStatus'])->name('topic-registrations.update_status');
Route::get('/', function () {
    return view('welcome');
});


    // Quản lý Giảng viên (CRUD đầy đủ)
    Route::resource('lecturers', LecturerController::class);

    // Phân công giảng viên hướng dẫn
    Route::get('assignments', [TopicAssignmentController::class, 'index'])->name('assignments.index');
    Route::get('assignments/create', [TopicAssignmentController::class, 'create'])->name('assignments.create');
    Route::post('assignments', [TopicAssignmentController::class, 'store'])->name('assignments.store');
    Route::delete('assignments/{assignment}', [TopicAssignmentController::class, 'destroy'])->name('assignments.destroy');

