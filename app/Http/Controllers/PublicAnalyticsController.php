<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentAspect;
use App\Models\Department;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class PublicAnalyticsController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $completedStudents = Student::where('status', 'completed')->count();
        $totalAssessments = Assessment::count();

        // Rata-rata keseluruhan
        $overallAvg = DB::table('assessment_scores')->avg('score');
        $average = $overallAvg ? round($overallAvg, 1) : 0;

        // Aspek rata-rata dinamis
        $aspects = AssessmentAspect::withAvg('scores', 'score')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $chartData = [
            'labels' => $aspects->pluck('name')->toArray(),
            'values' => $aspects->map(fn ($a) => round($a->scores_avg_score ?? 0, 1))->toArray(),
        ];

        // Distribusi per bidang
        $departments = Department::withCount([
            'students',
            'students as active_count' => fn ($q) => $q->where('status', 'active'),
            'students as completed_count' => fn ($q) => $q->where('status', 'completed'),
        ])->get();

        return view('public.analytics', [
            'totalStudents' => $totalStudents,
            'activeStudents' => $activeStudents,
            'completedStudents' => $completedStudents,
            'totalAssessments' => $totalAssessments,
            'average' => $average,
            'aspects' => $aspects,
            'chartData' => $chartData,
            'departments' => $departments,
        ]);
    }
}
