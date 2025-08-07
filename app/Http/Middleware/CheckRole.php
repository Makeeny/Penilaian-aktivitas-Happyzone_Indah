<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user login
        if (!auth()->check()) {
            abort(403, 'AKSES DITOLAK. Anda belum login.');
        }

        // Ambil role user saat ini
        $userRole = auth()->user()->role;

        // Cek apakah role user termasuk dalam array role yang diizinkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'AKSES DITOLAK. Role Anda tidak diizinkan.');
        }

        return $next($request);
    }
}
