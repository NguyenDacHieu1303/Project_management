@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h2 class="fw-bold text-primary">👨‍🏫 Quản lý Đề tài Hướng Dẫn</h2>
        <p class="text-muted">Danh sách các đề tài và sinh viên đang thực hiện đồ án dưới sự hướng dẫn của bạn.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">Tên Đề tài</th>
                        <th class="py-3">Chuyên ngành</th>
                        <th class="py-3">Sinh viên thực hiện</th>
                        <th class="text-center py-3">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topics as $topic)
                    <tr>
                        <td class="align-middle px-4 fw-semibold">{{ $topic->title }}</td>
                        <td class="align-middle">{{ $topic->major }}</td>
                        <td class="align-middle">
                            @php
                                $approvedReg = $topic->registrations->first();
                            @endphp

                            @if($approvedReg && $approvedReg->student)
                                <span class="fw-bold text-success">{{ $approvedReg->student->user->name }}</span>
                                <br><small class="text-muted">Mã SV: {{ $approvedReg->student->student_code ?? 'N/A' }}</small>
                            @else
                                <span class="text-muted fst-italic">Chưa có sinh viên</span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge bg-{{ $topic->status == 'Assigned' ? 'warning text-dark' : 'primary' }}">
                                {{ $topic->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">Bạn chưa phụ trách hướng dẫn đề tài nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($topics->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end">
            {{ $topics->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection