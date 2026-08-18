<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TopicAssignment;
use App\Models\Topic;
use App\Models\Lecturer;

class TopicAssignmentController extends Controller
{
    // 1. Hiển thị danh sách phân công
    public function index()
    {
        // Lấy danh sách các bản phân công, kèm thông tin Đề tài và Giảng viên
        $assignments = TopicAssignment::with(['topic', 'lecturer.user'])
            ->latest()
            ->paginate(10);

        return view('assignments.index', compact('assignments'));
    }

    // 2. Hiển thị form Tạo phân công mới
    public function create()
    {
        // Lấy danh sách giảng viên và đề tài để hiển thị ở Dropdown (thẻ select)
        $topics = Topic::all();
        $lecturers = Lecturer::with('user')->get();

        return view('assignments.create', compact('topics', 'lecturers'));
    }

    // 3. Xử lý lưu phân công vào Database
    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'lecturer_id' => 'required|exists:lecturers,id',
            'role' => 'required|string',
        ]);

        // Dùng updateOrCreate: 
        // - Nếu đề tài này CHƯA có ai nhận -> Tạo mới phân công.
        // - Nếu đề tài này ĐÃ ĐƯỢC PHÂN CÔNG rồi -> Tự động CẬP NHẬT sang giảng viên mới (tránh triệt để lỗi Duplicate).
        TopicAssignment::updateOrCreate(
            ['topic_id' => $request->topic_id], // Điều kiện khóa unique
            [
                'lecturer_id' => $request->lecturer_id,
                'role' => $request->role,
                'assigned_at' => now(),
            ]
        );

        // Cập nhật trạng thái của đề tài thành 'Assigned'
        $topic = Topic::findOrFail($request->topic_id);
        $topic->status = 'Assigned';
        $topic->save();

        return redirect()->route('assignments.index')->with('success', 'Đã phân công giảng viên thành công!');
    }

    // 4. Hủy (Xóa) phân công
    public function destroy($id)
    {
        // Tìm bản phân công theo ID và xóa
        $assignment = TopicAssignment::findOrFail($id);
        $assignment->delete();

        return redirect()->route('assignments.index')->with('success', 'Đã hủy phân công thành công!');
    }
}
