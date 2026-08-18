<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Đồ án - TLU</title>

    <!-- 1. Nhúng Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- 2. Nhúng Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- THANH ĐIỀU HƯỚNG -->
    <nav class="bg-white shadow-md sticky top-0 z-50 mb-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">🏫</div>
                    <span class="font-bold text-xl text-blue-900 tracking-tight">Hệ Thống Đồ Án</span>
                </div>

                <!-- Khu vực Menu Động & Hiệu ứng Active (Control) -->
                <div class="hidden md:flex space-x-6 text-sm font-medium items-center">
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-blue-600' }} transition">Trang chủ</a>

                    @if(Auth::check())

                        {{-- MENU CHO ADMIN --}}
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('topics.index') }}" class="{{ request()->routeIs('topics.*') ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-blue-600' }} transition">Quản lý Đề tài</a>
                            <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-blue-600' }} transition">Quản lý Sinh viên</a>
                            <a href="{{ route('topic-registrations.index') }}" class="{{ request()->routeIs('topic-registrations.*') ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-blue-600' }} transition">Đơn đăng ký</a>
                            <a href="{{ route('milestones.index') }}" class="{{ request()->routeIs('milestones.*') ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-blue-600' }} transition">Quản lý Mốc Nộp</a>

                        {{-- MENU CHO GIẢNG VIÊN --}}
                        @elseif(Auth::user()->role === 'lecturer')
                            <a href="{{ route('lecturer.topics') }}" class="{{ request()->routeIs('lecturer.topics') ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-blue-600' }} transition">Đề tài hướng dẫn</a>
                            <a href="{{ route('lecturer.registrations') }}" class="{{ request()->routeIs('lecturer.registrations') ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-blue-600' }} transition">Duyệt đăng ký</a>
                            <a href="{{ route('lecturer.submissions') }}" class="{{ request()->routeIs('lecturer.submissions') ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-blue-600' }} transition">Bài Nộp Mốc</a>

                        {{-- MENU CHO SINH VIÊN --}}
                        @elseif(Auth::user()->role === 'student')
                            <!-- Tra cứu đề tài -->
                            <a href="{{ route('topics.index') }}"
                                class="{{ request()->routeIs('topics.index') && !request()->has('filter') ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-blue-600' }} transition">
                                Tra cứu đề tài
                            </a>

                            <!-- Đăng ký đề tài -->
                            <a href="{{ route('topics.index', ['filter' => 'open']) }}"
                                class="{{ request()->query('filter') == 'open' ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-blue-600' }} transition">
                                Đăng ký đề tài
                            </a>

                            <!-- Đồ án của tôi -->
                            <a href="{{ route('topic-registrations.index') }}" class="{{ request()->routeIs('topic-registrations.*') ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-gray-600' }} transition">Đồ án của tôi</a>
                        @endif

                    @endif
                </div>

                <!-- Khu vực User / Đăng xuất -->
                <div>
                    @if(Auth::check())
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-semibold text-gray-700 hidden sm:block">
                                Chào, {{ Auth::user()->name }}!
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full ml-1">{{ strtoupper(Auth::user()->role) }}</span>
                            </span>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-semibold transition border border-red-200">
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex space-x-3">
                            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                                Đăng nhập
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Nội dung chính -->
    <main class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Nhúng JS Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>