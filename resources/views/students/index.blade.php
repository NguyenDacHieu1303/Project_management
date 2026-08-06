@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">Danh sách Sinh viên</h2>
        <a href="{{ route('students.create') }}" class="btn btn-primary">
            + Thêm sinh viên mới
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Tuyệt vời!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">STT</th>
                            <th>Mã SV</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Lớp</th>
                            <th>Ngành</th>
                            <th>Khóa</th>
                            <th>SĐT</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $student->student_code }}</td>
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->user->email }}</td>
                            <td>{{ $student->class }}</td>
                            <td>{{ $student->major }}</td>
                            <td>{{ $student->course }}</td>
                            <td>{{ $student->phone }}</td>
                            <td class="text-center">
                                <!-- Nút Sửa -->
                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning">
                                    Sửa
                                </a>

                                <!-- Nút Xóa -->
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection