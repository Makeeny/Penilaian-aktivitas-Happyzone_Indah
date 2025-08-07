<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kosongkan tabel kriteria terlebih dahulu
        DB::table('kriterias')->delete();

        // Data 4 kriteria
        $kriterias = [
            [
                'kode_kriteria' => 'C1',
                'nama_kriteria' => 'Partisipasi Akademik',
                'bobot' => 0.40,
                'jenis' => 'benefit',
            ],
            [
                'kode_kriteria' => 'C2',
                'nama_kriteria' => 'Kedisiplinan',
                'bobot' => 0.20,
                'jenis' => 'benefit',
            ],
            [
                'kode_kriteria' => 'C3',
                'nama_kriteria' => 'Etika Dan Perilaku',
                'bobot' => 0.15,
                'jenis' => 'benefit',
            ],
            [
                'kode_kriteria' => 'C4',
                'nama_kriteria' => 'Tugas Tdk Dikerjakan',
                'bobot' => 0.25,
                'jenis' => 'cost',
            ],
        ];

        // Masukkan data ke dalam tabel
        Kriteria::insert($kriterias);
    }
}