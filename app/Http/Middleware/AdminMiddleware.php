<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Silakan login sebagai Admin terlebih dahulu.');
        }

        $currentRoute = $request->route()?->getName();
        $currentUri = $request->path();

        $isSuperAdmin = $admin->role === 'super_admin';
        $isDashboardRoute = in_array($currentRoute, ['dashboard', 'admin.dashboard'], true);
        $isKategoriMobilRoute = $currentRoute && str_starts_with($currentRoute, 'kategori-mobils.');
        $isMobilRoute = $currentRoute && str_starts_with($currentRoute, 'mobils.');
        $isAllowedRoute = $isDashboardRoute || $isKategoriMobilRoute || $isMobilRoute;

        if (!$isSuperAdmin && !$isAllowedRoute) {
            return redirect()->route('dashboard')->with('error', 'Akses Anda dibatasi untuk role ini.');
        }

        return $next($request);
    }
}
