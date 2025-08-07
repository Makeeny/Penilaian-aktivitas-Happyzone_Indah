<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Akun Admin
        User::create([
            'name' => 'Admin Utama', 
            'email' => 'admin@happyzone.com', 'role' => 'admin',
            'password' => Hash::make('admin1'), 'email_verified_at' => now(),
        ]);

        // 6 Akun Guru
        $teachers = [
            ['name' => 'Indah', 'email' => 'indah@happyzone.com'],
            ['name' => 'Kartika', 'email' => 'kartika@happyzone.com'],
            ['name' => 'Reszki', 'email' => 'rezski@happyzone.com'],
            ['name' => 'Putri', 'email' => 'putri@happyzone.com'],
            ['name' => 'Rina', 'email' => 'rina@happyzone.com'],
            ['name' => 'Yana', 'email' => 'yana@happyzone.com'],
        ];
        foreach ($teachers as $teacher) {
            User::create([
                'name' => $teacher['name'], 'email' => $teacher['email'], 'role' => 'guru',
                'password' => Hash::make('password'), 'email_verified_at' => now(),
            ]);
        }

        // 40 Akun Siswa
        $students = [
            'Marc', 'Latisya', 'Miki', 'Citta', 'Brian', 'Abigail', 'Matthew', 'Lalita', 'Clarissa', 'Derick',
            'Cio', 'Zein', 'Xuan-Xuan', 'Malika', 'Naufal', 'Reyno', 'Dave', 'Morgan', 'Chelsea', 'Ellif',
            'Sultan', 'Gibran', 'Aurel', 'Syaqilla', 'Fathir', 'Lexa', 'Atharizz', 'Verline', 'Celia', 'Marvin',
            'Agatha', 'Zaza', 'Afifah', 'Perly', 'Kenrich', 'Marvel', 'Hans', 'Renata', 'Jessica', 'Rico'
        ];
        foreach ($students as $student) {
            User::create([
                'name' => $student,
                'email' => strtolower($student) . '@happyzone.com', // Membuat email unik
                'role' => 'siswa',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }
    }
}