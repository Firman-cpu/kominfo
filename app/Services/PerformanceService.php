<?php

namespace App\Services;

use App\Models\PerformanceCategory;

class PerformanceService
{
    public function getCategory(float $score): string
    {
        $cat = PerformanceCategory::forScore($score);

        return $cat ? $cat->name : 'Perlu Evaluasi';
    }

    public function getCategoryDescription(float $score): string
    {
        $cat = PerformanceCategory::forScore($score);

        return $cat && $cat->description ? $cat->description : 'Performa siswa/mahasiswa membutuhkan evaluasi.';
    }

    public function getLevel(float $score): string
    {
        $cat = PerformanceCategory::forScore($score);

        return $cat ? $cat->level_key : 'evaluation';
    }
}
