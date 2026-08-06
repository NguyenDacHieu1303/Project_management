<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Validation\Rule;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lấy tất cả đề tài từ Database, sắp xếp mới nhất lên đầu
        $topics = Topic::orderBy('created_at', 'desc')->get();
        
        // Trả về view và ném biến $topics sang cho view xử lý hiển thị
        return view('topics.index', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('topics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Kiểm tra dữ liệu đầu vào
        $request->validate([
            'title' => [
                'required', 'string', 'max:255',
                // Nghiệp vụ: Đề tài không được trùng tên trong cùng 1 học kỳ (semester)
                Rule::unique('topics')->where(function ($query) use ($request) {
                    return $query->where('semester', $request->semester);
                })
            ],
            'description' => 'required|string',
            'major' => 'required|string|max:255',
            'semester' => 'required|string|max:50',
            'status' => 'required|in:Open,Assigned,Closed',
        ], [
            // Tùy chỉnh câu thông báo lỗi cho thân thiện
            'title.unique' => 'Đề tài này đã tồn tại trong học kỳ bạn chọn!'
        ]);

        // 2. Dữ liệu chuẩn rồi thì tạo mới trong Database
        Topic::create($request->all());

        // 3. Điều hướng về trang danh sách kèm thông báo thành công
        return redirect()->route('topics.index')->with('success', 'Thêm đề tài mới thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Tìm đề tài theo ID
        $topic = Topic::findOrFail($id);
        
        // Trả về view form sửa
        return view('topics.edit', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);

        $request->validate([
            'title' => [
                'required', 'string', 'max:255',
                Rule::unique('topics')->where(function ($query) use ($request) {
                    return $query->where('semester', $request->semester);
                })->ignore($topic->id) 
            ],
            'description' => 'required|string',
            'major' => 'required|string|max:255',
            'semester' => 'required|string|max:50',
            'status' => 'required|in:Open,Assigned,Closed',
        ], [
            'title.unique' => 'Đề tài này đã tồn tại trong học kỳ bạn chọn!'
        ]);

        // Tiến hành cập nhật
        $topic->update($request->all());

        return redirect()->route('topics.index')->with('success', 'Cập nhật thông tin đề tài thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', 'Xóa đề tài thành công!');
    }
}
