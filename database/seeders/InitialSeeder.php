<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfilSiswa;   
use Symfony\Component\HttpKernel\Profiler\Profile;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Users: 6 guru, 1 admin
        DB::table('users')->insert([
            ['name'=>'Indah','email'=>'indah@hz.com','password'=>Hash::make('pass'),'role'=>'guru'],
            ['name'=>'Kartika','email'=>'kartika@hz.com','password'=>Hash::make('pass'),'role'=>'guru'],
            ['name'=>'Reszki','email'=>'reszki@hz.com','password'=>Hash::make('pass'),'role'=>'guru'],
            ['name'=>'Putri','email'=>'putri@hz.com','password'=>Hash::make('pass'),'role'=>'guru'],
            ['name'=>'Rina','email'=>'rina@hz.com','password'=>Hash::make('pass'),'role'=>'guru'],
            ['name'=>'Yana','email'=>'yana@hz.com','password'=>Hash::make('pass'),'role'=>'guru'],
            ['name'=>'Admin','email'=>'admin@hz.com','password'=>Hash::make('pass'),'role'=>'admin'],
        ]);
        // 40 Siswa
        $siswa = [
            'marc','latisya','miki','citta','brian','abigail','matthew','lalita','clarissa','derick',
            'cio','zein','xuan-xuan','malika','naufal','reyno','dave','morgan','chelsea','ellif',
            'sultan','gibran','aurel','syaqilla','fathir','lexa','atharizz','verline','celia','marvin',
            'agatha','zaza','afifah','perly','kenrich','marvel','hans','renata','jessica','rico'
        ];

        foreach($siswa as $s) {
        $user = User::create([
            'name' => ucfirst($s),
            'email' => strtolower(str_replace(' ', '', $s)) . '@hzone.com',
            'password' => Hash::make('pass'),
            'role' => 'siswa',
    ]);

    ProfilSiswa::create([
      'nama' => ucfirst($s),
      'kelas' => 'X',
      'user_id' => $user->id,
    ]);
  }

        // Mapel
        $mapels = ['Bahasa Inggris','Calistung','Art / Kesenian','Matematika','Mandarin','Gucheng'];
        foreach($mapels as $mp) {
            DB::table('mapels')->insert(['nama' => $mp]);
        }

        // Kriteria SAW
        $kriteria = [
            ['nama' => 'Partisipasi Akademik', 'sifat' => 'benefit', 'bobot' => 40],
            ['nama' => 'Kedisiplinan', 'sifat' => 'benefit', 'bobot' => 20],
            ['nama' => 'Etika dan Perilaku', 'sifat' => 'benefit', 'bobot' => 15],
            ['nama' => 'Jumlah Tugas yang Tidak Dikerjakan', 'sifat' => 'cost', 'bobot' => 25],
        ];

        foreach(DB::table('mapels')->pluck('id') as $mapel_id){
            foreach($kriteria as $k){
                DB::table('kriterias')->insert(array_merge($k, ['mapel_id' => $mapel_id]));
            }
        }
    }
}
