<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sửa sinh viên</title>
</head>
<body>

    <h2>Sửa thông tin sinh viên</h2>

    <!-- Gửi đến route update kèm theo ID của sinh viên -->
    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- dùng method PUT để cập nhật -->

        <h3>Thông tin tài khoản</h3>

        <label>Họ tên</label><br>
        <input type="text" name="name" value="{{ $student->user->name }}"><br><br>

        <label>Email</label><br>
        <input type="email" name="email" value="{{ $student->user->email }}"><br><br>

        <h3>Thông tin sinh viên</h3>

        <label>Mã sinh viên</label><br>
        <input type="text" name="student_code" value="{{ $student->student_code }}"><br><br>

        <label>Lớp</label><br>
        <input type="text" name="class" value="{{ $student->class }}"><br><br>

        <label>Ngành</label><br>
        <input type="text" name="major" value="{{ $student->major }}"><br><br>

        <label>Khóa</label><br>
        <input type="text" name="course" value="{{ $student->course }}"><br><br>

        <label>Số điện thoại</label><br>
        <input type="text" name="phone" value="{{ $student->phone }}"><br><br>

        <button type="submit">Cập nhật</button>
        <a href="{{ route('students.index') }}">Hủy</a>
    </form>

</body>
</html>