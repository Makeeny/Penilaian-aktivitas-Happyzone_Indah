<?php

namespace App\Http\Controllers\Guru;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Kriteria;
use App\Models\MataPelajaran;
use App\Models\ProfilSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahkan ini di atas class

class PenilaianController extends Controller
{
    public function index(Request $request, MataPelajaran $mapel = null)
    {
        $listMapel = MataPelajaran::orderBy('nama_mapel')->get();

        // NOTE: Inisialisasi data sebagai kosong. Data hanya akan diisi jika filter diterapkan.
        $penilaian = collect(); // Default: data penilaian kosong
        $mapelAktif = null;

        // NOTE: Logika utama sekarang ada di dalam blok IF ini.
        // Kode hanya berjalan jika ada input 'subject_id' dari form filter.
        if ($request->filled('subject_id')) {
        
            $mapelAktif = $listMapel->find($request->subject_id);

            if ($mapelAktif) {
                $query = Assessment::where('subject_id', $mapelAktif->id)->with('profilSiswa.user');

                if ($request->filled('tanggal')) {
                    $query->whereDate('tanggal', $request->tanggal);
                }

                $penilaian = $query->latest()->get();

                // Menghitung rata-rata dan poin untuk setiap data
                $penilaian->each(function ($item) {
                    $rataRata = ($item->nilai_c1 + $item->nilai_c2 + $item->nilai_c3 + $item->nilai_c4) / 4;
                    $item->rata_rata_nilai = round($rataRata);
                    $item->poin_bulat = round($item->total_poin);
                });
            }
        }
        foreach ($penilaian as $item) {
            // Menjumlahkan nilai dari C1, C2, C3, dan C4 lalu dibagi 4
            $rataRata = ($item->nilai_c1 + $item->nilai_c2 + $item->nilai_c3 + $item->nilai_c4) / 4;
            $item->rata_rata_nilai = round($rataRata); // Dibulatkan tanpa desimal

            // Mengambil total poin dan membulatkannya
            $item->poin_bulat = round($item->total_poin);
        }

        // Jika ingin mengelompokkan penilaian berdasarkan siswa, tanggal, dan aktivitas:
        // Pastikan $penilaian sudah terisi (bukan $allAssessments yang tidak didefinisikan)
        $penilaianUnik = $penilaian->unique(function ($item) {
            return $item->profil_siswa_id . $item->tanggal . $item->aktivitas;
        });

        // NOTE: Menggabungkan 4 baris data penilaian menjadi 1 baris per siswa
        $penilaianTergabung = $penilaianUnik->groupBy('profil_siswa_id')->map(function ($penilaianSiswa) {
            $dataGabungan = [
                'siswa' => $penilaianSiswa->first()->profilSiswa,
                'tanggal' => $penilaianSiswa->first()->tanggal,
                'penilaian_kriteria' => []
            ];
            foreach ($penilaianSiswa as $penilaian) {
                $dataGabungan['penilaian_kriteria'][] = $penilaian;
            }
            return (object) $dataGabungan;
        });

        $listMapel = \App\Models\MataPelajaran::all();

        return view('guru.penilaian.index', [
            'title' => 'Form Nilai Siswa',
            'penilaian' => $penilaianUnik,
            'mapelAktif' => $mapel,
            'listMapel' => $listMapel,
            'listMapelForSidebar' => $listMapel
        ]);
}
/**
 * REVISI: Menampilkan form untuk menambah penilaian baru.
 * Sekarang mengambil semua data yang dibutuhkan untuk dropdown.
 */
public function create(MataPelajaran $mapel)
{ 
        // 2. Mengambil data lain yang dibutuhkan untuk form
        $siswas = ProfilSiswa::orderBy('nama_lengkap')->get();
        $kriterias = Kriteria::all();
        
        // 3. (INI YANG DITAMBAHKAN) Mengambil DAFTAR SEMUA mapel untuk dropdown
        $mapels = MataPelajaran::orderBy('nama_mapel')->get();

        // 4. Kirim semua data yang dibutuhkan ke view
        return view('guru.penilaian.create', [
            'title'     => 'Penilaian Aktivitas Belajar Siswa',
            'siswas'    => $siswas,
            'mapel'     => $mapel,        // Variabel untuk SATU mapel aktif
            'mapels'    => $mapels,       // Variabel untuk DAFTAR SEMUA mapel
            'kriterias' => $kriterias
        ]);
    }

