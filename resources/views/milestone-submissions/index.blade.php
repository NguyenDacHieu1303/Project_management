@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Quản lý Bài Nộp Mốc</h2>
        <a href="{{ route('milestone-submissions.create') }}" class="btn btn-primary">Thêm Bài Nộp</a>
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
                        <th>Mốc</th>
                        <th>Sinh viên</th>
                        <th>Ngày nộp</th>
                        <th>File</th>
                        <th class="text-center" style="width: 200px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $index => $sub)
                    <tr>
                        <td class="text-center">{{ $submissions->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $sub->milestone->title }}</strong><br>
                            <small class="text-muted">{{ $sub->milestone->topic->title }}</small>
                        </td>
                        <td>{{ $sub->student->user->name }}</td>
                        <td>{{ $sub->submitted_at->format('d/m/Y H:i') }}</td>
                        <td><small>{{ $sub->file_path }}</small></td>
                        <td class="text-center">
                            <a href="{{ route('milestone-submissions.show', $sub->id) }}" class="btn btn-sm btn-info">Xem</a>
                            <a href="{{ route('milestone-submissions.edit', $sub->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('milestone-submissions.destroy', $sub->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Chắc chắn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-3">Chưa có bài nộp nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $submissions->links() }}
    </div>
</div>
@endsection
