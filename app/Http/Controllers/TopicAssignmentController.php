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
        // 1. Validate dữ liệu đầu vào (Thêm 'role')
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'lecturer_id' => 'required|exists:lecturers,id',
            'role' => 'required|string', // Bắt buộc phải có vai trò
        ]);

        // 2. Kiểm tra trùng lặp: Giảng viên này đã được phân công cho đề tài này chưa?
        // (Sửa lại logic: 1 giảng viên không được nhận 2 vai trò trong cùng 1 đề tài)
        $exists = TopicAssignment::where('topic_id', $request->topic_id)
                                 ->where('lecturer_id', $request->lecturer_id)
                                 ->first();
                                 
        if ($exists) {
            return redirect()->back()->withErrors(['topic_id' => 'Giảng viên này đã được phân công cho đề tài này rồi!']);
        }

        // 3. Tạo bản ghi mới trong database (Lưu thêm 'role')
        TopicAssignment::create([
            'topic_id' => $request->topic_id,
            'lecturer_id' => $request->lecturer_id,
            'role' => $request->role, // Lưu vai trò vào CSDL
            'assigned_at' => now(), 
        ]);

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