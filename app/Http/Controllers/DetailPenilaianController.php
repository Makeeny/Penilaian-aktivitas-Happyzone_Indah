<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilSiswa;
use App\Models\MataPelajaran;
use App\Models\Assessment;
use Illuminate\Support\Facades\DB; // <-- Penting untuk perhitungan peringkat

class DetailPenilaianController extends Controller
{
    /**
     * Menampilkan halaman detail penilaian siswa untuk mata pelajaran tertentu.
     */
    public function show(Request $request, ProfilSiswa $profilSiswa, MataPelajaran $subject)
    {
        // Ambil semua penilaian untuk siswa ini di mata pelajaran ini
        $penilaian = Assessment::where('profil_siswa_id', $profilSiswa->id)
            ->where('subject_id', $subject->id)
            ->with('kriteria')
            ->orderBy('tanggal', 'desc')
            ->get();

        // LOGIKA BARU UNTUK MENGHITUNG PERINGKAT
        // Hitung total poin untuk semua siswa di mata pelajaran ini
        $peringkatSemuaSiswa = Assessment::where('subject_id', $subject->id)
            ->select('profil_siswa_id', DB::raw('SUM(poin) as total_poin_keseluruhan'))
            ->groupBy('profil_siswa_id')
            ->orderBy('total_poin_keseluruhan', 'desc')
            ->get();

        // Cari peringkat siswa yang sedang dilihat
        $peringkatSiswa = $peringkatSemuaSiswa->search(function($item) use ($profilSiswa) {
            return $item->profil_siswa_id == $profilSiswa->id;
        });

        // Peringkat adalah posisi di dalam daftar (tambahkan 1 karena index mulai dari 0)
        $rank = ($peringkatSiswa !== false) ? $peringkatSiswa + 1 : 'N/A';

        return view('penilaian.detail_siswa', [
            'title' => 'Detail Laporan ' . $profilSiswa->nama_lengkap,
            'siswa' => $profilSiswa,
            'subject' => $subject,
            'penilaian' => $penilaian,
            'peringkat' => $rank // <-- Kirim data peringkat ke view
        ]);
    }
}