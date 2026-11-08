@extends('layouts/admin')

@section('title', 'Edit Peserta — ' . $student->name)
@section('page-title', 'Edit Data Peserta')
@section('page-subtitle', 'Perbarui data identitas, bidang, atau periode PKL')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.students.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Peserta</span>
        </a>
        <a href="{{ route('admin.students.show', $student->id) }}"
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800">
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