    /**
     * REVISI: Menyimpan data penilaian baru ke database dengan perhitungan SAW.
     */
    public function storeBulk(Request $request)
{
   // NOTE: Validasi disesuaikan dengan input baru
    $request->validate([
        'profil_siswa_id' => 'required|exists:profil_siswas,id',
        'subject_id' => 'required|exists:mata_pelajaran,id',
        'tanggal' => 'required|date',
        'indikator.C1' => 'required|string',
        'indikator.C2' => 'required|string',
        'indikator.C3' => 'required|string',
        'indikator.C4' => 'required|string',
        'nilai.C1' => 'required|numeric|min:0|max:100',
        'nilai.C2' => 'required|numeric|min:0|max:100',
        'nilai.C3' => 'required|numeric|min:0|max:100',
        'nilai.C4' => 'required|numeric|min:0|max:100',
        'total_poin' => 'required|numeric',
    ]);

    // NOTE: Menyimpan data ke dalam SATU BARIS
    Assessment::create([
        'profil_siswa_id' => $request->profil_siswa_id,
        'subject_id' => $request->subject_id,
        'aktivitas' => $request->materi_pembelajaran,
        'tanggal' => $request->tanggal,
        'indikator_c1' => $request->indikator['C1'],
        'indikator_c2' => $request->indikator['C2'],
        'indikator_c3' => $request->indikator['C3'],
        'indikator_c4' => $request->indikator['C4'],
        'nilai_c1' => $request->nilai['C1'],
        'nilai_c2' => $request->nilai['C2'],
        'nilai_c3' => $request->nilai['C3'],
        'nilai_c4' => $request->nilai['C4'],
        'total_poin' => $request->total_poin,
        'feedback' => $request->feedback,
    ]);

    return redirect()->route('guru.penilaian.index', ['mapel' => $request->subject_id])
                     ->with('success', 'Penilaian berhasil disimpan.');
}

    public function searchSiswa(Request $request)
    {
        $search = $request->term;

        $siswas = ProfilSiswa::where('nama_lengkap', 'LIKE', '%' . $search . '%')
                              ->limit(10) // Batasi hasil agar tidak terlalu banyak
                              ->get(['id', 'nama_lengkap as text']); // Format untuk Select2

        return response()->json($siswas);
    }

    public function edit(Assessment $assessment)
    {
        // Mengambil semua data yang diperlukan untuk dropdown di form
        $siswas = ProfilSiswa::orderBy('nama_lengkap')->get();
        $mapels = MataPelajaran::all();
        $kriterias = Kriteria::all();
        
        return view('guru.penilaian.edit', [
            'title' => 'Edit Penilaian',
            'assessment' => $assessment, // Data penilaian yang akan diedit
            'siswas' => $siswas,
            'mapels' => $mapels,
            'kriterias' => $kriterias,
        ]);
    }

    // ==========================================================
    // == METHOD BARU 2: Memproses Update Data ==
    // ==========================================================
    public function update(Request $request, Assessment $assessment)
    {
        // NOTE: Aturan validasi disesuaikan dengan input 'nilai_mentah' yang berbentuk array.
    $validated = $request->validate([
        'materi_pembelajaran' => 'required|string|max:255',
        'nilai_mentah' => 'required|array',
        'nilai_mentah.*' => 'required|numeric|min:0|max:100', // Memvalidasi setiap nilai di dalam array
        'feedback' => 'nullable|string',
    ]);

    // NOTE: Ambil semua data kriteria untuk mapping ID ke kode dan menghitung ulang poin.
    $kriterias = Kriteria::all()->keyBy('id');
    
    // NOTE: Siapkan data awal untuk diupdate.
    $updateData = [
        'aktivitas' => $validated['materi_pembelajaran'],
        'feedback' => $request->input('feedback'),
    ];
    
    $totalPoin = 0;
    // NOTE: Loop melalui array nilai_mentah yang dikirim dari form.
    foreach($validated['nilai_mentah'] as $kriteriaId => $nilai) {
        // Ambil kode kriteria (C1, C2, dst) berdasarkan ID-nya.
        $kodeKriteria = strtolower($kriterias[$kriteriaId]->kode_kriteria); // Hasilnya misal: 'c1'
        
        // Masukkan nilai ke dalam kolom yang sesuai (nilai_c1, nilai_c2, dst).
        $updateData['nilai_' . $kodeKriteria] = $nilai;
        
        // Hitung poin untuk kriteria ini dan tambahkan ke total.
        $totalPoin += $nilai * $kriterias[$kriteriaId]->bobot;
    }
    // Masukkan total poin yang sudah dihitung ulang.
    $updateData['total_poin'] = $totalPoin;

    // NOTE: Lakukan update pada satu baris data assessment.
    $assessment->update($updateData);

    // NOTE: Kembali ke halaman daftar penilaian dengan pesan sukses.
    return redirect()->route('guru.penilaian.index', [
        'subject_id' => $assessment->subject_id, 
        'tanggal' => $assessment->tanggal
    ])->with('success', 'Penilaian berhasil diperbarui!');
}

    // ===============================================================
    // == METHOD BARU 3: Menghapus Data ==
    // ==========================================================
    public function destroy(Assessment $assessment)
    {
        $subjectId = $assessment->subject_id; // Simpan subject_id sebelum dihapus
        $assessment->delete();

        // Kembali ke halaman daftar penilaian dengan pesan sukses
        return redirect()->route('guru.penilaian.index', $subjectId)
                         ->with('success', 'Data penilaian berhasil dihapus.');
    }
}