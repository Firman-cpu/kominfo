<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Admin;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('admin')->orderByDesc('created_at');

        // Filter Operator / Admin
        if ($adminId = $request->input('admin_id')) {
            $query->where('admin_id', $adminId);
        }

        // Filter Action
        if ($action = $request->input('action')) {
            $query->where('action', $action);
        }

        // Filter Tanggal
        if ($date = $request->input('date')) {
            $query->whereDate('created_at', $date);
        }

        $logs = $query->paginate(25)->withQueryString();
        $admins = Admin::orderBy('name')->get();

        return view('admin.logs.index', compact('logs', 'admins'));
    }

    public function show(ActivityLog $log)
    {
        $log->load('admin');
        return view('admin.logs.show', compact('log'));
    }
}
