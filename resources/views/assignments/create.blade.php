@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Phân công Giảng viên Hướng dẫn Đề tài</h5>
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

                    <form action="{{ route('assignments.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Chọn Đề tài:</label>
                            <select name="topic_id" class="form-select" required>
                                <option value="">-- Chọn đề tài --</option>
                                @foreach($topics as $topic)
                                    <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                                        {{ $topic->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Chọn Giảng viên Hướng dẫn:</label>
                            <select name="lecturer_id" class="form-select" required>
                                <option value="">-- Chọn giảng viên --</option>
                                @foreach($lecturers as $lecturer)
                                    <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id ? 'selected' : '' }}>
                                        {{ $lecturer->user->name ?? $lecturer->name }} (Mã GV: {{ $lecturer->lecturer_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Vai trò phân công:</label>
                            <select name="role" class="form-select">
                                <option value="GVHD Chính" {{ old('role') == 'GVHD Chính' ? 'selected' : '' }}>Giảng viên Hướng dẫn chính</option>
                                <option value="GVHD Phụ" {{ old('role') == 'GVHD Phụ' ? 'selected' : '' }}>Giảng viên Hướng dẫn phụ</option>
                                <option value="GVPB" {{ old('role') == 'GVPB' ? 'selected' : '' }}>Giảng viên Phản biện</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Hủy</a>
                            <button type="submit" class="btn btn-primary">Xác nhận Phân công</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection