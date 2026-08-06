@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Chỉnh sửa Đề tài</h2>
    
    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('topics.update', $topic->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Tên đề tài <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $topic->title) }}">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả chi tiết <span class="text-danger">*</span></label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $topic->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Chuyên ngành <span class="text-danger">*</span></label>
                        <input type="text" name="major" class="form-control @error('major') is-invalid @enderror" value="{{ old('major', $topic->major) }}">
                        @error('major') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Học kỳ <span class="text-danger">*</span></label>
                        <input type="text" name="semester" class="form-control @error('semester') is-invalid @enderror" value="{{ old('semester', $topic->semester) }}">
                        @error('semester') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="Open" {{ old('status', $topic->status) == 'Open' ? 'selected' : '' }}>Mở đăng ký (Open)</option>
                            <option value="Assigned" {{ old('status', $topic->status) == 'Assigned' ? 'selected' : '' }}>Đã phân công (Assigned)</option>
                            <option value="Closed" {{ old('status', $topic->status) == 'Closed' ? 'selected' : '' }}>Đã đóng (Closed)</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Cập nhật Đề tài</button>
                <a href="{{ route('topics.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection