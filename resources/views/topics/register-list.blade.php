@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h2 class="fw-bold text-primary">📝 Danh sách Đề tài Mở Đăng Ký</h2>
        <p class="text-muted">Dưới đây là các đề tài hiện đang mở. Hãy chọn và đăng ký ngay!</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tên Đề tài</th>
                        <th>Chuyên ngành</th>
                        <th>Học kỳ</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topics as $topic)
                    <tr>
                        <td class="align-middle fw-semibold">{{ $topic->title }}</td>
                        <td class="align-middle">{{ $topic->major }}</td>
                        <td class="align-middle">{{ $topic->semester }}</td>
                        <td class="text-center align-middle">
                            <!-- Nút Xem chi tiết -->
                            <a href="{{ route('topics.show', $topic->id) }}" class="btn btn-sm btn-info text-white">Xem</a>
                            
                            <!-- Nút Đăng ký ngay -->
                            <form action="{{ route('topic-registrations.store') }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn xác nhận đăng ký đề tài này?');">
                                @csrf
                                <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                                <button type="submit" class="btn btn-sm btn-success">Đăng ký</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Không có đề tài nào đang mở.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection