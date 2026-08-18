@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h2 class="fw-bold text-primary">📋 Duyệt Đơn Đăng Ký</h2>
        <p class="text-muted">Xem xét và phê duyệt đơn đăng ký đề tài của sinh viên.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">Sinh viên</th>
                        <th class="py-3">Đề tài đăng ký</th>
                        <th class="py-3">Ngày đăng ký</th>
                        <th class="text-center py-3">Trạng thái</th>
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
                        <td class="align-middle">{{ $reg->created_at ? $reg->created_at->format('d/m/Y H:i') : '' }}</td>
                        <td class="text-center align-middle">
                            @if($reg->status == 'Pending')
                                <span class="badge bg-warning text-dark">Chờ duyệt</span>
                            @elseif($reg->status == 'Approved')
                                <span class="badge bg-success">Đã duyệt</span>
                            @else
                                <span class="badge bg-danger">Từ chối</span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if($reg->status == 'Pending')
                                <form action="{{ route('topic-registrations.update_status', $reg->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Approved">
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Xác nhận duyệt sinh viên này?');">Duyệt</button>
                                </form>
                                <form action="{{ route('topic-registrations.update_status', $reg->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Rejected">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Từ chối đơn đăng ký này?');">Từ chối</button>
                                </form>
                            @else
                                <span class="text-muted small">Đã xử lý</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Chưa có đơn đăng ký nào chờ duyệt.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($registrations->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end">
            {{ $registrations->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection