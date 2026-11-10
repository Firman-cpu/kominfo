@extends('layouts/admin')

@section('title', 'Tambah Peserta Baru')
@section('page-title', 'Tambah Peserta PKL / Magang')
@section('page-subtitle', 'Pendaftaran data siswa SMK atau mahasiswa perguruan tinggi di DISKOMINFO Pacitan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.students.index') }}"
           class="neu-btn px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:text-slate-900 inline-flex items-center gap-1.5 transition-all">
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
