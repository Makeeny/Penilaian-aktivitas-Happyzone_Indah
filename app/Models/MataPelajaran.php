<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;
    protected $table = 'subjects'; // Pastikan nama tabel sesuai dengan yang ada di database
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_mapel',
    ];

      public function users()
    {
        return $this->hasMany(User::class, 'subject_id');
    }
}