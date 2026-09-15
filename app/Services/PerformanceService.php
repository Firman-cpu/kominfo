<?php

namespace App\Services;

class PerformanceService
{
    public function getCategory(float $score): string
    {
        return match (true) {
            $score >= 90 => 'Sangat Baik',
            $score >= 80 => 'Baik',
            $score >= 70 => 'Cukup',
            $score >= 60 => 'Perlu Perhatian',
            default => 'Perlu Evaluasi',
        };
    }

    public function getCategoryDescription(float $score): string
    {
        return match (true) {
            $score >= 90 => 'Performa siswa sangat baik.',
            $score >= 80 => 'Performa siswa baik dan konsisten.',
            $score >= 70 => 'Performa siswa cukup dan masih dapat ditingkatkan.',
            $score >= 60 => 'Performa siswa membutuhkan perhatian.',
            default => 'Performa siswa membutuhkan evaluasi lebih lanjut.',
        };
    }

    public function getLevel(float $score): string
    {
        return match (true) {
            $score >= 90 => 'excellent',
            $score >= 80 => 'good',
            $score >= 70 => 'average',
            $score >= 60 => 'attention',
            default => 'evaluation',
        };
    }

    public function getStrongestAspect(array $aspects): ?array
    {
        if (empty($aspects)) {
            return null;
        }

        $key = array_key_first(
            array_filter(
                $aspects,
                fn ($value) => $value === max($aspects)
            )
        );

        if ($key === null) {
            return null;
        }

        return [
            'key' => $key,
            'label' => $this->getAspectLabel($key),
            'score' => $aspects[$key],
        ];
    }

    public function getWeakestAspect(array $aspects): ?array
    {
        if (empty($aspects)) {
            return null;
        }

        $key = array_key_first(
            array_filter(
                $aspects,
                fn ($value) => $value === min($aspects)
            )
        );

        if ($key === null) {
            return null;
        }

        return [
            'key' => $key,
            'label' => $this->getAspectLabel($key),
            'score' => $aspects[$key],
        ];
    }

    public function getAspectLabel(string $key): string
    {
        return match ($key) {
            'discipline' => 'Kedisiplinan',
            'responsibility' => 'Tanggung Jawab',
            'teamwork' => 'Kerja Sama',
            'communication' => 'Komunikasi',
            'initiative' => 'Inisiatif',
            'work_quality' => 'Kualitas Kerja',
            default => $key,
        };
    }
}