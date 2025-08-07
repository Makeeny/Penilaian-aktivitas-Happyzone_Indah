<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    /**
     * ==========================================================
     * == PERBAIKAN UTAMA ADA DI SINI ==
     * ==========================================================
     * Mendefinisikan nama tabel secara eksplisit.
     * Ini memaksa Laravel untuk menggunakan tabel bernama 'feedbacks'.
     *
     * @var string
     */
    protected $table = 'feedbacks';

    /**
     * Properti ini memberikan "izin" pada kolom-kolom ini
     * untuk diisi saat menggunakan metode create().
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_orang_tua',
        'nama_siswa',
        'pesan',
        'is_tampil',
    ];
}