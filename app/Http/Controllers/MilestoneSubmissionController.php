<?php

namespace App\Http\Controllers;

use App\Models\MilestoneSubmission;
use App\Models\Milestone;
use App\Models\Student;
use Illuminate\Http\Request;

class MilestoneSubmissionController extends Controller
{
    /**
     * Display a listing of the milestone submissions.
     */
    public function index()
    {
        $submissions = MilestoneSubmission::with('milestone', 'student.user')
            ->latest()
            ->paginate(10);
        return view('milestone-submissions.index', compact('submissions'));
    }

    /**
     * Show the form for creating a new submission.
     */
    public function create()
    {
        $milestones = Milestone::all();
        $students = Student::all();
        return view('milestone-submissions.create', compact('milestones', 'students'));
    }

    /**
     * Store a newly created submission in storage.
     */
    public function store(Request $request)
    {
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
        $milestoneSubmission->delete();
        return redirect()->route('milestone-submissions.index')->with('success', 'Xóa bài nộp thành công!');
    }
}
