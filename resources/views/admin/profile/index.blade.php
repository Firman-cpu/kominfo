@extends('layouts/admin')

@section('title', 'Profil Akun Saya')
@section('page-title', 'Profil & Keamanan Akun')
@section('page-subtitle', 'Kelola informasi identitas akun dan perbarui password login Anda')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    {{-- Profile Card --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-700 to-indigo-600 flex items-center justify-center text-white font-extrabold text-xl shadow-md shrink-0">
                {{ strtoupper(substr($admin->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h3 class="text-lg font-bold text-slate-900">{{ $admin->name }}</h3>
                    @if ($admin->isAdministrator())
                        <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                            Administrator Utama
                        </span>
                    @else
                        <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            Operator Data
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 font-mono">Username: {{ $admin->username }}</p>
                <p class="text-[11px] text-slate-400 mt-0.5">
                    Login Terakhir: {{ $admin->last_login_at ? $admin->last_login_at->format('d M Y, H:i') . ' WIB' : 'Sesi aktif pertama kali' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Update Profile & Password Form --}}
    <form method="POST" action="{{ route('admin.profile.update') }}" class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <h4 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                <i data-lucide="user" class="w-4 h-4 text-blue-600"></i>
                <span>Informasi Akun</span>
            </h4>

            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $admin->name) }}"
                       required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                @error('name')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="username" class="block text-xs font-semibold text-slate-700 mb-1">
                    Username Login <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="username"
                       id="username"
                       value="{{ old('username', $admin->username) }}"
                       required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 font-mono">
                @error('username')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 space-y-4">
            <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="lock" class="w-4 h-4 text-blue-600"></i>
                <span>Ganti Password</span>
            </h4>
            <p class="text-xs text-slate-500 -mt-2">Kosongkan bagian password ini jika tidak ingin mengubah password saat ini.</p>

            <div>
                <label for="current_password" class="block text-xs font-semibold text-slate-700 mb-1">
                    Password Saat Ini
                </label>
                <input type="password"
                       name="current_password"
                       id="current_password"
                       placeholder="Masukkan password lama Anda"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                @error('current_password')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="new_password" class="block text-xs font-semibold text-slate-700 mb-1">
                        Password Baru
                    </label>
                    <input type="password"
                           name="new_password"
                           id="new_password"
                           placeholder="Minimal 8 karakter"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                    @error('new_password')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="new_password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">
                        Konfirmasi Password Baru
                    </label>
                    <input type="password"
                           name="new_password_confirmation"
                           id="new_password_confirmation"
                           placeholder="Ulangi password baru"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition-all flex items-center gap-2 cursor-pointer">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Simpan Perubahan Akun</span>
            </button>
        </div>
    </form>
</div>
@endsection