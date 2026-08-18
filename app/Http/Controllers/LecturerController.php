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
use Illuminate\Http\Request; // Thêm thư viện Request để xử lý Form

class LecturerController extends Controller
{
    // 1. Hiển thị danh sách Giảng viên
    public function index()
    {
        // Lấy danh sách giảng viên kèm tài khoản User và đếm số bài đã phân công
        $lecturers = Lecturer::with('user')->withCount('topicAssignments as assignments_count')->latest()->paginate(10);
        return view('lecturer.index', compact('lecturers'));
    }

    // 2. Giao diện trang Thêm Giảng viên
    public function create()
    {
        return view('lecturers.create');
    }

    // 3. Xử lý lưu Giảng viên mới
    public function store(StoreLecturerRequest $request)
    {
        // Dùng Transaction: nếu 1 trong 2 bảng lỗi thì tự khôi phục, không sinh ra dữ liệu rác
        DB::transaction(function () use ($request) {
            // Bước A: Tạo tài khoản đăng nhập cho giảng viên
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('12345678'), // Mật khẩu mặc định
                'role' => 'lecturer',
            ]);

            // Bước B: Tạo hồ sơ thông tin Giảng viên
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
        return view('lecturers.edit', compact('lecturer'));
    }

    // 5. Xử lý Cập nhật thông tin
    public function update(StoreLecturerRequest $request, Lecturer $lecturer)
    {
        DB::transaction(function () use ($request, $lecturer) {
            // Cập nhật thông tin User
            $lecturer->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Cập nhật thông tin Giảng viên
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
        // Xóa tài khoản User, bảng `lecturers` tự động xóa theo (nhờ quan hệ Foreign Key Cascade)
        $lecturer->user->delete();
        return redirect()->route('lecturers.index')->with('success', 'Đã xóa giảng viên!');
    }

    // =====================================================
    // TÍNH NĂNG DÀNH CHO GIẢNG VIÊN (ĐÃ SỬA LỖI LOGIC ID)
    // =====================================================

    // 1. Xem danh sách đề tài do giảng viên hướng dẫn
    public function topics()
    {
        // Lấy đúng ID của Lecturer thay vì lấy nhầm ID của User
        $lecturer = Lecturer::where('user_id', Auth::id())->firstOrFail();

        $topics = Topic::where('lecturer_id', $lecturer->id)
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

        $registrations = TopicRegistration::whereHas('topic', function($q) use ($lecturer) {
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

        $registrations = TopicRegistration::whereHas('topic', function($q) use ($lecturer) {
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