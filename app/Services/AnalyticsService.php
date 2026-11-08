<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\Department;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public function getDashboardStats(): array
    {
        $totalStudents = Student::count();
        $totalPrakerin = Student::where('type', 'prakerin')->count();
        $totalMagang = Student::where('type', 'magang')->count();
        $activeStudents = Student::where('status', 'active')->count();
        $completedStudents = Student::where('status', 'completed')->count();
        $totalAssessed = Assessment::count();

        // Rata-rata nilai keseluruhan
        $overallAvg = DB::table('assessment_scores')->avg('score');
        $overallAvg = $overallAvg ? round($overallAvg, 1) : 0;

        // Distribusi per bidang
        $departments = Department::withCount([
            'students',
            'students as active_count' => fn ($q) => $q->where('status', 'active'),
            'students as completed_count' => fn ($q) => $q->where('status', 'completed'),
        ])->get();

        // Siswa yang akan selesai dalam waktu dekat (7 hari ke depan)
        $endingSoon = Student::where('status', 'active')
            ->whereNotNull('end_date')
            ->whereBetween('end_date', [now()->startOfDay(), now()->addDays(7)->endOfDay()])
            ->orderBy('end_date')
            ->get();

        // Peserta terbaru
        $recentStudents = Student::with('department')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return [
            'totalStudents' => $totalStudents,
            'totalPrakerin' => $totalPrakerin,
            'totalMagang' => $totalMagang,
            'activeStudents' => $activeStudents,
            'completedStudents' => $completedStudents,
            'totalAssessed' => $totalAssessed,
            'overallAvg' => $overallAvg,
            'departments' => $departments,
            'endingSoon' => $endingSoon,
            'recentStudents' => $recentStudents,
        ];
    }

    public function getAnalyticsData(?int $year = null, ?int $departmentId = null): array
    {
        $query = Student::query();

        if ($year) {
            $query->whereYear('start_date', $year);
        }
        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        $totalCount = (clone $query)->count();
        $activeCount = (clone $query)->where('status', 'active')->count();
        $completedCount = (clone $query)->where('status', 'completed')->count();

        // Distribusi bidang
        $byDept = Department::withCount(['students' => function ($q) use ($year) {
            if ($year) {
                $q->whereYear('start_date', $year);
            }
        }])->get();

        // Daftar tahun yang ada untuk dropdown filter
        $availableYears = Student::getAvailableYears();

        return [
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'completedCount' => $completedCount,
            'byDept' => $byDept,
            'availableYears' => $availableYears,
        ];
    }
}
