@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-3">
                <a href="{{ route('topics.index') }}" class="btn btn-sm btn-secondary">← Quay lại danh sách</a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="fw-bold text-primary mb-3">{{ $topic->title }}</h2>
                    
                    <p><strong>Chuyên ngành:</strong> {{ $topic->major }}</p>
                    <p><strong>Học kỳ:</strong> {{ $topic->semester }}</p>
                    <p><strong>Trạng thái:</strong> 
                        @if($topic->status == 'Open')
                            <span class="badge bg-success">Mở đăng ký</span>
                        @else
                            <span class="badge bg-danger">Đã đóng</span>
                        @endif
                    </p>

                    <hr>

                    <h5 class="fw-bold">Mô tả đề tài:</h5>
                    <p class="text-muted" style="white-space: pre-line;">{{ $topic->description ?? 'Chưa có mô tả chi tiết.' }}</p>

                    {{-- Kiểm tra xem sinh viên đã có đơn nào Pending hoặc Approved chưa --}}
                    @php
                        $hasRegistered = false;
                        if(Auth::check() && Auth::user()->role === 'student' && Auth::user()->student) {
                            $hasRegistered = \App\Models\TopicRegistration::where('student_id', Auth::user()->student->id)
                                ->whereIn('status', ['Pending', 'Approved'])
                                ->exists();
                        }
                    @endphp

                    <!-- Nút đăng ký dành riêng cho Sinh viên -->
                    @if(Auth::check() && Auth::user()->role === 'student' && $topic->status == 'Open')
                        <div class="mt-4">
                            @if($hasRegistered)
                                <div class="alert alert-secondary text-center fw-bold py-3 mb-0">
                                    Bạn đang có đề tài chờ duyệt hoặc đã được duyệt. Không thể đăng ký thêm đề tài này!
                                </div>
                            @else
                                <form action="{{ route('topic-registrations.store') }}" method="POST" onsubmit="return confirm('Bạn xác nhận muốn đăng ký đề tài này?');">
                                    @csrf
                                    <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                                    <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">Đăng ký Đề tài này ngay</button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection