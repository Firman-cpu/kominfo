<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Assessment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $adminId       = session('admin_id');
        $admin         = Admin::findOrFail($adminId);

        $totalStudents    = Student::count();
        $activeStudents   = Student::where('status', 'active')->count();
        $completedStudents = Student::where('status', 'completed')->count();
        $inactiveStudents = Student::where('status', 'inactive')->count();
        $totalAssessments = Assessment::count();

        return view('admin.profile.index', [
            'admin'             => $admin,
            'totalStudents'     => $totalStudents,
            'activeStudents'    => $activeStudents,
            'completedStudents' => $completedStudents,
            'inactiveStudents'  => $inactiveStudents,
            'totalAssessments'  => $totalAssessments,
        ]);
    }

    public function update(Request $request)
    {
        $adminId = session('admin_id');
        $admin   = Admin::findOrFail($adminId);

        $request->validate([
            'username'         => ['required', 'string', 'min:3', 'max:50'],
            'current_password' => ['nullable', 'string'],
            'new_password'     => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        // Update username
        $admin->username = $request->username;
        session(['admin_username' => $request->username]);

        // Update password jika diisi
        if ($request->filled('current_password')) {
            if (! Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors([
                    'current_password' => 'Password saat ini tidak sesuai.',
                ])->withInput();
            }

            if ($request->filled('new_password')) {
                $admin->password = Hash::make($request->new_password);
            }
        }

        $admin->save();

        return redirect()
            ->route('admin.profile.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
