<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TopicRegistrationController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\TopicAssignmentController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\MilestoneSubmissionController;

// 1. Trang chủ công khai
Route::get('/', function () {
    return view('welcome');
});

// 2. Các route yêu cầu phải đăng nhập mới được truy cập
Route::middleware(['auth'])->group(function () {

    // Quản lý sinh viên & đề tài chung
    Route::resource('students', StudentController::class);
    Route::resource('topics', TopicController::class);

    // Đăng ký đề tài của sinh viên
    Route::resource('topic-registrations', TopicRegistrationController::class)->only(['index', 'store']);
    Route::put('topic-registrations/{id}/update-status', [TopicRegistrationController::class, 'updateStatus'])->name('topic-registrations.update_status');

    // Quản lý Giảng viên (CRUD đầy đủ cho Admin)
    Route::resource('lecturers', LecturerController::class);

    // Phân công giảng viên hướng dẫn (Admin)
    Route::get('assignments', [TopicAssignmentController::class, 'index'])->name('assignments.index');
    Route::get('assignments/create', [TopicAssignmentController::class, 'create'])->name('assignments.create');
    Route::post('assignments', [TopicAssignmentController::class, 'store'])->name('assignments.store');
    Route::delete('assignments/{assignment}', [TopicAssignmentController::class, 'destroy'])->name('assignments.destroy');

    // Nhóm tính năng dành riêng cho GIẢNG VIÊN (Lecturer)
    Route::prefix('lecturer')->name('lecturer.')->group(function () {
        Route::get('/topics', [LecturerController::class, 'topics'])->name('topics');
        Route::get('/registrations', [LecturerController::class, 'registrations'])->name('registrations');
        Route::get('/submissions', [LecturerController::class, 'studentSubmissions'])->name('submissions');
        Route::patch('/submissions/{id}/evaluate', [LecturerController::class, 'storeEvaluation'])->name('submissions.evaluate');
    });

});