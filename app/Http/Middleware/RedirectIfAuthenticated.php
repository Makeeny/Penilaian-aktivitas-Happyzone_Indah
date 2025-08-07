<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Jika user sudah login, periksa rolenya
                $role = Auth::user()->role;

                // Arahkan ke dashboard yang sesuai dengan role
                switch ($role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'guru':
                        return redirect()->route('guru.dashboard');
                    case 'siswa':
                        return redirect()->route('siswa.dashboard');
                    default:
                        // Jika role tidak dikenal, arahkan ke halaman utama
                        return redirect('/');
                }
            }
        }

        return $next($request);
    }
}
