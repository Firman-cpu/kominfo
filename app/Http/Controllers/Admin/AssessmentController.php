<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssessmentRequest;
use App\Models\Assessment;
use App\Models\AssessmentAspect;
use App\Models\AssessmentScore;
use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Assessment::with(['student.department', 'scores.aspect'])->orderByDesc('id');

        // Pencarian (Nama siswa, NIS/NIM, Sekolah/Kampus)
        if ($search = $request->input('search')) {
            $query->whereHas('student', function ($sq) use ($search) {
                $sq->where('name', 'like', "%{$search}%")
                   ->orWhere('identity_number', 'like', "%{$search}%")
                   ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        // Filter Tahun
        if ($year = $request->input('year')) {
            $query->whereHas('student', function ($sq) use ($year) {
                $sq->whereYear('start_date', $year);
            });
        }

        // Filter Tipe (Prakerin / Magang)
        if ($type = $request->input('type')) {
            $query->whereHas('student', function ($sq) use ($type) {
                $sq->where('type', $type);
            });
        }

        // Filter Bidang
        if ($departmentId = $request->input('department_id')) {
            $query->whereHas('student', function ($sq) use ($departmentId) {
                $sq->where('department_id', $departmentId);
            });
        }

        $assessments = $query->paginate(15)->withQueryString();
        $departments = Department::orderBy('sort_order')->get();
        $availableYears = Student::getAvailableYears();

        return view('admin.assessments.index', compact('assessments', 'departments', 'availableYears'));
    }

    public function create(Request $request)
    {
        // Hanya siswa/mahasiswa yang BELUM memiliki nilai yang dapat dipilih
        $unassessedStudents = Student::with('department')
            ->whereDoesntHave('assessment')
            ->orderBy('name')
            ->get();

        $aspects = AssessmentAspect::where('is_active', true)->orderBy('sort_order')->get();

        $preselectedStudentId = $request->query('student_id');

        return view('admin.assessments.create', compact('unassessedStudents', 'aspects', 'preselectedStudentId'));
    }

    public function store(AssessmentRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $assessment = Assessment::create([
                'student_id' => $data['student_id'],
                'assessment_date' => $data['assessment_date'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['scores'] as $aspectId => $score) {
                AssessmentScore::create([
                    'assessment_id' => $assessment->id,
                    'aspect_id' => $aspectId,
                    'score' => (int) $score,
                ]);
            }
        });

        $student = Student::find($data['student_id']);

        return redirect()
            ->route('admin.assessments.index')
            ->with('success', "Penilaian untuk {$student->name} berhasil disimpan.");
    }

    public function show(Assessment $assessment)
    {
        $assessment->load(['student.department', 'scores.aspect']);
        return view('admin.assessments.show', compact('assessment'));
    }

    public function edit(Assessment $assessment)
    {
        $assessment->load(['student.department', 'scores']);
        $aspects = AssessmentAspect::where('is_active', true)->orderBy('sort_order')->get();

        $existingScores = $assessment->scores->pluck('score', 'aspect_id')->toArray();

        return view('admin.assessments.edit', compact('assessment', 'aspects', 'existingScores'));
    }

    public function update(AssessmentRequest $request, Assessment $assessment)
    {
        $data = $request->validated();

        DB::transaction(function () use ($assessment, $data) {
            $assessment->update([
                'assessment_date' => $data['assessment_date'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['scores'] as $aspectId => $score) {
                AssessmentScore::updateOrCreate(
                    [
                        'assessment_id' => $assessment->id,
                        'aspect_id' => $aspectId,
                    ],
                    [
                        'score' => (int) $score,
                    ]
                );
            }
        });

        return redirect()
            ->route('admin.assessments.index')
            ->with('success', "Penilaian untuk {$assessment->student->name} berhasil diperbarui.");
    }

    public function destroy(Assessment $assessment)
    {
        $studentName = $assessment->student?->name ?? 'Peserta';
        $assessment->delete();

        return redirect()
            ->route('admin.assessments.index')
            ->with('success', "Data penilaian {$studentName} berhasil dihapus.");
    }
}