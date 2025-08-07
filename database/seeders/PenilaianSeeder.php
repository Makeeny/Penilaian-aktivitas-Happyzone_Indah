<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfilSiswa;
use App\Models\Kriteria;
use App\Models\Assessment;
use Illuminate\Support\Facades\DB;

class PenilaianSeeder extends Seeder
{
    public function run()
    {
        // Ambil data siswa dan kriteria yang sudah dibuat seeder sebelumnya
        $semuaSiswa = ProfilSiswa::all()->keyBy('nama_lengkap');
        $semuaKriteria = Kriteria::all()->keyBy('kode_kriteria');
        $subjectId = 3; // ID untuk "Bahasa Inggris"
        $tanggalPenilaian = '2025-07-31';

        // Data penilaian dari dokumen "contoh perhitungan.docx"
        $dataPenilaian = [
            ['nama' => 'Citta Kirana', 'nilai' => [80, 78, 80, 95], 'indikator' => ['Aktif', 'Disiplin', 'Baik', '≤ 5 Tugas']],
            ['nama' => 'Abigail', 'nilai' => [90, 95, 95, 100], 'indikator' => ['Sangat Aktif', 'Sangat Disiplin', 'Sangat baik', '≤ 5 Tugas']],
            ['nama' => 'Latisya', 'nilai' => [75, 92, 93, 98], 'indikator' => ['Aktif', 'Sangat Disiplin', 'Sangat baik', '≤ 5 Tugas']],
            // ... (Tambahkan 10 siswa lainnya jika perlu)
        ];

        foreach ($dataPenilaian as $data) {
            $siswa = $semuaSiswa[$data['nama']] ?? null;
            if (!$siswa) continue;

            // Hitung total poin
            $totalPoin =
                ($data['nilai'][0] * $semuaKriteria['C1']->bobot) +
                ($data['nilai'][1] * $semuaKriteria['C2']->bobot) +
                ($data['nilai'][2] * $semuaKriteria['C3']->bobot) +
                ($data['nilai'][3] * $semuaKriteria['C4']->bobot);

            // Buat SATU baris data penilaian
            Assessment::create([
                'profil_siswa_id' => $siswa->id,
                'subject_id' => $subjectId,
                'aktivitas' => 'Penilaian Awal Semester (Seeder)',
                'tanggal' => $tanggalPenilaian,
                'indikator_c1' => $data['indikator'][0],
                'indikator_c2' => $data['indikator'][1],
                'indikator_c3' => $data['indikator'][2],
                'indikator_c4' => $data['indikator'][3],
                'nilai_c1' => $data['nilai'][0],
                'nilai_c2' => $data['nilai'][1],
                'nilai_c3' => $data['nilai'][2],
                'nilai_c4' => $data['nilai'][3],
                'total_poin' => $totalPoin,
                'feedback' => 'Data dibuat secara otomatis.',
            ]);
        }
    }
}