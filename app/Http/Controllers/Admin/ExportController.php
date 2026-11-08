<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Student;
use App\Services\ActivityLogger;
use App\Services\StudentExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('sort_order')->get();
        $availableYears = Student::getAvailableYears();

        return view('admin.export.index', compact('departments', 'availableYears'));
    }

    public function export(Request $request, StudentExportService $exportService)
    {
        $request->validate([
            'dataset' => ['required', 'in:students,assessments,both'],
            'year' => ['nullable', 'integer'],
            'type' => ['nullable', 'in:prakerin,magang'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'status' => ['nullable', 'in:active,completed'],
        ]);

        $filters = $request->only(['year', 'type', 'department_id', 'status']);
        $dataset = $request->input('dataset', 'both');

        ActivityLogger::log(
            'export',
            "Mengekspor data ({$dataset}) ke Excel XLSX dengan filter: " . json_encode(array_filter($filters))
        );

        return $exportService->export($filters, $dataset);
    }
}
