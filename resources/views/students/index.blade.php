<h1>Danh sách sinh viên</h1>

@foreach ($students as $student)
    <p>{{ $student->student_code }}</p>
@endforeach