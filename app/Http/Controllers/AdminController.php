<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard.page');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $throttleKey = Str::transliterate(Str::lower($request->input('username')).'|'.$request->ip());

        // Rate Limiter: Maksimal 5 percobaan per menit
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'username' => "Terlalu banyak percobaan login. Silakan tunggu {$seconds} detik lagi.",
            ])->onlyInput('username');
        }

        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $admin = Admin::where('username', $credentials['username'])->first();

        if (! $admin || ! Hash::check($credentials['password'], $admin->password)) {
            RateLimiter::hit($throttleKey, 60);

            ActivityLogger::log(
                'login_failed',
                "Percobaan login gagal untuk username '{$credentials['username']}'",
                'Admin',
                $admin?->id
            );

            return back()->withErrors([
                'username' => 'Username atau password yang Anda masukkan salah.',
            ])->onlyInput('username');
        }

        if (! $admin->is_active) {
            return back()->withErrors([
                'username' => 'Akun Anda dinonaktifkan. Silakan hubungi Administrator.',
            ])->onlyInput('username');
        }

        RateLimiter::clear($throttleKey);

        Auth::guard('admin')->login($admin, $request->boolean('remember'));
        $request->session()->regenerate();

        $admin->update(['last_login_at' => now()]);

        ActivityLogger::log('login', "Admin/Operator '{$admin->name}' ({$admin->username}) berhasil login ke sistem", 'Admin', $admin->id);

        return redirect()->intended(route('admin.dashboard.page'));
    }

    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            ActivityLogger::log('logout', "Admin/Operator '{$admin->name}' ({$admin->username}) logout dari sistem", 'Admin', $admin->id);
        }

        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil logout.');
    }
}
