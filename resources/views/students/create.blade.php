@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            
            <!-- Card bọc form -->
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary text-white py-3 rounded-top-4">
                    <h4 class="mb-0 fw-bold">➕ Thêm Sinh Viên Mới</h4>
                </div>
                
                <div class="card-body p-4">

                    <!-- Hiển thị lỗi validate nếu có -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('students.store') }}" method="POST">
                        @csrf

                        <!-- Nhóm thông tin tài khoản -->
                        <div class="mb-3">
                            <h5 class="text-primary fs-6 fw-bold border-bottom pb-2 mb-3">👤 Thông tin tài khoản</h5>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Nhập họ và tên..." required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email hệ thống <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="example@tlu.edu.vn" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nhóm thông tin chi tiết sinh viên -->
                        <div class="mb-3">
                            <h5 class="text-primary fs-6 fw-bold border-bottom pb-2 mb-3">🎓 Thông tin học tập</h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="student_code" class="form-label fw-semibold">Mã sinh viên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('student_code') is-invalid @enderror" id="student_code" name="student_code" value="{{ old('student_code') }}" placeholder="VD: A40123" required>
                                @error('student_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="class" class="form-label fw-semibold">Lớp sinh hoạt</label>
                                <input type="text" class="form-control @error('class') is-invalid @enderror" id="class" name="class" value="{{ old('class') }}" placeholder="VD: 65TH1">
                                @error('class')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="major" class="form-label fw-semibold">Ngành học</label>
                                <input type="text" class="form-control @error('major') is-invalid @enderror" id="major" name="major" value="{{ old('major') }}" placeholder="VD: Công nghệ thông tin">
                                @error('major')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="course" class="form-label fw-semibold">Khóa học</label>
                                <input type="text" class="form-control @error('course') is-invalid @enderror" id="course" name="course" value="{{ old('course') }}" placeholder="VD: K65">
                                @error('course')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="form-label fw-semibold">Số điện thoại liên hệ</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="VD: 0912345678">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Các nút hành động -->
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary px-4">Hủy bỏ</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">Lưu thông tin</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection