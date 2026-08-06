@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Danh sách Đề tài (Topics)</h2>
        <a href="{{ route('topics.create') }}" class="btn btn-primary">Thêm Đề tài mới</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Tên Đề tài</th>
                        <th>Chuyên ngành</th>
                        <th>Học kỳ</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topics as $index => $topic)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $topic->title }}</td>
                        <td>{{ $topic->major }}</td>
                        <td>{{ $topic->semester }}</td>
                        <td>
                            @if($topic->status == 'Open')
                                <span class="badge bg-success">Mở đăng ký</span>
                            @elseif($topic->status == 'Assigned')
                                <span class="badge bg-warning text-dark">Đã phân công</span>
                            @else
                                <span class="badge bg-danger">Đã đóng</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            
                            <form action="{{ route('topics.destroy', $topic->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đề tài này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection