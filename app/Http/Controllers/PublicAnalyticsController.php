<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Student;

class PublicAnalyticsController extends Controller
{
    public function index()
    {
        $totalStudents    = Student::count();
        $activeStudents   = Student::where('status', 'active')->count();
        $completedStudents = Student::where('status', 'completed')->count();
        $inactiveStudents = Student::where('status', 'inactive')->count();
        $totalAssessments = Assessment::count();

        $assessments = Assessment::with('student')->get();

        $average = $this->calculateAverage($assessments);

        $aspectAverages = $this->calculateAspectAverages($assessments);

        // Top 5 siswa berdasarkan rata-rata nilai
        $topStudents = Student::with('assessments')
            ->get()
            ->map(function (Student $student) {
                $avg = $this->calculateAverage($student->assessments);
                return [
                    'id'      => $student->id,
                    'name'    => $student->name,
                    'major'   => $student->major,
                    'class'   => $student->class,
                    'status'  => $student->status,
                    'average' => $avg,
                    'count'   => $student->assessments->count(),
                ];
            })
            ->filter(fn ($s) => $s['count'] > 0)
            ->sortByDesc('average')
            ->take(5)
            ->values();

        $chartData = [
            'labels' => [
                'Kedisiplinan',
                'Tanggung Jawab',
                'Kerja Sama',
                'Komunikasi',
                'Inisiatif',
                'Kualitas Kerja',
            ],
            'values' => [
                $aspectAverages['discipline'],
                $aspectAverages['responsibility'],
                $aspectAverages['teamwork'],
                $aspectAverages['communication'],
                $aspectAverages['initiative'],
                $aspectAverages['work_quality'],
            ],
        ];

        return view('public.analytics', [
            'totalStudents'     => $totalStudents,
            'activeStudents'    => $activeStudents,
            'completedStudents' => $completedStudents,
            'inactiveStudents'  => $inactiveStudents,
            'totalAssessments'  => $totalAssessments,
            'average'           => $average,
            'aspectAverages'    => $aspectAverages,
            'topStudents'       => $topStudents,
            'chartData'         => $chartData,
        ]);
    }

    private function calculateAverage($assessments): float
    {
        if ($assessments->isEmpty()) {
            return 0;
        }

        $total = 0;
        $count = 0;

        foreach ($assessments as $a) {
            $total += $a->discipline + $a->responsibility + $a->teamwork
                    + $a->communication + $a->initiative + $a->work_quality;
            $count += 6;
        }

        return round($total / $count, 1);
    }

    private function calculateAspectAverages($assessments): array
    {
        return [
            'discipline'     => round($assessments->avg('discipline')     ?? 0, 1),
            'responsibility' => round($assessments->avg('responsibility') ?? 0, 1),
            'teamwork'       => round($assessments->avg('teamwork')       ?? 0, 1),
            'communication'  => round($assessments->avg('communication')  ?? 0, 1),
            'initiative'     => round($assessments->avg('initiative')     ?? 0, 1),
            'work_quality'   => round($assessments->avg('work_quality')   ?? 0, 1),
        ];
    }
}
