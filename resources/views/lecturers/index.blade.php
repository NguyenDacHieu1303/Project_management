@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Quản lý Giảng viên</h2>
        <a href="{{ route('lecturers.create') }}" class="btn btn-primary">Thêm giảng viên mới</a>
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
                        <th>Mã GV</th>
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Chuyên ngành</th>
                        <th>Số SV tối đa</th>
                        <th>Số ĐT</th>
                        <th class="text-center" style="width: 150px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lecturers as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="fw-bold text-primary">{{ $item->lecturer_code }}</td>
                        <td>{{ $item->user->name ?? $item->name }}</td>
                        <td>{{ $item->user->email ?? $item->email }}</td>
                        <td>{{ $item->specialization ?? 'Chưa cập nhật' }}</td>
                        <td class="text-center">{{ $item->quota ?? '-' }}</td>
                        <td>{{ $item->phone ?? 'N/A' }}</td>
                        <td class="text-center">
                            <a href="{{ route('lecturers.edit', $item->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('lecturers.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa giảng viên này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-3">Chưa có dữ liệu giảng viên.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $lecturers->links() }}
    </div>
</div>
@endsection