<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProfilSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfilSiswaSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama untuk menghindari duplikat
        DB::table('profil_siswas')->delete();
        DB::table('users')->where('role', 'siswa')->delete();

        $siswaData = [
            'Citta Kirana', 'Abigail', 'Latisya', 'Marc', 'Lalita', 'Clarissa',
            'Matthew', 'Reyno', 'Zein', 'Derick', 'Evelyn', 'Cio', 'Dave','Marvin','Morgan',
            'Verline', 'Celia','Aurel','Rico','Xuan-xuan','Agatha','Ellif','Syaqilla','Fathir',
            'Lexa','Atharizz','Zaza','Afifah','Gibran','Sultan','Miki','Chelsea','Grace','Marvel','Hans','Kenrich','Jessica','Perly','Renata','Naufal',
        ];

        foreach ($siswaData as $nama) {
            // Buat record di tabel 'users' terlebih dahulu
            $user = User::create([
                'name' => $nama,
                'email' => strtolower(str_replace(' ', '', $nama)) . '@happyzone.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]);

            // Buat record di tabel 'profil_siswas' yang terhubung dengan user
            ProfilSiswa::create([
                'user_id' => $user->id,
                'nama_lengkap' => $nama,
                // Tambahkan field lain yang wajib diisi jika ada, contoh:
                // 'nisn' => '123456789',
                // 'kelas' => '10A',
            ]);
        }
    }
}