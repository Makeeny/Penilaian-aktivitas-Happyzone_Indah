<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Import model User

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total user berdasarkan role
        $totalGuru = User::where('role', 'guru')->count();
        $totalSiswa = User::where('role', 'siswa')->count();

        // --- LOGIKA BARU ---
        // Mengambil 5 user terakhir yang dibuat, diurutkan dari yang paling baru.
        $penggunaTerbaru = User::latest()->take(5)->get();
        
        // Mengirim data ke view
        return view('admin.dashboard', [
            'totalGuru' => $totalGuru,
            'totalSiswa' => $totalSiswa,
            'penggunaTerbaru' => $penggunaTerbaru,
        ]);
    }
}