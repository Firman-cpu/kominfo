@extends('layouts/admin')

@section('title', 'Analitik & Statistik Admin')
@section('page-title', 'Analitik Dan Statistik')
@section('page-subtitle', 'Ikhtisar statistik sebaran peserta, performa evaluasi, dan kapasitas bidang dinas')

@section('content')
<div class="space-y-6">
    {{-- Filter Toolbar --}}
    <div class="neu-card p-6 rounded-3xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Filter Analitik</h3>
            <p class="text-xs text-slate-500">Sesuaikan periode tahun dan bidang untuk melihat data statistik spesifik</p>
        </div>

        <form method="GET" action="{{ route('admin.analytics.index') }}" class="flex items-center gap-3">
            <select name="year" onchange="this.form.submit()" class="neu-input px-3.5 py-2.5 rounded-xl text-xs text-slate-700 bg-[#ebf0f7]">
                <option value="">Semua Tahun</option>
                @foreach ($availableYears as $yr)
                    <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>
                        Tahun {{ $yr }}
                    </option>
                @endforeach
            </select>

            <select name="department_id" onchange="this.form.submit()" class="neu-input px-3.5 py-2.5 rounded-xl text-xs text-slate-700 bg-[#ebf0f7]">
                <option value="">Semua Bidang</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>

            @if (request()->hasAny(['year', 'department_id']))
                <a href="{{ route('admin.analytics.index') }}" class="neu-btn p-2.5 rounded-xl text-slate-600 hover:text-slate-900 text-xs transition-all shrink-0" title="Reset Filter">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                </a>
            @endif
        </form>
    </div>

    {{-- Metrics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="neu-card p-6 rounded-3xl relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Total Peserta</span>
                <div class="neu-card-sm w-9 h-9 rounded-xl flex items-center justify-center text-blue-600">
                    <i data-lucide="users" class="w-4 h-4"></i>
                </div>
            </div>
            <span class="text-3xl font-black text-slate-900 mt-1 block font-mono">{{ $totalCount }}</span>
            <span class="text-[11px] text-slate-500 mt-1 block">Peserta terdata sesuai filter</span>
        </div>

        <div class="neu-card p-6 rounded-3xl relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider block">Sedang Aktif</span>
                <div class="neu-card-sm w-9 h-9 rounded-xl flex items-center justify-center text-emerald-600">
                    <i data-lucide="activity" class="w-4 h-4"></i>
                </div>
            </div>
            <span class="text-3xl font-black text-emerald-600 mt-1 block font-mono">{{ $activeCount }}</span>
            <span class="text-[11px] text-emerald-700/80 mt-1 block">Sedang menjalani masa tugas praktik</span>
        </div>

        <div class="neu-card p-6 rounded-3xl relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Selesai Masa PKL</span>
                <div class="neu-card-sm w-9 h-9 rounded-xl flex items-center justify-center text-slate-600">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                </div>
            </div>
            <span class="text-3xl font-black text-slate-800 mt-1 block font-mono">{{ $completedCount }}</span>
            <span class="text-[11px] text-slate-500 mt-1 block">Telah menyelesaikan masa penugasan</span>
        </div>
    </div>

    {{-- Distribusi Bidang Table & Bars --}}
    <div class="neu-card p-6 md:p-8 rounded-3xl space-y-5">
        <div class="flex items-center gap-2.5 border-b border-slate-200/70 pb-4">
            <div class="neu-card-sm w-9 h-9 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-900">Distribusi Peserta Berdasarkan Bidang</h4>
                <p class="text-xs text-slate-500">Kapasitas dan serapan peserta pada unit kerja Diskominfo</p>
            </div>
        </div>

        <div class="space-y-4">
            @foreach ($byDept as $d)
                @php
                    $pct = $totalCount > 0 ? round(($d->students_count / $totalCount) * 100, 1) : 0;
                @endphp
                <div class="neu-card-sm p-4 rounded-2xl border border-white/70 space-y-2.5">
                    <div class="flex items-center justify-between text-xs font-bold">
                        <div class="flex items-center gap-2.5">
                            <div class="neu-card-sm w-8 h-8 rounded-lg flex items-center justify-center text-blue-600 shrink-0">
                                @if ($d->image_url)
                                    <img src="{{ $d->image_url }}" alt="{{ $d->name }}" class="w-5 h-5 object-contain">
                                @else
                                    <i data-lucide="{{ $d->icon }}" class="w-4 h-4"></i>
                                @endif
                            </div>
                            <span class="text-slate-800 font-bold">{{ $d->name }}</span>
                        </div>
                        <span class="text-slate-600 font-mono">{{ $d->students_count }} Peserta ({{ $pct }}%)</span>
                    </div>
                    <div class="neu-inset h-3.5 rounded-full p-0.5 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full transition-all duration-700" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
