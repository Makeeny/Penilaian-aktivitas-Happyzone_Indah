<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'alamat',
        'no_telepon_ortu',
    ];

    // Ini adalah relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}