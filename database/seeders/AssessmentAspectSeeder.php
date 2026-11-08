<?php

namespace Database\Seeders;

use App\Models\AssessmentAspect;
use Illuminate\Database\Seeder;

class AssessmentAspectSeeder extends Seeder
{
    public function run(): void
    {
        $aspects = [
            ['name' => 'Kedisiplinan', 'key' => 'discipline', 'sort_order' => 1, 'is_active' => true],
            ['name' => 'Tanggung Jawab', 'key' => 'responsibility', 'sort_order' => 2, 'is_active' => true],
            ['name' => 'Kerja Sama', 'key' => 'teamwork', 'sort_order' => 3, 'is_active' => true],
            ['name' => 'Komunikasi', 'key' => 'communication', 'sort_order' => 4, 'is_active' => true],
            ['name' => 'Inisiatif', 'key' => 'initiative', 'sort_order' => 5, 'is_active' => true],
            ['name' => 'Kualitas Kerja', 'key' => 'work_quality', 'sort_order' => 6, 'is_active' => true],
        ];

        foreach ($aspects as $aspect) {
            AssessmentAspect::updateOrCreate(
                ['key' => $aspect['key']],
                $aspect
            );
        }
    }
}
