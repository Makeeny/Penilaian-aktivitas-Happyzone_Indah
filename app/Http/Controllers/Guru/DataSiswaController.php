<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilSiswa;
use App\Models\MataPelajaran;
use App\Models\Assessment; // Diperlukan untuk mengambil data kelas

class DataSiswaController extends Controller
{
    public function index(Request $request, MataPelajaran $mapel = null)
    {
        // Ambil semua mapel untuk filter dropdown
        $listMapel = MataPelajaran::orderBy('nama_mapel')->get();

        // Query dasar untuk mengambil semua profil siswa
        $query = ProfilSiswa::with('user');

        // Jika ada filter mata pelajaran yang diterapkan dari URL atau dari parameter
        $mapelAktif = $mapel;
        if ($request->filled('subject_id')) {
            $mapelAktif = MataPelajaran::find($request->subject_id);
        }

        if ($mapelAktif) {
            // Ambil ID semua siswa yang pernah dinilai di mata pelajaran ini
            $siswaIds = Assessment::where('subject_id', $mapelAktif->id)
                                  ->distinct()
                                  ->pluck('profil_siswa_id');
            
            // Filter profil siswa berdasarkan ID yang ditemukan
            $query->whereIn('id', $siswaIds);
        }

        // Ambil data siswa yang sudah difilter
        $siswas = $query->orderBy('nama_lengkap', 'asc')->get();

        return view('guru.data-siswa.index', [
            'title' => 'Data Nama Siswa',
            'siswas' => $siswas,
            'listMapel' => $listMapel,
            'mapelAktif' => $mapelAktif,
            'listMapelForSidebar' => $listMapel // Untuk sidebar
        ]);
    }
}