<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Student;
use App\Services\PerformanceService;

class AnalyticsController extends Controller
{
    public function __construct(
        private PerformanceService $performanceService
    ) {
    }

    public function index()
    {
        $assessments = Assessment::query()
            ->with('student')
            ->get();

        $totalAssessments = $assessments->count();

        $totalStudents = Student::count();

        $average = $this->calculateAverage($assessments);

        $aspectAverages = $this->calculateAspectAverages(
            $assessments
        );

        $studentPerformance = Student::query()
            ->with('assessments')
            ->get()
            ->map(function (Student $student) {
                $average = $this->calculateAverage(
                    $student->assessments
                );

                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'nis' => $student->nis,
                    'average' => $average,
                    'category' => $this->performanceService
                        ->getCategory($average),
                    'level' => $this->performanceService
                        ->getLevel($average),
                    'assessment_count' => $student
                        ->assessments
                        ->count(),
                ];
            })
            ->sortByDesc('average')
            ->values();

        $ranking = $studentPerformance
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

        return view('admin.analytics.index', [
            'totalStudents' => $totalStudents,
            'totalAssessments' => $totalAssessments,
            'average' => $average,

            'category' => $this->performanceService
                ->getCategory($average),

            'level' => $this->performanceService
                ->getLevel($average),

            'aspectAverages' => $aspectAverages,

            'studentPerformance' => $studentPerformance,

            'ranking' => $ranking,

            'chartData' => $chartData,
        ]);
    }

    public function student(Student $student)
    {
        $assessments = $student->assessments()
            ->orderBy('assessment_date')
            ->get();

        $average = $this->calculateAverage(
            $assessments
        );

        $aspectAverages = $this->calculateAspectAverages(
            $assessments
        );

        $strongestAspect = $this->performanceService
            ->getStrongestAspect($aspectAverages);

        $weakestAspect = $this->performanceService
            ->getWeakestAspect($aspectAverages);

        /*
        |--------------------------------------------------------------------------
        | Performance History
        |--------------------------------------------------------------------------
        */

        $history = $assessments->map(
            function (Assessment $assessment) {
                return [
                    'date' => $assessment
                        ->assessment_date
                        ->format('d M Y'),

                    'average' => round(
                        (
                            $assessment->discipline +
                            $assessment->responsibility +
                            $assessment->teamwork +
                            $assessment->communication +
                            $assessment->initiative +
                            $assessment->work_quality
                        ) / 6,
                        2
                    ),
                ];
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Personal Chart Data
        |--------------------------------------------------------------------------
        */

        $personalChartData = [
            'labels' => $history
                ->pluck('date')
                ->values()
                ->all(),

            'values' => $history
                ->pluck('average')
                ->values()
                ->all(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Radar Chart Data
        |--------------------------------------------------------------------------
        */

        $radarChartData = [
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

        return view('admin.analytics.student', [
            'student' => $student,
            'assessments' => $assessments,

            'average' => $average,

            'category' => $this->performanceService
                ->getCategory($average),

            'level' => $this->performanceService
                ->getLevel($average),

            'description' => $this->performanceService
                ->getCategoryDescription($average),

            'aspectAverages' => $aspectAverages,

            'strongestAspect' => $strongestAspect,
            'weakestAspect' => $weakestAspect,

            'history' => $history,

            'personalChartData' => $personalChartData,

            'radarChartData' => $radarChartData,
        ]);
    }

    private function calculateAverage($assessments): float
    {
        if ($assessments->isEmpty()) {
            return 0;
        }

        $total = 0;
        $count = 0;

        foreach ($assessments as $assessment) {
            $total +=
                $assessment->discipline +
                $assessment->responsibility +
                $assessment->teamwork +
                $assessment->communication +
                $assessment->initiative +
                $assessment->work_quality;

            $count += 6;
        }

        return round($total / $count, 2);
    }

    private function calculateAspectAverages($assessments): array
    {
        return [
            'discipline' => round(
                $assessments->avg('discipline') ?? 0,
                2
            ),

            'responsibility' => round(
                $assessments->avg('responsibility') ?? 0,
                2
            ),

            'teamwork' => round(
                $assessments->avg('teamwork') ?? 0,
                2
            ),

            'communication' => round(
                $assessments->avg('communication') ?? 0,
                2
            ),

            'initiative' => round(
                $assessments->avg('initiative') ?? 0,
                2
            ),

            'work_quality' => round(
                $assessments->avg('work_quality') ?? 0,
                2
            ),
        ];
    }
}