<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Ini adalah bagian yang paling penting untuk diperbaiki.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profil_siswa_id',
        'subject_id',
        'kriteria_id', // Ini yang paling penting
        'aktivitas',
        'tanggal',
        'nilai_siswa',
        'poin',
        'nilai_mentah',
        'nilai_akhir',
        'materi_pembelajaran',
        'kedisiplinan',
        'indikator_c1',
        'indikator_c2',
        'indikator_c3',
        'indikator_c4',
        'nilai_c1',
        'nilai_c2',
        'nilai_c3',
        'nilai_c4',
        'total_poin',
        'feedback',
    ];

    /**
     * Relasi ke model ProfilSiswa
     */
    public function profilSiswa()
    {
        return $this->belongsTo(ProfilSiswa::class);
    }

    /**
     * Relasi ke model Subject (MataPelajaran)
     */
    public function subject()
    {
        return $this->belongsTo(MataPelajaran::class, 'subject_id');
    }

    /**
     * Relasi ke model Kriteria
     */
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}