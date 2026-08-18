@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold text-primary"> Nộp Bài Theo Mốc Tiến Độ</h2>
        <p class="text-muted">Theo dõi deadline và tải lên các sản phẩm báo cáo đồ án của bạn.</p>
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

    @if(!$registration)
        <!-- Trường hợp sinh viên chưa được duyệt đề tài nào -->
        <div class="alert alert-warning shadow-sm p-4 text-center">
            <h4 class="fw-bold mb-2"> Bạn chưa có đề tài được duyệt!</h4>
            <p class="mb-3">Bạn cần phải được duyệt một đề tài đồ án thì mới hiển thị danh sách các mốc nộp bài.</p>
            <a href="{{ route('topics.index') }}" class="btn btn-primary fw-bold">Đi tới Tra cứu Đề tài</a>
        </div>
    @else
        <!-- Hiển thị thông tin đề tài hiện tại -->
        <div class="card shadow-sm border-0 mb-4 bg-light">
            <div class="card-body">
                <h5 class="fw-bold text-dark mb-1">Đề tài đang thực hiện: <span class="text-primary">{{ $registration->topic->title }}</span></h5>
                <p class="mb-0 text-muted">Chuyên ngành: {{ $registration->topic->major }} | Học kỳ: {{ $registration->topic->semester }}</p>
            </div>
        </div>

        <!-- Danh sách các mốc (Milestones) -->
        <div class="row">
            @forelse($registration->topic->milestones as $milestone)
                @php
                    // Lấy bài nộp của sinh viên cho mốc này (nếu có)
                    $submission = $milestone->submissions->first();
                @endphp
                <div class="col-md-12 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            
                            <!-- Thông tin mốc -->
                            <div>
                                <h5 class="fw-bold text-dark mb-1"> {{ $milestone->title }}</h5>
                                <p class="mb-1 text-muted small">Hạn nộp (Deadline): <strong class="text-danger">{{ \Carbon\Carbon::parse($milestone->deadline)->format('d/m/Y H:i') }}</strong></p>
                                
                                @if($submission)
                                    <p class="mb-0 text-success small">
                                         Đã nộp lúc: {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d/m/Y H:i') }}
                                        | File: <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="text-decoration-underline">Tải xuống</a>
                                    </p>
                                    @if($submission->note)
                                        <p class="mb-0 text-muted small fst-italic">Ghi chú của bạn: "{{ $submission->note }}"</p>
                                    @endif
                                @else
                                    <p class="mb-0 text-warning small"> Trạng thái: Chưa nộp bài</p>
                                @endif
                            </div>

                            <!-- Form nộp file -->
                            <div style="min-width: 300px;">
                                <form action="{{ route('student.milestones.submit', $milestone->id) }}" method="POST" enctype="multipart/form-data" class="p-3 bg-white rounded border">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold">Chọn file báo cáo (PDF, Docx, Zip...):</label>
                                        <input type="file" name="file" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="note" class="form-control form-control-sm" placeholder="Ghi chú thêm (nếu có)..." value="{{ $submission->note ?? '' }}">
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-success w-100 fw-bold">
                                        {{ $submission ? ' Nộp lại bài mới' : ' Tải lên nộp bài' }}
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Đề tài này hiện chưa được cấu hình các mốc nộp bài (Milestones).</p>
                </div>
            @endforelse
        </div>
    @endif
</div>
@endsection