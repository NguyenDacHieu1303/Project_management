@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Quản lý Mốc Nộp</h2>
        <a href="{{ route('milestones.create') }}" class="btn btn-primary">Thêm Mốc Mới</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width: 60px;">STT</th>
                        <th>Đề tài</th>
                        <th>Tên Mốc</th>
                        <th>Hạn chót</th>
                        <th class="text-center">Thứ tự</th>
                        <th class="text-center" style="width: 180px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($milestones as $index => $milestone)
                    <tr>
                        <td class="text-center">{{ $milestones->firstItem() + $index }}</td>
                        <td>{{ $milestone->topic->title ?? 'N/A' }}</td>
                        <td class="fw-bold">{{ $milestone->title }}</td>
                        <td>{{ $milestone->deadline->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $milestone->order_number }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('milestones.show', $milestone->id) }}" class="btn btn-sm btn-info">Xem</a>
                            <a href="{{ route('milestones.edit', $milestone->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('milestones.destroy', $milestone->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Chắc chắn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-3">Chưa có mốc nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $milestones->links() }}
    </div>
</div>
@endsection
