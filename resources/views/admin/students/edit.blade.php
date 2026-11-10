@extends('layouts/admin')

@section('title', 'Edit Peserta — ' . $student->name)
@section('page-title', 'Edit Data Peserta')
@section('page-subtitle', 'Perbarui rincian profil, penempatan bidang, dan masa penugasan peserta')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.students.index') }}"
           class="neu-btn px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:text-slate-900 inline-flex items-center gap-1.5 transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Peserta</span>
        </a>
        <a href="{{ route('admin.students.show', $student->id) }}"
           class="neu-btn px-4 py-2 rounded-xl text-xs font-semibold text-blue-600 hover:text-blue-800 inline-flex items-center gap-1.5 transition-all">
            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
            <span>Lihat Detail Profil</span>
        </a>
    </div>

    <form method="POST" action="{{ route('admin.students.update', $student->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.students._form', ['student' => $student, 'departments' => $departments])
    </form>
</div>
@endsection
