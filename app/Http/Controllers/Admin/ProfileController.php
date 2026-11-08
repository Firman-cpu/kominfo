<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $completedStudents = Student::where('status', 'completed')->count();
        $totalAssessments = Assessment::count();

        return view('admin.profile.index', [
            'admin' => $admin,
            'totalStudents' => $totalStudents,
            'activeStudents' => $activeStudents,
            'completedStudents' => $completedStudents,
            'totalAssessments' => $totalAssessments,
        ]);
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'alpha_dash',
                'min:3',
                'max:50',
                Rule::unique('admins', 'username')->ignore($admin->id),
            ],
            'current_password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $admin->name = $request->name;
        $admin->username = $request->username;

        // Update password jika diisi
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
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
            ->with('success', 'Profil dan kredensial akun Anda berhasil diperbarui.');
    }
}
