<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Student;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::with('student')
            ->latest('assessment_date')
            ->get();

        return view('admin.assessments.index', [
            'assessments' => $assessments,
        ]);
    }

    public function create()
    {
        $students = Student::orderBy('name')->get();

        return view('admin.assessments.create', [
            'students' => $students,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'assessment_date' => ['required', 'date'],

            'discipline' => ['required', 'integer', 'min:0', 'max:100'],
            'responsibility' => ['required', 'integer', 'min:0', 'max:100'],
            'teamwork' => ['required', 'integer', 'min:0', 'max:100'],
            'communication' => ['required', 'integer', 'min:0', 'max:100'],
            'initiative' => ['required', 'integer', 'min:0', 'max:100'],
            'work_quality' => ['required', 'integer', 'min:0', 'max:100'],

            'notes' => ['nullable', 'string'],
        ]);

        Assessment::create($validated);

        return redirect()
            ->route('admin.assessments.index')
            ->with('success', 'Penilaian berhasil ditambahkan.');
    }

    public function edit(Assessment $assessment)
    {
        $students = Student::orderBy('name')->get();

        return view('admin.assessments.edit', [
            'assessment' => $assessment,
            'students' => $students,
        ]);
    }

    public function update(Request $request, Assessment $assessment)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'assessment_date' => ['required', 'date'],

            'discipline' => ['required', 'integer', 'min:0', 'max:100'],
            'responsibility' => ['required', 'integer', 'min:0', 'max:100'],
            'teamwork' => ['required', 'integer', 'min:0', 'max:100'],
            'communication' => ['required', 'integer', 'min:0', 'max:100'],
            'initiative' => ['required', 'integer', 'min:0', 'max:100'],
            'work_quality' => ['required', 'integer', 'min:0', 'max:100'],

            'notes' => ['nullable', 'string'],
        ]);

        $assessment->update($validated);

        return redirect()
            ->route('admin.assessments.index')
            ->with('success', 'Penilaian berhasil diperbarui.');
    }

    public function destroy(Assessment $assessment)
    {
        $assessment->delete();

        return redirect()
            ->route('admin.assessments.index')
            ->with('success', 'Penilaian berhasil dihapus.');
    }
}