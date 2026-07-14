<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PelangganMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!\Illuminate\Support\Facades\Auth::guard('pelanggan')->check()) {
            return redirect()->route('pelanggan.login')->with('error', 'Silakan login sebagai Pelanggan terlebih dahulu.');
        }

        return $next($request);
    }
}
