<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $table = 'kriterias';

    /**
     * @var array<int, string>
     */
    protected $casts = [
        'bobot' => 'float',
    ];

    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'bobot',
        'jenis',
    ];

    public function kriteria()
    {
        return $this->hasMany(User::class, 'kriteria_id');
    }
}