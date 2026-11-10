<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request, AnalyticsService $analyticsService)
    {
        $year = $request->input('year');
        $departmentId = $request->input('department_id');

        $data = $analyticsService->getAnalyticsData($year ? (int) $year : null, $departmentId ? (int) $departmentId : null);
        $departments = Department::orderBy('sort_order')->get();

        return view('admin.analytics.index', array_merge($data, [
            'departments' => $departments,
            'selectedYear' => $year,
            'selectedDepartmentId' => $departmentId,
        ]));
    }
}
