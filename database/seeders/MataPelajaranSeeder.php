<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;   

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $mapels = [
            'Bahasa Inggris',
            'Calistung',
            'Art / Kesenian',
            'Matematika',
            'Mandarin',
            'Gucheng',
        ];

        foreach ($mapels as $mapel) {
            MataPelajaran::create(['nama_mapel' => $mapel]);
        }
    }
}
