@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Danh sách Đề tài (Tra cứu)</h2>
        
        <!-- Chỉ Admin mới có nút Thêm đề tài -->
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('topics.create') }}" class="btn btn-primary">Thêm Đề tài mới</a>
        @endif
    </div>

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
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">STT</th>
                        <th>Tên Đề tài</th>
                        <th>Chuyên ngành</th>
                        <th>Học kỳ</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topics as $index => $topic)
                    <tr>
                        <td class="text-center align-middle">{{ $topics->firstItem() + $index }}</td>
                        <td class="align-middle fw-semibold">{{ $topic->title }}</td>
                        <td class="align-middle">{{ $topic->major }}</td>
                        <td class="align-middle">{{ $topic->semester }}</td>
                        <td class="text-center align-middle">
                            @if($topic->status == 'Open')
                                <span class="badge bg-success px-2 py-1">Mở đăng ký</span>
                            @elseif($topic->status == 'Assigned')
                                <span class="badge bg-warning text-dark px-2 py-1">Đã phân công</span>
                            @else
                                <span class="badge bg-danger px-2 py-1">Đã đóng</span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            
                            <!-- 1. Nút Xem chi tiết: Ai cũng bấm vào được để đọc thông tin -->
                            <a href="{{ route('topics.show', $topic->id) }}" class="btn btn-sm btn-info text-white">Xem chi tiết</a>
                            <!-- 2. Nút của ADMIN: Sửa / Xóa -->
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-sm btn-warning">Sửa</a>

                                <form action="{{ route('topics.destroy', $topic->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đề tài này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            @endif

                            <!-- LƯU Ý: Đã lược bỏ nút Đăng ký ở đây. Sinh viên phải bấm "Xem chi tiết" để sang trang riêng mới thấy nút đăng ký! -->

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Chưa có đề tài nào trên hệ thống.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white d-flex justify-content-end">
            {{ $topics->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection