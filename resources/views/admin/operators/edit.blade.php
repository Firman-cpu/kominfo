@extends('layouts/admin')

@section('title', 'Edit Operator — ' . $operator->name)
@section('page-title', 'Edit Akun Operator')
@section('page-subtitle', 'Perbarui data akun atau reset password operator')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <a href="{{ route('admin.operators.index') }}"
       class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>Kembali ke Daftar Operator</span>
    </a>

    <form method="POST" action="{{ route('admin.operators.update', $operator->id) }}" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">
                Nama Lengkap Petugas Operator <span class="text-rose-500">*</span>
            </label>
            <input type="text"
                   name="name"
                   id="name"
                   value="{{ old('name', $operator->name) }}"
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
                   value="{{ old('username', $operator->username) }}"
                   required
                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 font-mono">
            @error('username')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
            <label for="password" class="block text-xs font-semibold text-slate-700">
                Ganti Password Baru (Kosongkan bila tidak ingin mengubah)
            </label>
            <input type="password"
                   name="password"
                   id="password"
                   placeholder="Masukkan password baru (minimal 8 karakter)"
                   class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 bg-white">
            @error('password')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-2">
            <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $operator->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <span>Status Akun Aktif (Dapat Login ke Sistem)</span>
            </label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.operators.index') }}"
               class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-100 text-xs font-semibold transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition-all flex items-center gap-2 cursor-pointer">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
@endsection
