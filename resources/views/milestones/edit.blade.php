@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Chỉnh sửa Mốc Nộp</h5>
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

                    <form action="{{ route('milestones.update', $milestone->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Đề tài <span class="text-danger">*</span></label>
                            <select name="topic_id" class="form-control @error('topic_id') is-invalid @enderror" required>
                                <option value="">-- Chọn đề tài --</option>
                                @foreach($topics as $topic)
                                    <option value="{{ $topic->id }}" {{ old('topic_id', $milestone->topic_id) == $topic->id ? 'selected' : '' }}>
                                        {{ $topic->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('topic_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên Mốc <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $milestone->title) }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Hạn chót <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="deadline" class="form-control @error('deadline') is-invalid @enderror" 
                                       value="{{ old('deadline', $milestone->deadline->format('Y-m-d\TH:i')) }}" required>
                                @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thứ tự <span class="text-danger">*</span></label>
                                <input type="number" name="order_number" class="form-control @error('order_number') is-invalid @enderror" 
                                       value="{{ old('order_number', $milestone->order_number) }}" min="1" max="10" required>
                                @error('order_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('milestones.index') }}" class="btn btn-secondary">Hủy</a>
                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
