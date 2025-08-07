<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = [
            ['name' => 'Indah', 'email' => 'indah@hz.com'],
            ['name' => 'Kartika', 'email' => 'kartika@hz.com'],
            ['name' => 'Reszki', 'email' => 'reszki@hz.com'],
            ['name' => 'Putri', 'email' => 'putri@hz.com'],
            ['name' => 'Rina', 'email' => 'rina@hz.com'],
            ['name' => 'Yana', 'email' => 'yana@hz.com'],
        ];

        foreach ($gurus as $guru) {
            User::create([
                'name' => $guru['name'],
                'email' => $guru['email'],
                'password' => Hash::make('pass'),
                'role' => 'guru',
            ]);
        }
    }
}
