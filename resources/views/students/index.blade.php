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
            </tr>
            @endforeach
        </tbody>

    </table>

</body>

</html>