<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Đồ án - Hiếu</title>
    <!-- Nhúng CSS Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Thanh Điều hướng (Navbar) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Hệ thống Quản lý</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Link tới trang Sinh viên -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('students.index') }}">Quản lý Sinh viên</a>
                    </li>
                    <!-- Link tới trang Đề tài -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('topics.index') }}">Quản lý Đề tài</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Nơi chứa nội dung của từng trang (Students, Topics) -->
    <main>
        @yield('content')
    </main>

    <!-- Nhúng JS Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>