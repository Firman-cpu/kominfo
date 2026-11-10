<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Assessment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        // Fresh load dari DB agar selalu tampilkan data terbaru (termasuk foto baru)
        $admin = Auth::guard('admin')->user()->fresh();

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
        /** @var Admin $admin */
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
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'],
            'current_password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // ── Simpan perubahan nama / username ─────────────────────────────
        $updateFields = [
            'name' => $request->name,
            'username' => $request->username,
            'updated_at' => now(),
        ];

        // ── Ganti password jika diisi ────────────────────────────────────
        if ($request->filled('current_password')) {
            if (! Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors([
                    'current_password' => 'Password saat ini tidak sesuai.',
                ])->withInput();
            }
            if ($request->filled('new_password')) {
                $updateFields['password'] = Hash::make($request->new_password);
            }
        }

        // ── Upload foto profil ───────────────────────────────────────────
        // Gunakan DB::table() langsung: hindari Eloquent events (LogsActivity)
        // yang akan gagal meng-encode binary blob ke JSON.
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            $updateFields['photo_data'] = file_get_contents($file->getRealPath());
            $updateFields['photo_mime'] = $file->getMimeType() ?: 'image/jpeg';
        }

        // Satu UPDATE tunggal — atomik, efisien, bebas dari event masalah
        DB::table('admins')->where('id', $admin->id)->update($updateFields);

        // ── Refresh session user agar halaman berikutnya langsung tampil data baru
        $freshAdmin = Admin::find($admin->id);
        Auth::guard('admin')->setUser($freshAdmin);

        return redirect()
            ->route('admin.profile.index')
            ->with('success', 'Profil akun berhasil diperbarui.');
    }
}
