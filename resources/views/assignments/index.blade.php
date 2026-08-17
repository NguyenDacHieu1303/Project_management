@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Phân công Giảng viên Hướng dẫn</h2>
        <a href="{{ route('assignments.create') }}" class="btn btn-primary">Tạo phân công mới</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width: 60px;">STT</th>
                        <th>Đề tài</th>
                        <th>Giảng viên Hướng dẫn</th>
                        <th>Vai trò</th>
                        <th>Ngày phân công</th>
                        <th class="text-center" style="width: 120px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->topic->title ?? 'N/A' }}</strong><br>
                            <small class="text-muted">Mã đề tài: {{ $item->topic->code ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <strong>{{ $item->lecturer->user->name ?? $item->lecturer->name ?? 'N/A' }}</strong><br>
                            <small class="text-muted">Mã GV: {{ $item->lecturer->lecturer_code ?? '' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-success">
                                {{ $item->role ?? 'GVHD chính' }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <form action="{{ route('assignments.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn muốn hủy phân công này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hủy phân công</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-3">Chưa có phân công giảng viên nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $assignments->links() }}
    </div>
</div>
@endsection