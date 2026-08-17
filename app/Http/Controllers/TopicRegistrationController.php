<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TopicRegistration;
use App\Models\Topic;
use Carbon\Carbon;

class TopicRegistrationController extends Controller
{
    // 1. Hàm hiển thị danh sách đơn đăng ký
    public function index()
    {
        // Dùng Eager Loading with(['student.user', 'topic']) để lấy luôn tên Sinh viên và tên Đề tài
        $registrations = TopicRegistration::with(['student.user', 'topic'])
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return view('topic_registrations.index', compact('registrations'));
    }

    // 2. Hàm xử lý khi sinh viên bấm nút "Đăng ký"
    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'student_id' => 'required|exists:students,id' 
        ]);

        $studentId = $request->student_id;
        $topicId = $request->topic_id;

        $hasActiveRegistration = TopicRegistration::where('student_id', $studentId)
            ->whereIn('status', ['Pending', 'Approved'])
            ->exists();

        if ($hasActiveRegistration) {
            return redirect()->back()->with('error', 'Bạn đang có đề tài chờ duyệt hoặc đã được duyệt. Không thể đăng ký thêm!');
        }

        $topic = Topic::findOrFail($topicId);
        if ($topic->status !== 'Open') {
            return redirect()->back()->with('error', 'Đề tài này hiện không mở để đăng ký!');
        }

        TopicRegistration::create([
            'student_id' => $studentId,
            'topic_id' => $topicId,
            'status' => 'Pending',
            'registered_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Đăng ký đề tài thành công! Vui lòng chờ giảng viên duyệt.');
    }

    // 3. Hàm xử lý logic Duyệt hoặc Từ chối đơn đăng ký
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected'
        ]);

        $registration = TopicRegistration::findOrFail($id);
        $topic = Topic::findOrFail($registration->topic_id); // Lấy đề tài ra kiểm tra trước

        // Lỗi: Nếu Admin định duyệt, nhưng đề tài không còn 'Open' nữa (đã bị gán cho người khác)
        if ($request->status === 'Approved' && $topic->status !== 'Open') {
            return redirect()->back()->with('error', 'Lỗi: Đề tài này đã được giao cho sinh viên khác. Bạn chỉ có thể Từ chối!');
        }
        
        // Cập nhật trạng thái cho đơn đăng ký
        $registration->status = $request->status;
        $registration->save();

        if ($request->status === 'Approved') {
            $topic->status = 'Assigned';
            $topic->save();
            
            // Tùy chọn nâng cao: Tự động Reject tất cả các đơn Pending còn lại của Đề tài này
            TopicRegistration::where('topic_id', $topic->id)
                ->where('status', 'Pending')
                ->update(['status' => 'Rejected']);
        }

        $message = $request->status === 'Approved' ? 'Đã duyệt đơn đăng ký thành công!' : 'Đã từ chối đơn đăng ký!';
        
        return redirect()->back()->with('success', $message);
    }
}