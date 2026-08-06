@extends('layouts.app')

@section('content')

<h2>Thêm sinh viên</h2>

<form action="{{ route('students.store') }}" method="POST">
    @csrf

    <h3>Thông tin tài khoản</h3>

    <label>Họ tên</label><br>
    <input type="text" name="name"><br><br>

    <label>Email</label><br>
    <input type="email" name="email"><br><br>

    <h3>Thông tin sinh viên</h3>

    <label>Mã sinh viên</label><br>
    <input type="text" name="student_code"><br><br>

    <label>Lớp</label><br>
    <input type="text" name="class"><br><br>

    <label>Ngành</label><br>
    <input type="text" name="major"><br><br>

    <label>Khóa</label><br>
    <input type="text" name="course"><br><br>

    <label>Số điện thoại</label><br>
    <input type="text" name="phone"><br><br>

    <button type="submit">Lưu</button>
    <a href="{{ route('students.index') }}">Hủy</a>
</form>
@endsection