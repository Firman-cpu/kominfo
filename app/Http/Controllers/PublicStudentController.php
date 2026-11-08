<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;

class PublicStudentController extends Controller
{
    public function index()
    {
        $students = Student::with('department')
            ->select('id', 'type', 'institution', 'major', 'department_id', 'start_date', 'end_date', 'status')
            ->orderByDesc('id')
            ->paginate(12);

        $departments = Department::orderBy('sort_order')->get();

        return view('students.index', [
            'students' => $students,
            'departments' => $departments,
        ]);
    }
}