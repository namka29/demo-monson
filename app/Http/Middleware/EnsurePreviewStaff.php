<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Chỉ cán bộ có quyền vào Filament (đang hoạt động) mới xem được trang xem trước.
 */
class EnsurePreviewStaff
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null || ! $user->canAccessAdminPanel()) {
            abort(403, 'Chỉ cán bộ đã đăng nhập mới xem được bản xem trước.');
        }

        return $next($request);
    }
}
