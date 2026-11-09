@extends('layouts/admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', '')

@section('content')
<div class="space-y-8">

    {{-- 4 Stat Metric Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Total Peserta --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Peserta</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalStudents }}</h3>
                <p class="text-[11px] text-slate-500 mt-1">
                    <span class="font-semibold text-blue-600">{{ $totalPrakerin }}</span> SMK &bull; <span class="font-semibold text-indigo-600">{{ $totalMagang }}</span> Mahasiswa
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

        {{-- Sedang Aktif --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Sedang Aktif</p>
                <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $activeStudents }}</h3>
                <p class="text-[11px] text-emerald-700/80 mt-1 flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Aktif di bidang
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="user-check" class="w-6 h-6"></i>
            </div>
        </div>

        {{-- Selesai --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Selesai PKL</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ $completedStudents }}</h3>
                <p class="text-[11px] text-slate-500 mt-1">Durasi tuntas</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                <i data-lucide="graduation-cap" class="w-6 h-6"></i>
            </div>
        </div>

        {{-- Rata-rata Nilai --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Rata-rata Nilai</p>
                <h3 class="text-2xl font-extrabold text-amber-600 mt-1">{{ $overallAvg }}</h3>
                <p class="text-[11px] text-slate-500 mt-1">{{ $totalAssessed }} peserta dinilai</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    {{-- Distribusi 4 Bidang Kominfo --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-base font-bold text-slate-900">Distribusi Bidang Penempatan</h2>
            </div>
            <a href="{{ route('admin.students.create') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Peserta</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($departments as $dept)
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-blue-300 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 uppercase">
                            {{ $dept->code }}
                        </span>
                        <span class="text-xs font-bold text-slate-700">{{ $dept->students_count }} Total</span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 leading-snug">{{ $dept->name }}</h3>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                        <span class="flex items-center gap-1.5 text-emerald-600 font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            {{ $dept->active_count }} Aktif
                        </span>
                        <span class="text-slate-400">
                            {{ $dept->completed_count }} Selesai
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Row: Ending Soon Alert & Recent Students Table --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Ending Soon / Perlu Perhatian (1 Kolom) --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Selesai Dalam 7 Hari</h2>
                    <p class="text-xs text-slate-500">Masa durasi PKL/Magang segera tuntas</p>
                </div>
            </div>

            @if ($endingSoon->isEmpty())
                <div class="flex-1 flex flex-col items-center justify-center p-6 text-center text-slate-400 border border-dashed border-slate-200 rounded-xl">
                    <i data-lucide="check-circle" class="w-8 h-8 text-slate-300 mb-2"></i>
                    <p class="text-xs font-medium">Tidak ada peserta yang selesai dalam 7 hari ke depan.</p>
                </div>
            @else
                <div class="space-y-3 flex-1 overflow-y-auto max-h-80 pr-1">
                    @foreach ($endingSoon as $item)
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                            <div class="overflow-hidden pr-2">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ $item->name }}</p>
                                <p class="text-[11px] text-slate-500 truncate">{{ $item->institution ?? '-' }}</p>
                                <p class="text-[10px] text-amber-600 font-semibold mt-0.5">
                                    Selesai: {{ $item->end_date->format('d M Y') }}
                                </p>
                            </div>
                            <a href="{{ route('admin.students.show', $item->id) }}"
                               class="shrink-0 p-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-300 transition-colors">
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Peserta Terbaru (2 Kolom) --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Peserta Terbaru</h2>
                        <p class="text-xs text-slate-500">Prakerin & Mahasiswa yang baru didaftarkan</p>
                    </div>
                </div>
                <a href="{{ route('admin.students.index') }}"
                   class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-semibold uppercase tracking-wider">
                            <th class="py-3 px-3">Peserta</th>
                            <th class="py-3 px-3">Tipe</th>
                            <th class="py-3 px-3">Bidang</th>
                            <th class="py-3 px-3">Status</th>
                            <th class="py-3 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentStudents as $student)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $student->photo_url }}"
                                             alt="{{ $student->name }}"
                                             class="w-8 h-8 rounded-full object-cover border border-slate-200 shrink-0">
                                        <div>
                                            <a href="{{ route('admin.students.show', $student->id) }}" class="font-bold text-slate-900 hover:text-blue-600 transition-colors">
                                                {{ $student->name }}
                                            </a>
                                            <p class="text-[11px] text-slate-500">{{ $student->institution ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-semibold {{ $student->type === 'magang' ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                        {{ $student->type_label }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 font-medium text-slate-700">
                                    {{ $student->department?->name ?? '-' }}
                                </td>
                                <td class="py-3 px-3">
                                    @include('components.admin.badge-status', ['status' => $student->status])
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <a href="{{ route('admin.students.show', $student->id) }}"
                                       class="inline-flex items-center px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-[11px] transition-colors">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400">Belum ada data peserta.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection