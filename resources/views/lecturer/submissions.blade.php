@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h2 class="fw-bold text-primary">📥 Quản lý Bài Nộp & Chấm Điểm</h2>
        <p class="text-muted">Đánh giá tiến độ và chấm điểm sản phẩm của sinh viên.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">Sinh viên</th>
                        <th class="py-3">Đề tài</th>
                        <th class="text-center py-3">Điểm số</th>
                        <th class="text-center py-3">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                    <tr>
                        <td class="align-middle px-4 fw-semibold">
                            {{ $reg->student->user->name ?? 'N/A' }}
                            <br><small class="text-muted">{{ $reg->student->student_code ?? '' }}</small>
                        </td>
                        <td class="align-middle">{{ $reg->topic->title ?? 'N/A' }}</td>
                        <td class="text-center align-middle">
                            @if($reg->score !== null)
                                <span class="badge bg-info text-dark fs-6">{{ $reg->score }}</span>
                            @else
                                <span class="badge bg-secondary">Chưa chấm</span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#scoreModal{{ $reg->id }}">
                                Đánh giá / Chấm điểm
                            </button>

                            <!-- Modal Nhập Điểm -->
                            <div class="modal fade" id="scoreModal{{ $reg->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('lecturer.submissions.evaluate', $reg->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-content text-start">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold">Chấm điểm: {{ $reg->student->user->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Điểm số (0 - 10):</label>
                                                    <input type="number" step="0.1" min="0" max="10" name="score" value="{{ $reg->score }}" class="form-control" placeholder="Ví dụ: 8.5" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Nhận xét / Góp ý:</label>
                                                    <textarea name="feedback" rows="4" class="form-control" placeholder="Nhập nhận xét chi tiết...">{{ $reg->feedback }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                                                <button type="submit" class="btn btn-success">Lưu đánh giá</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">Chưa có sinh viên nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection