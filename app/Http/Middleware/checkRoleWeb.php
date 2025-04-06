<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleWeb
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        // Kiểm tra người dùng có vai trò không
        if (!$user || !$user->roles()->pluck('roleName')->contains($role)) {
            return abort(403, 'Bạn không có quyền truy cập vào trang này');
        }

        return $next($request);
    }
}
