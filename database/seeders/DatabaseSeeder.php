<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MataPelajaranSeeder;
use Database\Seeders\KriteriaSeeder;
use Database\Seeders\ProfilSiswaSeeder;
use Database\Seeders\PenilaianSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
        MataPelajaranSeeder::class,         // 1. Buat data mata pelajaran    
        KriteriaSeeder::class,      // 2. Buat data kriteria
        ProfilSiswaSeeder::class,   // 3. Buat data siswa
        PenilaianSeeder::class,     // 4. Baru buat data penilaian
        ]);
    }
}