<?php

namespace App\Http\Controllers\Siswa;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\ProfilSiswa;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama siswa.
     */
    public function index()
    {
        // Ambil semua data mata pelajaran
        $mapels = MataPelajaran::all();

        // Kirim data tersebut ke view
        return view('siswa.dashboard', [
            'title' => 'Dashboard Siswa',
            'mapels' => $mapels // <-- Ini yang akan memperbaiki error
        ]);
    }

    /**
     * Menampilkan halaman detail penilaian untuk mata pelajaran tertentu.
     */
     public function showPenilaian(Request $request, MataPelajaran $subject)
    {
        $profilSiswa = ProfilSiswa::where('user_id', Auth::id())->firstOrFail();

        // Query dasar untuk mengambil semua penilaian di mapel ini
        $query = Assessment::where('subject_id', $subject->id)
                            ->with('kriteria');

        // Terapkan filter tanggal jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }
        
        $semuaPenilaianDiMapel = $query->orderBy('tanggal', 'desc')->get();

        // ==========================================================
        // == LOGIKA BARU UNTUK PERINGKAT HARIAN ==
        // ==========================================================
        // Kelompokkan penilaian berdasarkan tanggal
        $penilaianPerTanggal = $semuaPenilaianDiMapel->groupBy('tanggal');
        $peringkatHarian = [];

        foreach ($penilaianPerTanggal as $tanggal => $penilaianDiHariItu) {
            // Untuk setiap hari, hitung total poin semua siswa yang dinilai pada hari itu
            $poinSemuaSiswa = Assessment::where('tanggal', $tanggal)
                                        ->where('subject_id', $subject->id)
                                        ->select('profil_siswa_id', DB::raw('SUM(poin) as total_poin'))
                                        ->groupBy('profil_siswa_id')
                                        ->orderBy('total_poin', 'desc')
                                        ->get();
            
            // Cari peringkat siswa yang sedang login
            $rank = $poinSemuaSiswa->search(function($item) use ($profilSiswa) {
                return $item->profil_siswa_id == $profilSiswa->id;
            });

            // Simpan peringkatnya (tambahkan 1 karena index dimulai dari 0)
            $peringkatHarian[$tanggal] = ($rank !== false) ? $rank + 1 : null;
        }
        // ==========================================================
        
        // Ambil hanya penilaian milik siswa yang sedang login untuk ditampilkan di tabel
        $penilaianSiswa = $semuaPenilaianDiMapel->where('profil_siswa_id', $profilSiswa->id);
        
        return view('siswa.penilaian_detail', [
            'title' => 'Detail Penilaian ' . $subject->nama_mapel,
            'subject' => $subject,
            'penilaian' => $penilaianSiswa,
            'peringkatHarian' => $peringkatHarian, // <-- Kirim data peringkat ke view
        ]);
    }

    // Di dalam file: app/Http/Controllers/Siswa/DashboardController.php

    /**
     * Menampilkan halaman rekap poin dan detail penilaian.
     */
    public function rekapPoin(Request $request, MataPelajaran $subject)
    {
        $profilSiswa = ProfilSiswa::where('user_id', Auth::id())->firstOrFail();

        // Ambil semua penilaian untuk siswa ini di mapel ini
        $penilaian = Assessment::where('profil_siswa_id', $profilSiswa->id)
                            ->where('subject_id', $subject->id)
                            ->with('kriteria')
                            ->orderBy('tanggal', 'desc')
                            ->get();
        
        // Hitung total poin
        $totalPoin = $penilaian->sum('poin');

        return view('siswa.rekap_poin', [
            'title' => 'Rekap Poin ' . $subject->nama_mapel,
            'siswa' => $profilSiswa,
            'subject' => $subject,
            'penilaian' => $penilaian,
            'totalPoin' => $totalPoin,
        ]);
    }

    public function tukarPoin(Request $request)
    {
        $siswa = Auth::user();

        // 1. Dapatkan semua user dengan role 'guru'
        $gurus = User::where('role', 'guru')->get();

        // 2. Buat notifikasi untuk setiap guru
        foreach ($gurus as $guru) {
            Notification::create([
                'user_id' => $guru->id,
                'message' => "Siswa " . $siswa->name . " mengajukan permintaan tukar poin.",
                // 'url' => route('...'), // Arahkan ke halaman detail jika ada
            ]);
        }

        // 3. Kembali ke dashboard siswa dengan pesan sukses
        return redirect()->route('siswa.dashboard')->with('success', 'Permintaan tukar poin berhasil diajukan dan notifikasi telah dikirim ke guru!');    }
}
