<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('user')->get();
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'student_code' => 'required|unique:students,student_code',
            'class' => 'required',
            'major' => 'required',
            'course' => 'required',
            'phone' => 'nullable'
        ]);

        DB::transaction(function () use ($request) {
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('123456'),
                'role' => 'student',
            ]);

            Student::create([
                'user_id' => $user->id,
                'student_code' => $request->student_code,
                'class' => $request->class,
                'major' => $request->major,
                'course' => $request->course,
                'phone' => $request->phone,
            ]);

        });
        return redirect()->route('students.index')->with('success', 'Sinh viên đã được thêm thành công.');
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
        // Tìm sinh viên theo ID, lấy kèm thông tin bảng user
        $student = Student::with('user')->findOrFail($id);
        
        // Trả về view kèm data
        return view('students.edit', compact('student'));
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
        // Tìm Student và User hiện tại
        $student = Student::findOrFail($id);
        $user = $student->user; // Nhờ relationship belongsTo

        // Validate dữ liệu
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'student_code' => 'required|unique:students,student_code,' . $student->id,
            'class' => 'required',
            'major' => 'required',
            'course' => 'required',
            'phone' => 'nullable'
        ]);

        // 3. Dùng Transaction để update an toàn
        DB::transaction(function () use ($request, $user, $student) {
            
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $student->update([
                'student_code' => $request->student_code,
                'class' => $request->class,
                'major' => $request->major,
                'course' => $request->course,
                'phone' => $request->phone,
            ]);

        });
        return redirect()->route('students.index')->with('success', 'Cập nhật thông tin sinh viên thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 1. Tìm sinh viên
        $student = Student::findOrFail($id);
        
        // 2. Lấy thông tin user
        $user = $student->user;

        // 3. Thực hiện xóa 
        DB::transaction(function () use ($student, $user) {
            $student->delete();
            $user->delete();
            
        });
        return redirect()->route('students.index')->with('success', 'Đã xóa sinh viên thành công.');
    }
}
