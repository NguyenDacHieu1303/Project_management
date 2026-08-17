@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Chỉnh sửa Thông tin Giảng viên</h5>
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

                    <form action="{{ route('lecturers.update', $lecturer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mã Giảng viên:</label>
                            <input type="text" name="lecturer_code" class="form-control" value="{{ old('lecturer_code', $lecturer->lecturer_code) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ và tên Giảng viên:</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $lecturer->user->name ?? $lecturer->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email:</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $lecturer->user->email ?? $lecturer->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Khoa / Bộ môn:</label>
                            <input type="text" name="department" class="form-control" value="{{ old('department', $lecturer->department) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số điện thoại:</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $lecturer->phone) }}">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Hủy</a>
                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection