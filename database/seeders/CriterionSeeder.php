<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Criterion;

class CriterionSeeder extends Seeder
{
    public function run(): void
    {
        $criteria = [
            ['code' => 'C1', 'name' => 'Partisipasi Akademik', 'weight' => 0.40, 'type' => 'benefit'],
            ['code' => 'C2', 'name' => 'Kedisiplinan', 'weight' => 0.20, 'type' => 'benefit'],
            ['code' => 'C3', 'name' => 'Etika dan Perilaku', 'weight' => 0.15, 'type' => 'benefit'],
            ['code' => 'C4', 'name' => 'Jumlah tugas yang tidak dikerjakan', 'weight' => 0.25, 'type' => 'Cost'],
        ];

        foreach ($criteria as $criterion) {
            Criterion::create($criterion);
        }
    }
}