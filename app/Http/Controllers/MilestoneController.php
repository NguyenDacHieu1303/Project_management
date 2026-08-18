<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Topic;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    /**
     * Display a listing of the milestones.
     */
    public function index()
    {
        $milestones = Milestone::with('topic')->latest()->paginate(10);
        return view('milestones.index', compact('milestones'));
    }

    /**
     * Show the form for creating a new milestone.
     */
    public function create()
    {
        $topics = Topic::all();
        return view('milestones.create', compact('topics'));
    }

    /**
     * Store a newly created milestone in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'deadline' => 'required|date_format:Y-m-d H:i',
            'order_number' => 'required|integer|min:1|max:10',
        ], [
            'topic_id.required' => 'Vui lòng chọn đề tài',
            'topic_id.exists' => 'Đề tài không tồn tại',
            'title.required' => 'Vui lòng nhập tên mốc',
            'deadline.required' => 'Vui lòng chọn hạn chót',
            'order_number.required' => 'Vui lòng nhập số thứ tự',
        ]);

        Milestone::create($request->all());
        return redirect()->route('milestones.index')->with('success', 'Tạo mốc thành công!');
    }

    /**
     * Display the specified milestone.
     */
    public function show(Milestone $milestone)
    {
        $milestone->load('topic', 'submissions.student.user');
        return view('milestones.show', compact('milestone'));
    }

    /**
     * Show the form for editing the specified milestone.
     */
    public function edit(Milestone $milestone)
    {
        $topics = Topic::all();
        return view('milestones.edit', compact('milestone', 'topics'));
    }

    /**
     * Update the specified milestone in storage.
     */
    public function update(Request $request, Milestone $milestone)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'deadline' => 'required|date_format:Y-m-d H:i',
            'order_number' => 'required|integer|min:1|max:10',
        ]);

        $milestone->update($request->all());
        return redirect()->route('milestones.index')->with('success', 'Cập nhật mốc thành công!');
    }

    /**
     * Remove the specified milestone from storage.
     */
    public function destroy(Milestone $milestone)
    {
        $milestone->delete();
        return redirect()->route('milestones.index')->with('success', 'Xóa mốc thành công!');
    }
}
