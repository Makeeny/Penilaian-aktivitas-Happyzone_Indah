<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    // Menampilkan form feedback
    public function create()
    {
        return view('feedback.create', ['title' => 'Beri Feedback']);
    }

    // Menyimpan feedback baru
    public function store(Request $request)
    {
        // 1. Validasi data (tidak ada yang berubah di sini)
        $validatedData = $request->validate([
            'nama_orang_tua' => 'required|string|max:255',
            'nama_siswa' => 'required|string|max:255',
            'pesan' => 'required|string|max:1000',
        ]);

        // ==========================================================
        // == PERBAIKAN UTAMA ADA DI SINI ==
        // ==========================================================
        try {
            // 2. Coba buat data baru
            Feedback::create($validatedData);

            // 3. Jika berhasil, arahkan ke halaman utama dengan pesan sukses
            return redirect()->route('landing')->with('success', 'Terima kasih! Feedback Anda telah kami terima.');

        } catch (\Exception $e) {
            // 4. Jika terjadi error APAPUN saat menyimpan, tampilkan pesan errornya
            // Ini akan memberitahu kita masalah yang sebenarnya
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menyimpan ke database: ' . $e->getMessage()]);
        }
    }
}