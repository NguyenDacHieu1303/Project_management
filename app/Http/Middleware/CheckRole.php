<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // 1. Nếu chưa đăng nhập thì đuổi ra trang login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Nếu đã đăng nhập nhưng chức vụ (role) không khớp -> Báo lỗi 403 (Cấm truy cập)
        if (Auth::user()->role !== $role) {
            abort(403, 'CẢNH BÁO: Bạn không có quyền truy cập vào khu vực này!');
        }

        // 3. Nếu đúng chức vụ thì mở cửa cho đi tiếp
        return $next($request);
    }
}
