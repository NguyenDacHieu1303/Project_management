@extends('layouts.app') <!-- Em nhớ đổi tên layout theo file gốc của em nếu cần nhé -->

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý Đơn đăng ký Đề tài</h2>
    </div>

    <!-- Hiển thị thông báo thành công hoặc lỗi -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>STT</th>
                        <th>Mã Sinh Viên</th>
                        <th>Họ Tên</th>
                        <th>Tên Đề Tài</th>
                        <th>Ngày Đăng Ký</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $key => $reg)
                    <tr>
                        <td class="text-center">{{ $registrations->firstItem() + $key}}</td>
                        <td class="text-center fw-bold">{{ $reg->student->student_code ?? 'N/A' }}</td>
                        <td>{{ $reg->student->user->name ?? 'N/A' }}</td>
                        <td>{{ $reg->topic->title ?? 'N/A' }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($reg->registered_at)->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            @if($reg->status == 'Pending')
                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                            @elseif($reg->status == 'Approved')
                            <span class="badge bg-success">Đã duyệt</span>
                            @else
                            <span class="badge bg-danger">Từ chối</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <!-- Chỉ hiện nút duyệt/từ chối nếu đơn đang ở trạng thái Pending -->
                            @if($reg->status == 'Pending')
                            <form action="{{ route('topic-registrations.update_status', $reg->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Approved">
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Bạn có chắc chắn muốn DUYỆT đơn này?')">Duyệt</button>
                            </form>

                            <form action="{{ route('topic-registrations.update_status', $reg->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Rejected">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn TỪ CHỐI đơn này?')">Từ chối</button>
                            </form>
                            @else
                            <span class="text-muted fst-italic">Đã xử lý</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Chưa có đơn đăng ký nào trên hệ thống.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3">
                {{ $registrations->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection