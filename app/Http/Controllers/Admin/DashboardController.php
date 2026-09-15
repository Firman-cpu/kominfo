<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();

        $activeStudents = Student::where('status', 'active')->count();

        $completedStudents = Student::where('status', 'completed')->count();

        $inactiveStudents = Student::where('status', 'inactive')->count();

        return view('admin.dashboard.page', [
            'totalStudents' => $totalStudents,
            'activeStudents' => $activeStudents,
            'completedStudents' => $completedStudents,
            'inactiveStudents' => $inactiveStudents,
        ]);
    }
}