<?php

namespace App\Http\Controllers;

use App\Models\MilestoneSubmission;
use App\Models\Milestone;
use App\Models\Student;
use App\Models\TopicRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MilestoneSubmissionController extends Controller
{
    /**
     * Display a listing of the milestone submissions.
     * Phân quyền linh hoạt: Sinh viên xem mốc nộp bài của mình, Admin/GV xem toàn bộ danh sách.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Nếu là Sinh viên: Hiển thị giao diện nộp bài theo mốc của đề tài đã duyệt
        if ($user->role === 'student') {
            $student = $user->student;
            if (!$student) {
                return view('student.milestones', ['registration' => null]);
            }

            // Lấy đề tài đã được DUYỆT của sinh viên này kèm theo các mốc và bài nộp của chính họ
            $registration = TopicRegistration::where('student_id', $student->id)
                ->where('status', 'Approved')
                ->with(['topic.milestones.submissions' => function($q) use ($student) {
                    $q->where('student_id', $student->id);
                }])
                ->first();

            return view('students.milestones', compact('registration'));
        }

        // 2. Nếu là Admin hoặc Giảng viên: Hiển thị bảng quản lý toàn bộ bài nộp
        $submissions = MilestoneSubmission::with('milestone', 'student.user')
            ->latest()
            ->paginate(10);
            
        return view('milestone-submissions.index', compact('submissions'));
    }

    /**
     * Show the form for creating a new submission (Dành cho Admin).
     */
    public function create()
    {
        $milestones = Milestone::all();
        $students = Student::all();
        return view('milestone-submissions.create', compact('milestones', 'students'));
    }

    /**
     * Store a newly created submission in storage.
     * Hỗ trợ cả 2 luồng: Admin tạo thủ công hoặc Sinh viên tải file lên qua trang mốc.
     */
    public function store(Request $request, $milestoneId = null)
    {
        $user = Auth::user();

        // Xử lý nếu là sinh viên nộp bài qua form mốc tiến độ
        if ($user->role === 'student') {
            $request->validate([
                'file' => 'required|file|mimes:pdf,doc,docx,zip,rar|max:10240', // Tối đa 10MB
                'note' => 'nullable|string|max:1000',
            ], [
                'file.required' => 'Vui lòng chọn file báo cáo để nộp.',
                'file.mimes' => 'File nộp phải có định dạng: pdf, doc, docx, zip, rar.',
                'file.max' => 'Dung lượng file không được vượt quá 10MB.',
            ]);

            $student = $user->student;
            $milestone = Milestone::findOrFail($milestoneId);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                // Lưu vào storage/app/public/submissions
                $filePath = $file->store('submissions', 'public');

                // Dùng updateOrCreate để sinh viên có thể nộp lại (ghi đè file cũ nếu nộp nhiều lần)
                MilestoneSubmission::updateOrCreate(
                    [
                        'milestone_id' => $milestone->id,
                        'student_id' => $student->id,
                    ],
                    [
                        'file_path' => $filePath,
                        'note' => $request->note,
                        'submitted_at' => Carbon::now(),
                    ]
                );
            }

            return redirect()->route('student.milestones')->with('success', 'Nộp bài báo cáo thành công!');
        }

        // Luồng dành cho Admin quản lý CRUD thông thường
        $request->validate([
            'milestone_id' => 'required|exists:milestones,id',
            'student_id' => 'required|exists:students,id',
            'file_path' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
            'submitted_at' => 'required|date_format:Y-m-d H:i',
        ], [
            'milestone_id.required' => 'Vui lòng chọn mốc',
            'student_id.required' => 'Vui lòng chọn sinh viên',
            'file_path.required' => 'Vui lòng nhập đường dẫn file',
            'submitted_at.required' => 'Vui lòng chọn ngày nộp',
        ]);

        MilestoneSubmission::create($request->all());
        return redirect()->route('milestone-submissions.index')->with('success', 'Tạo bài nộp thành công!');
    }

    /**
     * Display the specified submission.
     */
    public function show(MilestoneSubmission $milestoneSubmission)
    {
        $milestoneSubmission->load('milestone', 'student.user');
        return view('milestone-submissions.show', compact('milestoneSubmission'));
    }

    /**
     * Show the form for editing the specified submission.
     */
    public function edit(MilestoneSubmission $milestoneSubmission)
    {
        $milestones = Milestone::all();
        $students = Student::all();
        return view('milestone-submissions.edit', compact('milestoneSubmission', 'milestones', 'students'));
    }

    /**
     * Update the specified submission in storage.
     */
    public function update(Request $request, MilestoneSubmission $milestoneSubmission)
    {
        $request->validate([
            'milestone_id' => 'required|exists:milestones,id',
            'student_id' => 'required|exists:students,id',
            'file_path' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
            'submitted_at' => 'required|date_format:Y-m-d H:i',
        ]);

        $milestoneSubmission->update($request->all());
        return redirect()->route('milestone-submissions.index')->with('success', 'Cập nhật bài nộp thành công!');
    }

    /**
     * Remove the specified submission from storage.
     */
    public function destroy(MilestoneSubmission $milestoneSubmission)
    {
        // Xóa file vật lý trong storage nếu có
        if ($milestoneSubmission->file_path && Storage::disk('public')->exists($milestoneSubmission->file_path)) {
            Storage::disk('public')->delete($milestoneSubmission->file_path);
        }

        $milestoneSubmission->delete();
        return redirect()->route('milestone-submissions.index')->with('success', 'Xóa bài nộp thành công!');
    }
}