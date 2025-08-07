<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Pastikan ini di-import

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Controller ini menangani otentikasi pengguna untuk aplikasi dan
    | mengarahkan mereka ke halaman utama Anda. Trait ini
    | dengan mudah menyediakan fungsionalitas yang diperlukan.
    |
    */

    use AuthenticatesUsers;

    /**
     * Menampilkan form login.
     * Kita tetap menggunakan method Anda untuk ini.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Method ini adalah "kunci"-nya.
     * Ia akan otomatis dijalankan SETELAH pengguna berhasil login.
     * Di sinilah kita menaruh logika pengalihan berdasarkan role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
       $role = $user->role;
       switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'guru':
                return redirect()->route('guru.dashboard');
            case 'siswa':
                return redirect()->route('siswa.dashboard');
            default:
                // Jika rolenya tidak dikenal, logout saja untuk keamanan
                auth()->logout();
                return redirect('/');
        }
    }

    /**
     * Method logout Anda sudah benar dan kita pertahankan.
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }

    /**
     * Create a new controller instance.
     * Method __construct() sekarang berada di tempat yang benar.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
