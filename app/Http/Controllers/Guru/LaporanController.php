<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Kriteria;
use App\Models\MataPelajaran;
use App\Models\ProfilSiswa;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $mapels = MataPelajaran::all();
        $kriterias = Kriteria::all()->keyBy('kode_kriteria'); // Ambil kriteria dengan key kodenya
        $hasilAkhir = [];

        if ($request->filled('subject_id') && $request->filled('tanggal')) {
            // NOTE: Query sekarang hanya mengambil satu baris per penilaian
        $penilaian = Assessment::with('profilSiswa.user')
            ->where('subject_id', $request->subject_id)
            ->whereDate('tanggal', $request->tanggal)
            ->get();

        if ($penilaian->isNotEmpty()) {
            // TAHAP A: Konversi Nilai (1-100) menjadi Skor (1-5)
            $matriksKeputusan = [];
            foreach ($penilaian as $nilaiSiswa) {
                $matriksKeputusan[$nilaiSiswa->profil_siswa_id]['C1'] = $this->konversiNilaiKeSkor($nilaiSiswa->nilai_c1, $kriterias['C1']);
                $matriksKeputusan[$nilaiSiswa->profil_siswa_id]['C2'] = $this->konversiNilaiKeSkor($nilaiSiswa->nilai_c2, $kriterias['C2']);
                $matriksKeputusan[$nilaiSiswa->profil_siswa_id]['C3'] = $this->konversiNilaiKeSkor($nilaiSiswa->nilai_c3, $kriterias['C3']);
                $matriksKeputusan[$nilaiSiswa->profil_siswa_id]['C4'] = $this->konversiNilaiKeSkor($nilaiSiswa->nilai_c4, $kriterias['C4']);
            }

            // TAHAP B: Normalisasi Matriks
            $matriksTernormalisasi = [];
            foreach ($kriterias as $kode => $kriteria) {
                $kolomKriteria = array_column($matriksKeputusan, $kode);
                if(empty($kolomKriteria) || max($kolomKriteria) == 0) continue;
                $maxVal = max($kolomKriteria);
                $minVal = min(array_filter($kolomKriteria) ?: [0]);
                foreach ($penilaian as $nilaiSiswa) {
                    $skor = $matriksKeputusan[$nilaiSiswa->profil_siswa_id][$kode] ?? 0;
                    if ($kriteria->jenis == 'benefit') {
                        $matriksTernormalisasi[$nilaiSiswa->profil_siswa_id][$kode] = ($maxVal > 0) ? ($skor / $maxVal) : 0;
                    } else { // cost
                        $matriksTernormalisasi[$nilaiSiswa->profil_siswa_id][$kode] = ($skor > 0) ? ($minVal / $skor) : 0;
                    }
                }
            }

            // TAHAP C: Perangkingan
            foreach ($penilaian as $nilaiSiswa) {
                $nilaiV = 0;
                foreach ($kriterias as $kode => $kriteria) {
                    $nilaiV += ($matriksTernormalisasi[$nilaiSiswa->profil_siswa_id][$kode] * $kriteria->bobot);
                }
                $hasilAkhir[] = ['siswa' => $nilaiSiswa->profilSiswa, 'nilai_akhir' => $nilaiV];
            }
            
            usort($hasilAkhir, fn($a, $b) => $b['nilai_akhir'] <=> $a['nilai_akhir']);
        }
    }
    
    return view('guru.laporan.index', [
        'title' => 'Laporan Penilaian Siswa',
        'mapels' => $mapels,
        'kriterias' => Kriteria::all(),
        'hasilPeringkat' => $hasilAkhir
    ]);
}

    private function konversiNilaiKeSkor($nilaiAsli, $kriteria)
    {
         if ($nilaiAsli === null) return 0;
         $nilai = intval($nilaiAsli);

        switch ($kriteria->kode_kriteria) {
            case 'C1':
                if ($nilai >= 85) return 5; if ($nilai >= 70) return 4; if ($nilai >= 55) return 3; if ($nilai >= 40) return 2; return 1;
            case 'C2':
                if ($nilai >= 90) return 4; if ($nilai >= 75) return 3; if ($nilai >= 60) return 2; return 1;
            case 'C3':
                if ($nilai >= 90) return 4; if ($nilai >= 75) return 3; if ($nilai >= 60) return 2; return 1;
            case 'C4':
                if ($nilai >= 90) return 1; if ($nilai >= 70) return 2; return 3;
            default: return 0;
        }
    }
    /**
     * Menampilkan halaman detail penilaian untuk satu siswa.
     */
    public function show(Request $request, ProfilSiswa $profilSiswa)
    {
        // Ambil data penilaian siswa berdasarkan filter yang sama dari halaman sebelumnya
        $query = Assessment::where('profil_siswa_id', $profilSiswa->id)
                            ->with(['subject', 'kriteria']);

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $penilaianSiswa = $query->orderBy('tanggal', 'desc')->get();

        // Ambil nama mata pelajaran yang difilter (jika ada)
        $mapelTerfilter = $request->filled('subject_id') ? MataPelajaran::find($request->subject_id) : null;

        return view('guru.laporan.show', [
            'title' => 'Detail Laporan ' . $profilSiswa->nama_lengkap,
            'siswa' => $profilSiswa,
            'penilaian' => $penilaianSiswa,
            'mapelTerfilter' => $mapelTerfilter,
        ]);
    }

    /**
     * Membuat dan mengunduh laporan penilaian dalam bentuk PDF.
     */
     public function downloadPDF(Request $request, ProfilSiswa $profilSiswa)
    {
        // Ambil data mata pelajaran dari request atau dari penilaian pertama
        $mapelId = $request->input('subject_id');
        $subject = $mapelId ? MataPelajaran::find($mapelId) : null;

        // Ambil semua penilaian untuk siswa ini
        $query = Assessment::where('profil_siswa_id', $profilSiswa->id)
                            ->with('kriteria', 'subject');
        
        // Terapkan filter jika ada
        if ($mapelId) {
            $query->where('subject_id', $mapelId);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $penilaian = $query->orderBy('tanggal', 'desc')->get();
        
        // Ambil nama guru dari salah satu data penilaian (jika ada)
        // Ini asumsi, Anda mungkin perlu menyesuaikan cara mendapatkan nama guru
        $guru = $penilaian->first()->subject->users()->first()->name ?? 'N/A';

        // Siapkan data untuk dikirim ke view PDF
        $data = [
            'siswa' => $profilSiswa,
            'penilaian' => $penilaian,
            'subject' => $subject,
            'guru' => $guru
        ];

        // Buat PDF dari view 'pdf.laporan_siswa'
        $pdf = PDF::loadView('pdf.laporan_siswa', $data);

        // Tentukan nama file yang akan diunduh
        $fileName = 'Laporan - ' . $profilSiswa->nama_lengkap . '.pdf';

        // Unduh file PDF
        return $pdf->stream($fileName);
    }
}


