<?php

namespace App\Http\Controllers;

use App\Models\Student;

class PublicStudentController extends Controller
{
    public function index()
    {
        $students = Student::query()
            ->orderBy('name')
            ->paginate(12);

        return view('students.index', [
            'students' => $students,
        ]);
    }

    public function show(Student $student)
    {
        return view('students.show', [
            'student' => $student,
        ]);
    }
}