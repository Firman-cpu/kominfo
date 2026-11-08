<?php

namespace Database\Seeders;

use App\Models\PerformanceCategory;
use Illuminate\Database\Seeder;

class PerformanceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sangat Baik',
                'level_key' => 'excellent',
                'min_score' => 90.00,
                'description' => 'Performa siswa/mahasiswa sangat baik dan memuaskan.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Baik',
                'level_key' => 'good',
                'min_score' => 80.00,
                'description' => 'Performa siswa/mahasiswa baik dan konsisten.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Cukup',
                'level_key' => 'average',
                'min_score' => 70.00,
                'description' => 'Performa siswa/mahasiswa cukup dan masih dapat ditingkatkan.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Perlu Perhatian',
                'level_key' => 'attention',
                'min_score' => 60.00,
                'description' => 'Performa siswa/mahasiswa membutuhkan perhatian.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Perlu Evaluasi',
                'level_key' => 'evaluation',
                'min_score' => 0.00,
                'description' => 'Performa siswa/mahasiswa membutuhkan evaluasi lebih lanjut.',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $cat) {
            PerformanceCategory::updateOrCreate(
                ['level_key' => $cat['level_key']],
                $cat
            );
        }
    }
}
