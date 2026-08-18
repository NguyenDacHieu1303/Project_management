<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\User;
use App\Http\Requests\StoreLecturerRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Topic;
use App\Models\TopicRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    // 1. Hiển thị danh sách Giảng viên
    public function index()
    {
        $lecturers = Lecturer::with('user')->withCount('topicAssignments as assignments_count')->latest()->paginate(10);
        return view('lecturer.index', compact('lecturers'));
    }

    // 2. Giao diện trang Thêm Giảng viên
    public function create()
    {
        return view('lecturer.create');
    }

    // 3. Xử lý lưu Giảng viên mới
    public function store(StoreLecturerRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'role' => 'lecturer',
            ]);

            Lecturer::create([
                'user_id' => $user->id,
                'lecturer_code' => $request->lecturer_code,
                'specialization' => $request->specialization,
                'quota' => $request->quota ?? 5,
                'phone' => $request->phone,
            ]);
        });

        return redirect()->route('lecturers.index')->with('success', 'Thêm giảng viên thành công!');
    }

    // 4. Giao diện Chỉnh sửa
    public function edit(Lecturer $lecturer)
    {
        return view('lecturer.edit', compact('lecturer'));
    }

    // 5. Xử lý Cập nhật thông tin
    public function update(StoreLecturerRequest $request, Lecturer $lecturer)
    {
        DB::transaction(function () use ($request, $lecturer) {
            $lecturer->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $lecturer->update([
                'lecturer_code' => $request->lecturer_code,
                'specialization' => $request->specialization,
                'quota' => $request->quota,
                'phone' => $request->phone,
            ]);
        });

        return redirect()->route('lecturers.index')->with('success', 'Cập nhật thông tin giảng viên thành công!');
    }

    // 6. Xóa Giảng viên
    public function destroy(Lecturer $lecturer)
    {
        $lecturer->user->delete();
        return redirect()->route('lecturers.index')->with('success', 'Đã xóa giảng viên!');
    }

    // =====================================================
    // TÍNH NĂNG DÀNH CHO GIẢNG VIÊN (QUẢN LÝ QUA BẢNG ASSIGNMENTS)
    // =====================================================

    // 1. Xem danh sách đề tài do giảng viên hướng dẫn
    public function topics()
    {
        $lecturer = Lecturer::where('user_id', Auth::id())->firstOrFail();

        // Sửa: Lấy qua bảng trung gian topic_assignments thay vì gọi lecturer_id ở bảng topics
        $topics = Topic::whereHas('assignment', function($q) use ($lecturer) {
                        $q->where('lecturer_id', $lecturer->id);
                    })
                    ->with(['registrations' => function($q) {
                        $q->where('status', 'Approved')->with('student.user');
                    }])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('lecturer.topics', compact('topics'));
    }

    // 2. Xem danh sách sinh viên đăng ký để duyệt
    public function registrations()
    {
        $lecturer = Lecturer::where('user_id', Auth::id())->firstOrFail();

        // Sửa: Lọc đề tài qua quan hệ assignment với giảng viên
        $registrations = TopicRegistration::whereHas('topic.assignment', function($q) use ($lecturer) {
                              $q->where('lecturer_id', $lecturer->id);
                          })
                          ->with(['topic', 'student.user'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);

        return view('lecturer.registrations', compact('registrations'));
    }

    // 3. Xem danh sách bài nộp / tiến độ của sinh viên
    public function studentSubmissions()
    {
        $lecturer = Lecturer::where('user_id', Auth::id())->firstOrFail();

        // Sửa: Lọc bài nộp dựa trên đề tài do giảng viên này hướng dẫn
        $registrations = TopicRegistration::whereHas('topic.assignment', function($q) use ($lecturer) {
                              $q->where('lecturer_id', $lecturer->id);
                          })
                          ->where('status', 'Approved')
                          ->with(['topic', 'student.user'])
                          ->paginate(10);

        return view('lecturer.submissions', compact('registrations'));
    }

    // 4. Chấm điểm hoặc nhận xét bài nộp
    public function storeEvaluation(Request $request, $registrationId)
    {
        $request->validate([
            'score' => 'nullable|numeric|min:0|max:10',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $registration = TopicRegistration::findOrFail($registrationId);
        
        $registration->score = $request->score;
        $registration->feedback = $request->feedback;
        $registration->save();

        return redirect()->back()->with('success', 'Đã cập nhật điểm và nhận xét thành công!');
    }
}