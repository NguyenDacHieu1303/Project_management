@extends('layouts.app')

@section('content')


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Danh sách sinh viên</title>
</head>

<body>

    <h2>Danh sách sinh viên</h2>

    <a href="{{ route('students.create') }}">
        <button>Thêm sinh viên</button>
    </a>

    <!-- Thông báo khi Thêm/Sửa/Xóa thành công -->
    @if(session('success'))
        <p style="color: green;"><b>{{ session('success') }}</b></p>
    @endif

    <br><br>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã SV</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Lớp</th>
                <th>Ngành</th>
                <th>Khóa</th>
                <th>SĐT</th>
                <th>Hành động</th>
            </tr>
        </thead>

        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->student_code }}</td>
                <td>{{ $student->user->name }}</td>
                <td>{{ $student->user->email }}</td>
                <td>{{ $student->class }}</td>
                <td>{{ $student->major }}</td>
                <td>{{ $student->course }}</td>
                <td>{{ $student->phone }}</td>
                <td>
                    <!-- Nút Sửa -->
                    <a href="{{ route('students.edit', $student->id) }}">
                        <button>Sửa</button>
                    </a>

                    <!-- Nút Xóa dùng Form vì Route DELETE yêu cầu POST + @method('DELETE')) -->
                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: red;">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

</body>

</html>
@endsection