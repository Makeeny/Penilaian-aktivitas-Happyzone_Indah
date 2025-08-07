<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Kita butuh ini untuk mengambil daftar guru lain

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk guru.
     */
    public function index()
    {
        // Mengambil semua user dengan role 'guru' untuk ditampilkan di kartu
        $gurus = User::where('role', 'guru')->get();

        return view('guru.dashboard', [
            'gurus' => $gurus
        ]);
    }
}
