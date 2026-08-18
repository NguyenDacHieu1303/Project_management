<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Đồ án - TLU</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- 1. THANH ĐIỀU HƯỚNG (NAVBAR ĐỘNG) -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">🏫</div>
                    <span class="font-bold text-xl text-blue-900 tracking-tight">Hệ Thống Đồ Án</span>
                </div>
                
                <!-- Khu vực Menu Động -->
                <div class="hidden md:flex space-x-6 text-sm font-medium">
                    <a href="{{ url('/') }}" class="text-blue-600 font-bold">Trang chủ</a>

                    @if(Auth::check())
                        
                        {{-- MENU CHO ADMIN --}}
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('topics.index') }}" class="text-gray-600 hover:text-blue-600 transition">Quản lý Đề tài</a>
                            <a href="#" class="text-gray-600 hover:text-blue-600 transition">Quản lý Sinh viên</a>
                            <a href="#" class="text-gray-600 hover:text-blue-600 transition">Phân công Giảng viên</a>

                        {{-- MENU CHO GIẢNG VIÊN --}}
                        @elseif(Auth::user()->role === 'lecturer')
                            <a href="#" class="text-gray-600 hover:text-blue-600 transition">Đề tài hướng dẫn</a>
                            <a href="#" class="text-gray-600 hover:text-blue-600 transition">Duyệt đăng ký</a>
                            <a href="#" class="text-gray-600 hover:text-blue-600 transition">Chấm điểm & Đánh giá</a>

                        {{-- MENU CHO SINH VIÊN --}}
                        @elseif(Auth::user()->role === 'student')
                            <a href="#" class="text-gray-600 hover:text-blue-600 transition">Tra cứu đề tài</a>
                            <a href="#" class="text-gray-600 hover:text-blue-600 transition">Đăng ký đề tài</a>
                            <a href="#" class="text-gray-600 hover:text-blue-600 transition">Đồ án của tôi</a>
                        @endif

                    @else
                        {{-- MENU CHO KHÁCH (CHƯA ĐĂNG NHẬP) --}}
                        <a href="#" class="text-gray-600 hover:text-blue-600 transition">Tra cứu đề tài</a>
                        <a href="#" class="text-gray-600 hover:text-blue-600 transition">Lịch bảo vệ</a>
                        <a href="#" class="text-gray-600 hover:text-blue-600 transition">Hướng dẫn</a>
                    @endif
                </div>
                
                <!-- Khu vực User / Đăng nhập / Đăng xuất -->
                <div>
                    @if(Auth::check())
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-semibold text-gray-700 hidden sm:block">
                                Chào, {{ Auth::user()->name }}! 
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full ml-1">{{ strtoupper(Auth::user()->role) }}</span>
                            </span>
                            <form action="{{ route('logout') }}" method="POST">
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
                            <a href="{{ route('register') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-5 py-2 rounded-lg text-sm font-semibold transition border border-gray-200 hidden sm:block">
                                Đăng ký
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. HERO SECTION -->
    <header class="bg-gradient-to-r from-blue-900 to-indigo-800 text-white py-20 px-4 text-center">
        <div class="max-w-4xl mx-auto">
            <span class="bg-blue-500/30 text-blue-200 text-xs uppercase px-3 py-1 rounded-full font-semibold tracking-wider">Cổng thông tin đào tạo</span>
            <h1 class="text-4xl md:text-5xl font-extrabold mt-4 leading-tight">
                Quản Lý Đồ Án & Khóa Luận Tốt Nghiệp
            </h1>
            <p class="text-lg text-blue-100 mt-4 max-w-2xl mx-auto">
                Tối ưu hóa quy trình, kết nối Sinh viên và Giảng viên hướng dẫn, theo dõi tiến độ trực quan theo thời gian thực.
            </p>
            
            <div class="mt-8 flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                @if(Auth::check())
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('topics.index') }}" class="bg-white text-blue-900 hover:bg-gray-100 px-6 py-3 rounded-lg font-bold shadow transition text-center">
                            Vào trang Quản trị Hệ thống
                        </a>
                    @else
                        <a href="#" class="bg-white text-blue-900 hover:bg-gray-100 px-6 py-3 rounded-lg font-bold shadow transition text-center">
                            Bảng điều khiển của tôi
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="bg-white text-blue-900 hover:bg-gray-100 px-6 py-3 rounded-lg font-bold shadow transition text-center">
                        Bắt đầu ngay
                    </a>
                    <a href="#" class="bg-transparent border-2 border-white/80 hover:bg-white/10 px-6 py-3 rounded-lg font-bold transition text-center">
                        Tìm hiểu thêm
                    </a>
                @endif
            </div>
        </div>
    </header>

    <!-- 3. TÍNH NĂNG CỐT LÕI -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Quy trình làm việc thông minh</h2>
            <p class="text-gray-500 mt-2">Hệ thống hỗ trợ toàn diện các bước thực hiện đồ án từ lúc bắt đầu đến khi hội đồng chấm điểm.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xl mb-4">📂</div>
                <h3 class="font-bold text-lg mb-2">Đăng ký đề tài trực tuyến</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Sinh viên dễ dàng duyệt danh sách đề tài từ giảng viên hoặc tự đề xuất ý tưởng nghiên cứu mới.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-xl mb-4">📊</div>
                <h3 class="font-bold text-lg mb-2">Báo cáo & Theo dõi tiến độ</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Hệ thống nhắc lịch định kỳ, hỗ trợ nộp báo cáo tuần và nhận phản hồi, chỉnh sửa từ Thầy/Cô.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center text-xl mb-4">💾</div>
                <h3 class="font-bold text-lg mb-2">Nộp chấm & Lưu trữ dữ liệu</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Số hóa toàn bộ kho lưu trữ đồ án trường học, hỗ trợ xuất file báo cáo, chấm điểm hội đồng tiện lợi.</p>
            </div>
        </div>
    </main>

    <!-- 4. FOOTER -->
    <footer class="bg-gray-950 text-gray-400 py-8 text-center text-sm border-t border-gray-800">
        <p>© 2026 Trung tâm Công nghệ Thông tin - Trường Đại Học Thủy Lợi</p>
        <p class="mt-1 text-xs text-gray-600">Hỗ trợ kỹ thuật: support@tlu.edu.vn | Hotline: 024.xxxx.xxxx</p>
    </footer>

</body>
</html>