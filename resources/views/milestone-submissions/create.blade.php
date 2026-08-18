@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thêm Bài Nộp Mới</h5>
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

                    <form action="{{ route('milestone-submissions.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mốc <span class="text-danger">*</span></label>
                            <select name="milestone_id" class="form-control @error('milestone_id') is-invalid @enderror" required>
                                <option value="">-- Chọn mốc --</option>
                                @foreach($milestones as $milestone)
                                    <option value="{{ $milestone->id }}" {{ old('milestone_id') == $milestone->id ? 'selected' : '' }}>
                                        {{ $milestone->topic->title }} - {{ $milestone->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('milestone_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Sinh viên <span class="text-danger">*</span></label>
                            <select name="student_id" class="form-control @error('student_id') is-invalid @enderror" required>
                                <option value="">-- Chọn sinh viên --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->user->name }} ({{ $student->student_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Đường dẫn File <span class="text-danger">*</span></label>
                            <input type="text" name="file_path" class="form-control @error('file_path') is-invalid @enderror" 
                                   placeholder="Ví dụ: submissions/file.pdf" value="{{ old('file_path') }}" required>
                            @error('file_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Ghi chú</label>
                            <textarea name="note" class="form-control @error('note') is-invalid @enderror" rows="3" placeholder="Ghi chú từ sinh viên">{{ old('note') }}</textarea>
                            @error('note') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Ngày nộp <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="submitted_at" class="form-control @error('submitted_at') is-invalid @enderror" 
                                   value="{{ old('submitted_at', now()->format('Y-m-d\TH:i')) }}" required>
                            @error('submitted_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('milestone-submissions.index') }}" class="btn btn-secondary">Hủy</a>
                            <button type="submit" class="btn btn-primary">Lưu Bài Nộp</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
