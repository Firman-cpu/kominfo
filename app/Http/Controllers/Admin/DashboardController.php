<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\AnalyticsService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(AnalyticsService $analyticsService)
    {
        // Sinkronisasi status otomatis bila ada yang sudah lewat tanggal selesai
        Student::where('status', 'active')
            ->whereNotNull('end_date')
            ->whereDate('end_date', '<', Carbon::today())
            ->update(['status' => 'completed']);

        $stats = $analyticsService->getDashboardStats();

        return view('admin.dashboard.page', $stats);
    }
}