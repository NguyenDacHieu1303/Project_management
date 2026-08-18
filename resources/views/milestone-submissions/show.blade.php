@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Chi tiết Bài Nộp</h2>
        <a href="{{ route('milestone-submissions.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">Mốc</h6>
                    <p class="fw-bold">
                        <strong>{{ $milestoneSubmission->milestone->title }}</strong><br>
                        <small class="text-muted">{{ $milestoneSubmission->milestone->topic->title }}</small>
                    </p>
                    
                    <hr>

                    <h6 class="card-title text-muted">Sinh viên</h6>
                    <p class="fw-bold">
                        {{ $milestoneSubmission->student->user->name }}<br>
                        <small class="text-muted">{{ $milestoneSubmission->student->student_code }}</small>
                    </p>

                    <hr>

                    <h6 class="card-title text-muted">File</h6>
                    <p><code>{{ $milestoneSubmission->file_path }}</code></p>

                    <hr>

                    <h6 class="card-title text-muted">Ghi chú</h6>
                    <p>{{ $milestoneSubmission->note ?? 'Không có ghi chú' }}</p>

                    <hr>

                    <h6 class="card-title text-muted">Ngày nộp</h6>
                    <p>{{ $milestoneSubmission->submitted_at->format('d/m/Y H:i') }}</p>

                    <div class="mt-3">
                        <a href="{{ route('milestone-submissions.edit', $milestoneSubmission->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('milestone-submissions.destroy', $milestoneSubmission->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Chắc chắn xóa?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
