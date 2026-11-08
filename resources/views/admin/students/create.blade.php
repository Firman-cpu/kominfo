@extends('layouts/admin')

@section('title', 'Tambah Peserta Baru')
@section('page-title', 'Tambah Peserta PKL / Magang')
@section('page-subtitle', 'Pendaftaran data siswa prakerin SMK atau mahasiswa magang')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.students.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Peserta</span>
        </a>
    </div>

    <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.students._form', ['departments' => $departments])
    </form>
</div>
@endsection