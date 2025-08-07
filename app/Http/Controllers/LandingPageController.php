<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback; // Pastikan ini ada

class LandingPageController extends Controller
{
    /**
     * Menampilkan halaman landing beserta data testimoni.
     */
    public function index()
    {
        try {
            // Ambil semua feedback yang disetujui untuk tampil (is_tampil = true)
            $feedbacks = Feedback::where('is_tampil', true)->inRandomOrder()->get();

            // Jika Anda ingin melakukan "intip" data, uncomment baris di bawah ini
            // dd($testimonials); 

            return view('landing', [
                'feedback' => $feedbacks,
            ]);

        } catch (\Exception $e) {
            // Jika terjadi error (misal: tabel tidak ada, kolom salah), tampilkan pesan errornya
            dd('Error saat mengambil data feedback: ' . $e->getMessage());
        }
    }
}