@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <!-- Hiển thị thông báo chung -->
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

    {{-- GIAO DIỆN DÀNH CHO SINH VIÊN (Đồ án của tôi) --}}
    @if(Auth::user()->role === 'student')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">📚 Đồ án của tôi</h2>
            <p class="text-muted mb-0">Theo dõi trạng thái đơn đăng ký đề tài của bạn</p>
        </div>
        <a href="{{ route('topics.index') }}" class="btn btn-outline-primary fw-semibold">
            🔍 Đăng ký đề tài mới
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th>Tên Đề Tài</th>
                        <th>Chuyên Ngành</th>
                        <th>Ngày Gửi Đơn</th>
                        <th class="text-center">Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $key => $reg)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="fw-semibold">{{ $reg->topic->title ?? 'N/A' }}</td>
                        <td>{{ $reg->topic->major ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($reg->registered_at)->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            @if($reg->status == 'Pending')
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">⏳ Đang chờ duyệt</span>
                            @elseif($reg->status == 'Approved')
                            <span class="badge bg-success px-3 py-2 rounded-pill">✅ Đã duyệt</span>
                            @php
                            $lecturerUser = $reg->topic->assignment?->lecturer?->user;
                            @endphp

                            <div class="mt-2 p-3 bg-light rounded border-start border-4 border-success small">
                                <p class="mb-1 fw-bold text-dark">👨‍🏫 Giảng viên hướng dẫn:</p>
                                @if($lecturerUser)
                                <p class="mb-1"><strong>Họ tên:</strong> {{ $lecturerUser->name }}</p>
                                <p class="mb-0"><strong>Email:</strong> {{ $lecturerUser->email }}</p>
                                @else
                                <p class="mb-0 text-muted fst-italic">Bộ môn đang cập nhật phân công GVHD.</p>
                                @endif
                            </div>
                            @else
                            <span class="badge bg-danger px-3 py-2 rounded-pill">❌ Bị từ chối</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <h5 class="text-muted mb-3">Bạn chưa đăng ký đồ án nào!</h5>
                            <a href="{{ route('topics.index') }}" class="btn btn-primary">Đi tới Danh sách Đề tài</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- GIAO DIỆN DÀNH CHO ADMIN / GIẢNG VIÊN --}}
    @else
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý Đơn đăng ký Đề tài</h2>
    </div>

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
                        <td colspan="7" class="text-center text-muted py-4">Chưa có đơn đăng ký nào trên hệ thống.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3">
                {{ $registrations->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @endif

</div>
@endsection