<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký | Hệ thống Quản lý Đồ án</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .main-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            max-width: 1100px;
            width: 100%;
            overflow: hidden;
            display: flex;
            min-height: 700px;
        }
        .form-section {
            flex: 1;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .image-section {
            flex: 1;
            padding: 20px;
            display: flex;
        }
        .cover-image {
            width: 100%;
            height: 100%;
            border-radius: 20px;
            background-image: url('{{ asset("images/tlu.jpg") }}'); /* Dùng chung ảnh TLU với trang Login */
            background-size: cover;
            background-position: center;
        }
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .form-control {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
        }
        .form-control:focus {
            background-color: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .btn-signin {
            background-color: #111827;
            color: white;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-signin:hover {
            background-color: #374151;
            color: white;
        }
        .forgot-link {
            font-size: 0.85rem;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }
        @media (max-width: 991px) {
            .main-card {
                flex-direction: column-reverse;
                min-height: auto;
            }
            .form-section { padding: 30px 20px; }
            .image-section { padding: 10px; height: 250px; }
            .cover-image { border-radius: 16px; }
        }
    </style>
</head>
<body>

    <div class="main-card">
        <!-- Cột Form Đăng ký -->
        <div class="form-section">
            <h2 class="fw-bold mb-2 text-dark">Tạo tài khoản mới </h2>
            <p class="text-muted mb-4" style="font-size: 0.95rem;">
                Tham gia hệ thống để bắt đầu quá trình làm đồ án của bạn.
            </p>

            <!-- Báo lỗi Validate -->
            @if ($errors->any())
                <div class="alert alert-danger py-2 rounded-3 text-sm" style="font-size: 0.9rem;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Ví dụ: Nguyễn Văn A" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Địa chỉ Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="sinhvien@tlu.edu.vn" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" name="password" placeholder="Nhập ít nhất 8 ký tự" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                </div>

                <button type="submit" class="btn btn-signin w-100">Đăng ký tài khoản</button>
            </form>

            <p class="text-center mt-4 mb-0 text-muted" style="font-size: 0.95rem;">
                Bạn đã có tài khoản? <a href="{{ route('login') }}" class="forgot-link">Đăng nhập ngay</a>
            </p>
        </div>

        <!-- Cột Ảnh nền -->
        <div class="image-section">
            <div class="cover-image"></div>
        </div>
    </div>

</body>
</html>