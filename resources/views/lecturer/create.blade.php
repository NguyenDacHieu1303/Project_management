@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thêm Giảng viên Mới</h5>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('lecturers.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mã Giảng viên:</label>
                            <input type="text" name="lecturer_code" class="form-control" placeholder="Ví dụ: GV001" value="{{ old('lecturer_code') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ và tên Giảng viên:</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập họ và tên" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email:</label>
                            <input type="email" name="email" class="form-control" placeholder="email@domain.com" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Chuyên ngành:</label>
                            <input type="text" name="specialization" class="form-control" placeholder="Ví dụ: Công nghệ phần mềm" value="{{ old('specialization') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số lượng sinh viên tối đa hướng dẫn:</label>
                            <input type="number" name="quota" class="form-control" placeholder="Ví dụ: 5" value="{{ old('quota', 5) }}" min="1" max="20" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số điện thoại:</label>
                            <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Hủy</a>
                            <button type="submit" class="btn btn-primary">Lưu Giảng viên</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection