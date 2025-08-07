<?php

namespace App\Http\Controllers\Admin;

use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\ProfilSiswa;

class PenilaianController
{
    public function index($mapelId)
    {
        $kriterias = Kriteria::where('mapel_id',$mapelId)->get();
        $siswas = ProfilSiswa::all();

        // hitung normalisasi & scoring
        $maxValues = $kriterias->mapWithKeys(fn($k) => [$k->id => Penilaian::where('kriteria_id',$k->id)->max('nilai')]);

        $scores = [];
        foreach($siswas as $siswa){
            $total = 0;
            foreach($kriterias as $k){
                $nilai = Penilaian::where(['mapel_id' => $mapelId, 'siswa_id' => $siswa->id, 'kriteria_id' => $k->id])->value('nilai') ?? 0;
                $norm = $nilai / ($maxValues[$k->id] ?: 1);
                $total += $norm * ($k->bobot / 100);
            }
            $scores[$siswa->id] = $total;
        }

        return view('admin.penilaian.index', compact('siswas','kriterias','scores'));
    }
}
