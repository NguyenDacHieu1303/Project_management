<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TopicRegistrationController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\TopicAssignmentController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\MilestoneSubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Giao diện Đăng nhập & Đăng ký
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Logic xử lý khi submit form Login
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        // Chuyển hướng theo Role
        if ($user->role === 'admin') {
            return redirect()->route('topics.index');
        } elseif ($user->role === 'lecturer') {
            return redirect()->route('lecturer.topics');
        } else {
            return redirect()->route('topics.index');
        }
    }

    return back()->withErrors([
        'email' => 'Email hoặc mật khẩu không chính xác.',
    ])->onlyInput('email');
});

// Logic xử lý khi bấm nút Đăng xuất trên Navbar
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// ==========================================
// CÁC ROUTE YÊU CẦU ĐĂNG NHẬP
// ==========================================
Route::middleware(['auth'])->group(function () {

    // Quản lý sinh viên, đề tài & MỐC NỘP (Admin)
    Route::resource('students', StudentController::class);
    Route::resource('topics', TopicController::class);
    
    // Đã chuyển 2 dòng này ra ngoài, ngang hàng với topics
    Route::resource('milestones', MilestoneController::class);
    Route::resource('milestone-submissions', MilestoneSubmissionController::class);

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

    // ==========================================
    // NHÓM DÀNH RIÊNG CHO GIẢNG VIÊN
    // ==========================================
    Route::prefix('lecturer')->name('lecturer.')->group(function () {
        Route::get('/topics', [LecturerController::class, 'topics'])->name('topics');
        Route::get('/registrations', [LecturerController::class, 'registrations'])->name('registrations');
        Route::get('/submissions', [LecturerController::class, 'studentSubmissions'])->name('submissions');
        Route::patch('/submissions/{id}/evaluate', [LecturerController::class, 'storeEvaluation'])->name('submissions.evaluate');
    });

});