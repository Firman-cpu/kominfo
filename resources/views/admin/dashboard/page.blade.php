@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Panel Pengelolaan Data PRAKERIN & Magang DISKOMINFO')

@section('content')
<div class="space-y-7">

    {{-- ============================================================
         1. QUICK ACTIONS (6 Kartu Tombol Aksi Cepat - Neumorphic Style)
         1. Tambah Peserta (CTA Utama, Neumorphic Dark)
         2. Input Penilaian
         3. Aspek Penilaian
         4. Kategori Nilai
         5. Ekspor Excel
         6. Analitik & Data
    ============================================================ --}}
    <section aria-label="Aksi Cepat">
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-4">

            {{-- 1. Tambah Peserta (CTA Utama - Neumorphic Dark Slate) --}}
            <a href="{{ route('admin.students.create') }}"
               style="--i: 0;"
               class="card-enter neu-dark-cta btn-press group flex flex-col justify-between p-4.5 rounded-2xl"
               aria-label="Tambah Peserta Baru">
                <div class="flex items-center justify-between">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white transition-transform group-hover:scale-105">
                        <i data-lucide="user-plus" class="w-5 h-5"></i>
                    </span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Utama</span>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-extrabold text-white leading-tight">Tambah Peserta</p>
                    <p class="text-[11px] text-slate-300 mt-1 line-clamp-1">Registrasi PKL/Magang</p>
                </div>
            </a>

            {{-- 2. Input Penilaian --}}
            <a href="{{ route('admin.assessments.create') }}"
               style="--i: 1;"
               class="card-enter neu-card btn-press group flex flex-col justify-between p-4.5 rounded-2xl text-slate-800"
               aria-label="Input Penilaian Peserta">
                <div class="flex items-center justify-between">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl neu-inset text-[#3B52F6] transition-transform group-hover:scale-105">
                        <i data-lucide="award" class="w-5 h-5"></i>
                    </span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nilai</span>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-extrabold text-slate-900 leading-tight">Input Penilaian</p>
                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-1">Evaluasi capaian akhir</p>
                </div>
            </a>

            {{-- 3. Aspek Penilaian --}}
            <a href="{{ route('admin.aspects.index') }}"
               style="--i: 2;"
               class="card-enter neu-card btn-press group flex flex-col justify-between p-4.5 rounded-2xl text-slate-800"
               aria-label="Kelola Aspek Penilaian">
                <div class="flex items-center justify-between">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl neu-inset text-slate-700 transition-transform group-hover:scale-105">
                        <i data-lucide="sliders" class="w-5 h-5"></i>
                    </span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Bobot</span>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-extrabold text-slate-900 leading-tight">Aspek Penilaian</p>
                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-1">Kriteria dinamis</p>
                </div>
            </a>

            {{-- 4. Kategori Nilai --}}
            <a href="{{ route('admin.categories.index') }}"
               style="--i: 3;"
               class="card-enter neu-card btn-press group flex flex-col justify-between p-4.5 rounded-2xl text-slate-800"
               aria-label="Kategori Nilai & Performa">
                <div class="flex items-center justify-between">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl neu-inset text-slate-700 transition-transform group-hover:scale-105">
                        <i data-lucide="badge-percent" class="w-5 h-5"></i>
                    </span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Grade</span>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-extrabold text-slate-900 leading-tight">Kategori Nilai</p>
                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-1">Rentang predikat</p>
                </div>
            </a>

            {{-- 5. Ekspor Excel --}}
            <a href="{{ route('admin.export.index') }}"
               style="--i: 4;"
               class="card-enter neu-card btn-press group flex flex-col justify-between p-4.5 rounded-2xl text-slate-800"
               aria-label="Ekspor Laporan Excel">
                <div class="flex items-center justify-between">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl neu-inset text-emerald-700 transition-transform group-hover:scale-105">
                        <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                    </span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Excel</span>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-extrabold text-slate-900 leading-tight">Ekspor Excel</p>
                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-1">Unduh rekapitulasi</p>
                </div>
            </a>

            {{-- 6. Analitik & Data --}}
            <a href="{{ route('admin.analytics.index') }}"
               style="--i: 5;"
               class="card-enter neu-card btn-press group flex flex-col justify-between p-4.5 rounded-2xl text-slate-800"
               aria-label="Analitik & Statistik">
                <div class="flex items-center justify-between">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl neu-inset text-indigo-700 transition-transform group-hover:scale-105">
                        <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                    </span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Grafik</span>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-extrabold text-slate-900 leading-tight">Analitik & Data</p>
                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-1">Statistik penempatan</p>
                </div>
            </a>

        </div>
    </section>


    {{-- ============================================================
         2. BENTO GRID LAYOUT (NEUMORPHISM SOFT UI)
         Desktop Grid:
           - Kiri:  RINGKASAN & DISTRIBUSI BIDANG | STATISTIK & TREN GRAFIK
           - Kanan: STATUS REAL-TIME & FEED PESERTA | 3 WIDGET BERTUMPUK (Status, 7 Hari Selesai, Ekspor)
    ============================================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 items-start">

        {{-- ========================================================
             MODUL 1: RINGKASAN METRIK & DISTRIBUSI BIDANG (Section Tengah Kiri)
             Order: Mobile 1 | Desktop Col 1-7/8
        ======================================================== --}}
        <section
            style="--i: 6;"
            class="order-1 lg:order-1 lg:col-span-7 xl:col-span-8 neu-card p-6 sm:p-7 flex flex-col justify-between"
            aria-label="Ringkasan Metrik dan Distribusi Bidang"
        >
            {{-- Bagian Atas: 4 Metrik Kunci --}}
            <div>
                <div class="flex flex-wrap items-center justify-between gap-3 pb-5 border-b border-[#d8e2ee]">
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Ringkasan Peserta & Penilaian</h2>
                        <p class="text-xs text-slate-500 mt-0.5 font-medium">Statistik keseluruhan peserta PKL/Magang di Diskominfo Pacitan</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 rounded-xl neu-inset-sm px-3 py-1.5 text-xs font-bold text-[#3B52F6]">
                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i>
                        Data Sinkron
                    </span>
                </div>

                {{-- 4 Metrik Utama (Neumorphic Inset) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mt-5">
                    {{-- Total Peserta --}}
                    <div class="rounded-2xl neu-inset p-4 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Total Peserta</p>
                            <span class="inline-flex items-center rounded-lg neu-card-sm px-2 py-0.5 text-[10px] font-bold text-[#3B52F6]">
                                Terdata
                            </span>
                        </div>
                        <h3 class="mt-2 text-2xl sm:text-3xl font-black text-slate-900 metric-counter" data-target="{{ $totalStudents }}">
                            {{ $totalStudents }}
                        </h3>
                        <p class="mt-2 text-[11px] text-slate-500 font-medium">
                            {{ $totalPrakerin }} SMK &bull; {{ $totalMagang }} Mhs
                        </p>
                    </div>

                    {{-- Sedang Aktif --}}
                    <div class="rounded-2xl neu-inset p-4 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Sedang Aktif</p>
                            <span class="inline-flex items-center gap-1 rounded-lg neu-card-sm px-2 py-0.5 text-[10px] font-bold text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-600 pulse-dot"></span>
                                Aktif
                            </span>
                        </div>
                        <h3 class="mt-2 text-2xl sm:text-3xl font-black text-emerald-700 metric-counter" data-target="{{ $activeStudents }}">
                            {{ $activeStudents }}
                        </h3>
                        <p class="mt-2 text-[11px] text-slate-500 font-medium">
                            Menjalani masa praktik
                        </p>
                    </div>

                    {{-- Selesai PKL --}}
                    <div class="rounded-2xl neu-inset p-4 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Selesai PKL</p>
                            <span class="inline-flex items-center rounded-lg neu-card-sm px-2 py-0.5 text-[10px] font-bold text-slate-700">
                                Tuntas
                            </span>
                        </div>
                        <h3 class="mt-2 text-2xl sm:text-3xl font-black text-slate-800 metric-counter" data-target="{{ $completedStudents }}">
                            {{ $completedStudents }}
                        </h3>
                        <p class="mt-2 text-[11px] text-slate-500 font-medium">
                            Durasi tuntas
                        </p>
                    </div>

                    {{-- Rata-rata Nilai --}}
                    <div class="rounded-2xl neu-inset p-4 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Rata-rata Nilai</p>
                            <span class="inline-flex items-center gap-1 rounded-lg neu-card-sm px-2 py-0.5 text-[10px] font-bold text-amber-700">
                                <i data-lucide="award" class="w-3 h-3"></i>
                                Skor
                            </span>
                        </div>
                        <h3 class="mt-2 text-2xl sm:text-3xl font-black text-amber-700">
                            {{ $overallAvg }}
                        </h3>
                        <p class="mt-2 text-[11px] text-slate-500 font-medium">
                            {{ $totalAssessed }} peserta dinilai
                        </p>
                    </div>
                </div>
            </div>

            {{-- Bagian Bawah: Distribusi Bidang Penempatan (Top #1 Disorot Blok Biru Terang) --}}
            <div class="mt-8 pt-6 border-t border-[#d8e2ee]">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">Distribusi Bidang Penempatan</h3>
                        <p class="text-xs text-slate-500">Alokasi peserta berdasarkan bidang penugasan di Diskominfo</p>
                    </div>
                    <a href="{{ route('admin.students.create') }}"
                       class="text-xs font-bold text-[#3B52F6] hover:underline inline-flex items-center gap-1 transition-colors">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        Tambah Peserta
                    </a>
                </div>

                @php
                    $sortedDepts = $departments->sortByDesc('students_count');
                    $topDept = $sortedDepts->first();
                    $otherDepts = $sortedDepts->slice(1);
                @endphp

                <div class="space-y-3">
                    {{-- BIDANG #1: Diberi Blok Biru Terang (#3B52F6) --}}
                    @if ($topDept)
                        <div class="flex items-center justify-between gap-3 p-4 rounded-2xl neu-primary">
                            <div class="flex items-center gap-3.5 min-w-0">
                                {{-- Icon Container / Image Support --}}
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white/20 text-white backdrop-blur-xs overflow-hidden shadow-inner">
                                    @if ($topDept->image_url)
                                        <img src="{{ $topDept->image_url }}" alt="{{ $topDept->name }}" class="h-full w-full object-cover">
                                    @else
                                        <i data-lucide="{{ $topDept->icon }}" class="w-5 h-5"></i>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="rounded-md bg-white/25 px-1.5 py-0.5 text-[9px] font-black uppercase text-white tracking-wider">#1 Utama</span>
                                        <p class="text-sm font-black text-white truncate">{{ $topDept->name }}</p>
                                    </div>
                                    <p class="text-xs text-blue-100 truncate mt-0.5 font-medium">
                                        Kode: <strong class="text-white">{{ $topDept->code }}</strong> &bull; {{ $topDept->active_count }} Aktif &bull; {{ $topDept->completed_count }} Selesai
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <div class="hidden sm:block text-right">
                                    <span class="text-xs font-bold text-white">Alokasi Tertinggi</span>
                                    <p class="text-[11px] text-blue-100">Paling banyak</p>
                                </div>
                                <span class="rounded-xl bg-white text-[#3B52F6] px-3.5 py-1.5 text-xs font-black shadow-md">
                                    {{ $topDept->students_count }} Peserta
                                </span>
                            </div>
                        </div>
                    @endif

                    {{-- Bidang Lainnya (Neumorphic Inset dengan Ikon) --}}
                    @foreach ($otherDepts as $dept)
                        <div class="flex items-center justify-between gap-3 p-3.5 rounded-2xl neu-inset hover:neu-card transition-all">
                            <div class="flex items-center gap-3.5 min-w-0">
                                {{-- Icon Container / Image Support --}}
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl neu-card-sm text-slate-700 overflow-hidden">
                                    @if ($dept->image_url)
                                        <img src="{{ $dept->image_url }}" alt="{{ $dept->name }}" class="h-full w-full object-cover">
                                    @else
                                        <i data-lucide="{{ $dept->icon }}" class="w-5 h-5 text-slate-600"></i>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="rounded-md neu-inset-sm px-1.5 py-0.5 text-[9px] font-bold text-slate-500 uppercase">{{ $dept->code }}</span>
                                        <p class="text-xs sm:text-sm font-extrabold text-slate-900 truncate">{{ $dept->name }}</p>
                                    </div>
                                    <p class="text-[11px] text-slate-500 truncate mt-0.5 font-medium">
                                        {{ $dept->active_count }} Aktif di kantor &bull; {{ $dept->completed_count }} Selesai
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 shrink-0">
                                <span class="text-xs font-bold text-emerald-700 hidden sm:inline">{{ $dept->active_count }} Aktif</span>
                                <span class="rounded-xl neu-card-sm text-slate-900 px-3 py-1.5 text-xs font-black">
                                    {{ $dept->students_count }} Total
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        {{-- ========================================================
             MODUL 2: STATUS REAL-TIME & PESERTA TERBARU (Section Tengah Kanan)
             Order: Mobile 2 | Desktop Col 8-12
        ======================================================== --}}
        <section
            style="--i: 7;"
            class="order-2 lg:order-2 lg:col-span-5 xl:col-span-4 neu-card p-6 sm:p-7 flex flex-col justify-between"
            aria-label="Status Peserta dan Pendaftaran Terbaru"
        >
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-[#d8e2ee]">
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Peserta Terbaru</h2>
                        <p class="text-xs text-slate-500 mt-0.5 font-medium">Prakerin & Mahasiswa yang baru didaftarkan</p>
                    </div>
                    <span class="flex h-3 w-3 rounded-full bg-emerald-500 pulse-dot" title="Sistem Aktif"></span>
                </div>

                {{-- Status Per Tipe Peserta (Neumorphic Inset) --}}
                <div class="grid grid-cols-3 gap-2 mt-4 p-3 rounded-2xl neu-inset text-center">
                    <div>
                        <div class="flex items-center justify-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-[#3B52F6]"></span>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">SMK</span>
                        </div>
                        <p class="text-lg font-black text-slate-900 mt-1">{{ $totalPrakerin }}</p>
                        <p class="text-[10px] text-slate-400 font-semibold">prakerin</p>
                    </div>

                    <div class="border-x border-[#d8e2ee]">
                        <div class="flex items-center justify-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Mahasiswa</span>
                        </div>
                        <p class="text-lg font-black text-slate-900 mt-1">{{ $totalMagang }}</p>
                        <p class="text-[10px] text-slate-400 font-semibold">magang</p>
                    </div>

                    <div>
                        <div class="flex items-center justify-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 pulse-dot"></span>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Aktif</span>
                        </div>
                        <p class="text-lg font-black text-slate-900 mt-1">{{ $activeStudents }}</p>
                        <p class="text-[10px] text-slate-400 font-semibold">di kantor</p>
                    </div>
                </div>

                {{-- Feed Kronologis Peserta Terbaru --}}
                <div class="mt-6">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-3">Daftar Registrasi Baru</p>

                    <div class="space-y-3">
                        @forelse ($recentStudents as $student)
                            <div class="flex items-center justify-between gap-3 p-3 rounded-2xl neu-inset hover:neu-card transition-all">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl neu-card-sm overflow-hidden text-xs font-bold text-slate-700">
                                        @if ($student->photo_url)
                                            <img src="{{ $student->photo_url }}" alt="{{ $student->name }}" class="h-full w-full object-cover">
                                        @else
                                            <span>{{ strtoupper(substr($student->name, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.students.show', $student->id) }}" class="text-xs font-extrabold text-slate-900 hover:text-[#3B52F6] truncate block transition-colors">
                                            {{ $student->name }}
                                        </a>
                                        <p class="text-[11px] text-slate-500 truncate mt-0.5 font-medium">
                                            {{ $student->institution ?? '-' }} &bull; <span class="font-bold text-slate-700">{{ $student->department?->name ?? '-' }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    @include('components.admin.badge-status', ['status' => $student->status])
                                    <a href="{{ route('admin.students.show', $student->id) }}"
                                       class="flex h-8 w-8 items-center justify-center rounded-xl neu-btn text-slate-600 hover:text-[#3B52F6] transition-colors"
                                       title="Lihat Detail">
                                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center text-xs text-slate-400 rounded-2xl neu-inset">
                                Belum ada data peserta terdaftar.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-[#d8e2ee]">
                <a href="{{ route('admin.students.index') }}" class="text-xs font-bold text-slate-700 hover:text-[#3B52F6] flex items-center justify-center gap-1.5 transition-colors">
                    Lihat Semua Peserta
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </section>


        {{-- ========================================================
             MODUL 3: GRAFIK & STATISTIK PENEMPATAN (Section Bawah Kiri)
             Order: Mobile 3 | Desktop Col 1-7/8 (Row-span 3)
        ======================================================== --}}
        <section
            style="--i: 8;"
            class="order-3 lg:order-3 lg:col-span-7 xl:col-span-8 lg:row-span-3 neu-card p-6 sm:p-7 flex flex-col justify-between"
            aria-label="Statistik dan Grafik Penempatan"
        >
            <div>
                <div class="flex flex-wrap items-center justify-between gap-3 pb-5 border-b border-[#d8e2ee]">
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Statistik Penempatan & Penilaian</h2>
                        <p class="text-xs text-slate-500 mt-0.5 font-medium">Distribusi peserta per bidang serta perbandingan capaian</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 rounded-xl neu-inset-sm px-3 py-1.5 text-xs font-bold text-[#3B52F6]">
                            <i data-lucide="bar-chart-2" class="w-3.5 h-3.5"></i>
                            Analitik Aktif
                        </span>
                    </div>
                </div>

                {{-- 4 Angka Kunci (Neumorphic Inset) --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 mt-5">
                    {{-- Total Terdaftar --}}
                    <div class="p-3.5 rounded-2xl neu-inset">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Total Terdaftar</p>
                        <p class="text-lg sm:text-xl font-black text-slate-900 mt-1">{{ $totalStudents }} Orang</p>
                        <span class="text-[10px] font-bold text-[#3B52F6]">100% Tercatat</span>
                    </div>

                    {{-- Tingkat Kelulusan --}}
                    @php
                        $completionRate = $totalStudents > 0 ? round(($completedStudents / $totalStudents) * 100, 1) : 0;
                    @endphp
                    <div class="p-3.5 rounded-2xl neu-inset">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Tingkat Selesai</p>
                        <p class="text-lg sm:text-xl font-black text-slate-900 mt-1">{{ $completionRate }}%</p>
                        <span class="text-[10px] font-bold text-emerald-700">Tuntas Praktik</span>
                    </div>

                    {{-- Peserta Dinilai --}}
                    <div class="p-3.5 rounded-2xl neu-inset">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Telah Dinilai</p>
                        <p class="text-lg sm:text-xl font-black text-slate-900 mt-1">{{ $totalAssessed }} Peserta</p>
                        <span class="text-[10px] text-slate-500 font-semibold">dari {{ $completedStudents }} tuntas</span>
                    </div>

                    {{-- Rata-rata Nilai --}}
                    <div class="p-3.5 rounded-2xl neu-inset">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Rata-rata Nilai</p>
                        <p class="text-lg sm:text-xl font-black text-slate-900 mt-1">{{ $overallAvg }}</p>
                        <span class="text-[10px] text-amber-700 font-bold">Skala 0 - 100</span>
                    </div>
                </div>

                {{-- Hybrid Bar-Line Chart dengan Gradasi Halus di dalam Neumorphic Inset --}}
                <div class="mt-6">
                    <div class="flex items-center justify-between mb-3 px-1">
                        <div class="flex items-center gap-4 text-xs font-semibold">
                            <span class="flex items-center gap-1.5 text-slate-800">
                                <span class="h-3 w-3 rounded-md neu-primary"></span>
                                Peserta Aktif
                            </span>
                            <span class="flex items-center gap-1.5 text-slate-500">
                                <span class="h-3 w-3 rounded-md neu-card-sm"></span>
                                Total Alokasi Bidang
                            </span>
                        </div>
                        <span class="text-[11px] font-bold text-slate-400">Berdasarkan Bidang Diskominfo</span>
                    </div>

                    {{-- Canvas dengan pre-allocated height (CLS = 0) dan Neumorphic Inset Well --}}
                    <div class="relative h-64 sm:h-72 w-full p-4 rounded-3xl neu-inset">
                        <canvas id="diskominfoHybridChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>
        </section>


        {{-- ========================================================
             MODUL 4: STATUS PESERTA (Section Bawah Kanan #1)
             Segmented Progress Bar
             Order: Mobile 4 | Desktop Col 8-12
        ======================================================== --}}
        <section
            style="--i: 9;"
            class="order-4 lg:order-4 lg:col-span-5 xl:col-span-4 neu-card p-5 sm:p-6"
            aria-label="Status Peserta"
        >
            <div class="flex items-center justify-between pb-3 border-b border-[#d8e2ee]">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">Status Peserta</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Proporsi keaktifan di kantor</p>
                </div>
                <span class="rounded-xl neu-inset-sm px-2.5 py-1 text-xs font-extrabold text-slate-700">
                    {{ $totalStudents }} Total
                </span>
            </div>

            @php
                $activePct = $totalStudents > 0 ? round(($activeStudents / $totalStudents) * 100) : 0;
                $completedPct = $totalStudents > 0 ? round(($completedStudents / $totalStudents) * 100) : 0;
                $otherPct = max(0, 100 - ($activePct + $completedPct));
            @endphp

            {{-- Segmented Progress Bar (Neumorphic Inset Track) --}}
            <div class="mt-4">
                <div class="h-4 w-full rounded-full neu-inset overflow-hidden flex gap-1 p-0.5">
                    {{-- Aktif (#3B52F6) --}}
                    <div class="h-full rounded-full bg-[#3B52F6] transition-all duration-700 ease-out shadow-xs" style="width: {{ $activePct }}%;" title="Sedang Aktif: {{ $activePct }}%"></div>
                    {{-- Selesai (Emerald) --}}
                    <div class="h-full rounded-full bg-emerald-500 transition-all duration-700 ease-out shadow-xs" style="width: {{ $completedPct }}%;" title="Selesai: {{ $completedPct }}%"></div>
                    @if ($otherPct > 0)
                        {{-- Lainnya (Slate) --}}
                        <div class="h-full rounded-full bg-slate-300 transition-all duration-700 ease-out shadow-xs" style="width: {{ $otherPct }}%;" title="Lainnya: {{ $otherPct }}%"></div>
                    @endif
                </div>

                {{-- Legend & Counts --}}
                <div class="mt-4 grid grid-cols-2 gap-3 text-center text-xs">
                    <div class="p-3 rounded-2xl neu-inset">
                        <div class="flex items-center justify-center gap-1.5 text-[11px] font-extrabold text-slate-800">
                            <span class="h-2.5 w-2.5 rounded-full bg-[#3B52F6]"></span>
                            Sedang Aktif
                        </div>
                        <p class="text-base font-black text-slate-900 mt-1">{{ $activeStudents }}</p>
                        <span class="text-[10px] text-[#3B52F6] font-bold">{{ $activePct }}%</span>
                    </div>

                    <div class="p-3 rounded-2xl neu-inset">
                        <div class="flex items-center justify-center gap-1.5 text-[11px] font-extrabold text-slate-800">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            Selesai PKL
                        </div>
                        <p class="text-base font-black text-slate-900 mt-1">{{ $completedStudents }}</p>
                        <span class="text-[10px] text-emerald-700 font-bold">{{ $completedPct }}%</span>
                    </div>
                </div>
            </div>
        </section>


        {{-- ========================================================
             MODUL 5: SELESAI DALAM 7 HARI (Section Bawah Kanan #2)
             Alert Widget Neumorphic
             Order: Mobile 5 | Desktop Col 8-12
        ======================================================== --}}
        <section
            style="--i: 10;"
            class="order-5 lg:order-5 lg:col-span-5 xl:col-span-4 neu-alert p-5 sm:p-6 relative overflow-hidden"
            aria-label="Perlu Perhatian: Selesai Dalam 7 Hari"
        >
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl neu-card-sm text-[#C2410C]">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                    </span>
                    <div>
                        <h3 class="text-sm font-extrabold text-amber-950 tracking-tight">Selesai Dalam 7 Hari</h3>
                        <p class="text-xs text-amber-800 font-medium">Masa praktik segera tuntas</p>
                    </div>
                </div>
                <span class="flex h-2.5 w-2.5 rounded-full bg-amber-500 pulse-dot"></span>
            </div>

            <div class="mt-4 space-y-2.5 text-xs">
                @forelse ($endingSoon as $item)
                    <div class="p-3 rounded-2xl bg-white/70 border border-amber-200/50 flex items-center justify-between gap-2 shadow-2xs">
                        <div class="min-w-0">
                            <a href="{{ route('admin.students.show', $item->id) }}" class="font-bold text-amber-950 truncate block hover:underline">
                                {{ $item->name }}
                            </a>
                            <p class="text-[11px] text-amber-800 truncate mt-0.5 font-medium">
                                {{ $item->institution ?? '-' }} &bull; Selesai: <span class="font-bold">{{ $item->end_date->format('d M Y') }}</span>
                            </p>
                        </div>
                        <a href="{{ route('admin.students.show', $item->id) }}" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl neu-btn text-[#C2410C] transition-colors">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                @empty
                    <div class="p-4 text-center rounded-2xl neu-inset text-[11px] text-amber-800/80 font-medium">
                        Tidak ada peserta yang selesai dalam 7 hari ke depan.
                    </div>
                @endforelse
            </div>

            <a href="{{ route('admin.students.index') }}" class="mt-3.5 inline-flex items-center gap-1.5 text-xs font-bold text-[#C2410C] hover:text-amber-950 transition-colors">
                Lihat Semua Jadwal Selesai
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </section>


        {{-- ========================================================
             MODUL 6: EKSPOR & INFO SISTEM (Section Bawah Kanan #3)
             Kartu Biru Solid di Pojok Kanan Bawah
             Order: Mobile 6 | Desktop Col 8-12
        ======================================================== --}}
        <section
            style="--i: 11;"
            class="order-6 lg:order-6 lg:col-span-5 xl:col-span-4 neu-primary p-5 sm:p-6 rounded-3xl relative overflow-hidden"
            aria-label="Info Ekspor Sistem"
        >
            {{-- Radial subtle decorative light --}}
            <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-white/15 blur-xl"></div>

            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1 rounded-full bg-white/20 px-3 py-1 text-[10px] font-extrabold text-white tracking-wide uppercase backdrop-blur-xs">
                        <i data-lucide="file-spreadsheet" class="w-3 h-3 text-emerald-300"></i>
                        Ekspor Resmi
                    </span>
                    <span class="text-[10px] text-blue-100 font-semibold">Format Excel</span>
                </div>

                <h3 class="text-base sm:text-lg font-black text-white mt-2.5 leading-tight">Rekapitulasi Nilai & Data</h3>
                <p class="text-xs text-blue-100 mt-1 leading-relaxed font-medium">
                    Unduh laporan komprehensif data siswa, mahasiswa, dan nilai aspek dalam satu berkas Excel terstruktur.
                </p>

                {{-- Status Ringkas --}}
                <div class="mt-4 p-3 rounded-2xl bg-white/15 flex items-center justify-between text-xs backdrop-blur-xs">
                    <span class="text-blue-100 font-medium">Total Terdata:</span>
                    <span class="font-extrabold text-white">{{ $totalStudents }} Peserta</span>
                </div>

                {{-- Action Button (Neumorphic Inverted Button) --}}
                <a
                    href="{{ route('admin.export.index') }}"
                    class="mt-4 w-full flex items-center justify-center gap-2 rounded-2xl bg-white px-4 py-3 text-xs font-black text-[#3B52F6] hover:bg-blue-50 transition-all duration-200 active:scale-[0.98] shadow-lg"
                >
                    <i data-lucide="download" class="w-4 h-4 text-[#3B52F6]"></i>
                    Buka Halaman Ekspor
                </a>
            </div>
        </section>

    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Initialise Lucide icons
        if (typeof window.initLucide === 'function') {
            window.initLucide();
        }

        // 2. Count-up Animation for Numeric Metrics
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const counters = document.querySelectorAll('.metric-counter');

        counters.forEach(counter => {
            const target = parseInt(counter.dataset.target, 10);
            if (isNaN(target)) return;

            if (prefersReducedMotion) {
                counter.textContent = target.toLocaleString('id-ID');
                return;
            }

            let start = 0;
            const duration = 750;
            const startTime = performance.now();

            function step(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const ease = 1 - Math.pow(1 - progress, 3);
                const current = Math.floor(ease * target);
                counter.textContent = current.toLocaleString('id-ID');

                if (progress < 1) {
                    requestAnimationFrame(step);
                } else {
                    counter.textContent = target.toLocaleString('id-ID');
                }
            }
            requestAnimationFrame(step);
        });

        // 3. Hybrid Bar-Line Chart dengan Gradasi Halus (Chart.js)
        const chartCanvas = document.getElementById('diskominfoHybridChart');
        if (chartCanvas && typeof window.Chart !== 'undefined') {
            const ctx = chartCanvas.getContext('2d');

            // Gradient for Line fill
            const lineGradient = ctx.createLinearGradient(0, 0, 0, 240);
            lineGradient.addColorStop(0, 'rgba(59, 130, 246, 0.35)');
            lineGradient.addColorStop(1, 'rgba(235, 240, 247, 0.00)');

            // Gradient for Bar fill
            const barGradient = ctx.createLinearGradient(0, 0, 0, 240);
            barGradient.addColorStop(0, 'rgba(180, 195, 215, 0.9)');
            barGradient.addColorStop(1, 'rgba(235, 240, 247, 0.35)');

            @php
                $chartLabels = $departments->pluck('code')->toArray();
                $chartTotals = $departments->pluck('students_count')->toArray();
                $chartActives = $departments->pluck('active_count')->toArray();
                $chartFullNames = $departments->pluck('name')->toArray();
            @endphp

            const labels = @json($chartLabels);
            const totalsData = @json($chartTotals);
            const activesData = @json($chartActives);
            const fullNames = @json($chartFullNames);

            new window.Chart(ctx, {
                data: {
                    labels: labels.length ? labels : ['IKP', 'TIK', 'SP', 'SEK'],
                    datasets: [
                        {
                            type: 'line',
                            label: 'Peserta Aktif',
                            data: activesData.length ? activesData : [4, 6, 3, 2],
                            borderColor: '#3B52F6',
                            borderWidth: 2.8,
                            fill: true,
                            backgroundColor: lineGradient,
                            tension: 0.38,
                            pointRadius: 4.5,
                            pointBackgroundColor: '#3B52F6',
                            pointHoverRadius: 7,
                            pointHoverBackgroundColor: '#FFFFFF',
                            pointHoverBorderColor: '#3B52F6',
                            pointHoverBorderWidth: 2.5,
                            order: 1
                        },
                        {
                            type: 'bar',
                            label: 'Total Peserta',
                            data: totalsData.length ? totalsData : [10, 14, 8, 5],
                            backgroundColor: barGradient,
                            borderRadius: 8,
                            borderSkipped: false,
                            barPercentage: 0.5,
                            order: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: prefersReducedMotion ? false : {
                        duration: 750,
                        easing: 'easeOutQuart'
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0F172A',
                            titleColor: '#FFFFFF',
                            bodyColor: '#E2E8F0',
                            padding: 10,
                            cornerRadius: 12,
                            boxPadding: 4,
                            callbacks: {
                                title: function(contexts) {
                                    const index = contexts[0].dataIndex;
                                    return fullNames[index] || contexts[0].label;
                                },
                                label: function(context) {
                                    return ` ${context.dataset.label}: ${context.raw} orang`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#64748B',
                                font: {
                                    size: 11,
                                    family: "'Plus Jakarta Sans', sans-serif",
                                    weight: 700
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(197, 208, 222, 0.45)'
                            },
                            ticks: {
                                color: '#64748B',
                                stepSize: 2,
                                font: {
                                    size: 10,
                                    weight: 600
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
