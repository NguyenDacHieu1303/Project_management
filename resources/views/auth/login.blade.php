<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập | Quản lý Đồ án TLU</title>
    <!-- Nhúng Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Inter -->
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
            background-image: url('{{ asset("images/tlu.jpg") }}'); 
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
            padding: 14px 16px;
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
        .btn-social {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px;
            font-weight: 500;
            color: #374151;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background-color 0.2s;
        }
        .btn-social:hover {
            background-color: #f3f4f6;
        }
        .btn-social img { width: 20px; }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
            color: #9ca3af;
            font-size: 0.85rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e5e7eb;
        }
        .divider:not(:empty)::before { margin-right: 15px; }
        .divider:not(:empty)::after { margin-left: 15px; }
        .forgot-link {
            font-size: 0.85rem;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }
        .footer-text {
            font-size: 0.8rem;
            color: #9ca3af;
            text-align: center;
            margin-top: 40px;
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
        <!-- Cột Form Đăng nhập -->
        <div class="form-section">
            <h2 class="fw-bold mb-2 text-dark">Chào mừng trở lại 👋</h2>
            <p class="text-muted mb-4" style="font-size: 0.95rem;">
                Hôm nay là một ngày tuyệt vời.<br>
                Hãy đăng nhập để bắt đầu quản lý đồ án của bạn.
            </p>

            <!-- Báo lỗi -->
            @if ($errors->any())
                <div class="alert alert-danger py-2 rounded-3 text-sm" style="font-size: 0.9rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Địa chỉ Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="nhap_email@tlu.edu.vn" required autofocus>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" name="password" placeholder="Nhập ít nhất 8 ký tự" required>
                </div>

                <div class="d-flex justify-content-end mb-4">
                    <a href="#" class="forgot-link">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="btn btn-signin w-100">Đăng nhập</button>
            </form>

            <div class="divider">Hoặc</div>

            <div class="row g-3 mb-4">
                <div class="col-6">
                    <a href="#" class="text-decoration-none">
                        <div class="btn-social w-100">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google">
                            Google
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="#" class="text-decoration-none">
                        <div class="btn-social w-100">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" alt="Facebook">
                            Facebook
                        </div>
                    </a>
                </div>
            </div>

            <p class="text-center mb-0 text-muted" style="font-size: 0.95rem;">
                Bạn chưa có tài khoản? <a href="{{ route('register') }}" class="forgot-link">Đăng ký ngay</a>
            </p>

            <div class="footer-text">
                © 2026 Bản quyền thuộc về Nhóm Phát triển
            </div>
        </div>

        <!-- Cột Ảnh nền -->
        <div class="image-section">
            <div class="cover-image"></div>
        </div>
    </div>

</body>
</html>