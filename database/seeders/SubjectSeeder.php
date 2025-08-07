<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = ['Bahasa Inggris', 'Mandarin', 'Calistung', 'Matematika', 'Art / Kesenian', 'Gucheng'];
        foreach ($subjects as $subject) {
            Subject::create(['name' => $subject]);
        }
    }
}