@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Chi tiết Mốc: {{ $milestone->title }}</h2>
        <a href="{{ route('milestones.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title text-muted">Đề tài</h6>
                    <p class="fw-bold">{{ $milestone->topic->title }}</p>
                    
                    <h6 class="card-title text-muted mt-3">Hạn chót</h6>
                    <p>{{ $milestone->deadline->format('d/m/Y H:i') }}</p>
                    
                    <h6 class="card-title text-muted">Thứ tự</h6>
                    <p><span class="badge bg-info">{{ $milestone->order_number }}</span></p>
                    
                    <div class="mt-3">
                        <a href="{{ route('milestones.edit', $milestone->id) }}" class="btn btn-sm btn-warning w-100">Sửa</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Bài Nộp ({{ $milestone->submissions->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($milestone->submissions->isEmpty())
                        <p class="text-muted">Chưa có bài nộp nào.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sinh viên</th>
                                        <th>Ngày nộp</th>
                                        <th>File</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($milestone->submissions as $sub)
                                    <tr>
                                        <td>{{ $sub->student->user->name }}</td>
                                        <td>{{ $sub->submitted_at->format('d/m/Y H:i') }}</td>
                                        <td><small>{{ $sub->file_path }}</small></td>
                                        <td>{{ $sub->note ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
