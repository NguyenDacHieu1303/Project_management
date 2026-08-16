<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Đồ án</title>
    <!-- Nhúng CSS Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Thanh Điều hướng (Navbar) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <!-- 1. Sửa link Brand: Trỏ về trang chủ url('/') và set màu text-light để không bị chói -->
            <a class="navbar-brand {{ request()->is('/') ? 'text-white fw-bold' : 'text-light' }}" href="{{ url('/') }}">
                Hệ thống Quản lý
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    
                    <!-- 2. Link tới trang Sinh viên: Đã thêm logic kiểm tra route -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('students.*') ? 'active fw-bold text-white' : '' }}" href="{{ route('students.index') }}">
                            Quản lý Sinh viên
                        </a>
                    </li>
                    
                    <!-- 3. Link tới trang Đề tài: Đã thêm logic kiểm tra route -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('topics.*') ? 'active fw-bold text-white' : '' }}" href="{{ route('topics.index') }}">
                            Quản lý Đề tài
                        </a>
                    </li>
                    
                    <!-- 4. Link tới trang đăng kí đề tài: Đồng bộ class hiển thị -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('topic-registrations.*') ? 'active fw-bold text-white' : '' }}" href="{{ route('topic-registrations.index') }}">
                            Đơn đăng ký Đề tài
                        </a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>

    <!-- Nơi chứa nội dung của từng trang -->
    <main>
        @yield('content')
    </main>

    <!-- Nhúng JS Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>