@extends('layouts/admin')

@section('title', 'Analitik & Statistik Admin')
@section('page-title', 'Analitik Dan Statistik')
@section('page-subtitle', '')

@section('content')
<div class="space-y-6">
    {{-- Filter Toolbar --}}
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Filter Analitik</h3>
            <p class="text-xs text-slate-500">Sesuaikan periode tahun dan bidang untuk melihat data statistik</p>
        </div>

        <form method="GET" action="{{ route('admin.analytics.index') }}" class="flex items-center gap-3">
            <select name="year" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-700 bg-white">
                <option value="">Semua Tahun</option>
                @foreach ($availableYears as $yr)
                    <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>
                        Tahun {{ $yr }}
                    </option>
                @endforeach
            </select>

            <select name="department_id" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-700 bg-white">
                <option value="">Semua Bidang</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>

            @if (request()->hasAny(['year', 'department_id']))
                <a href="{{ route('admin.analytics.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs transition-colors shrink-0" title="Reset Filter">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                </a>
            @endif
        </form>
    </div>

    {{-- Metrics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Peserta Sesuai Filter</span>
            <span class="text-3xl font-extrabold text-slate-900 mt-2 block">{{ $totalCount }}</span>
            <span class="text-[11px] text-slate-400 mt-1 block">Peserta prakerin & magang</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-emerald-700 uppercase tracking-wider block">Sedang Aktif</span>
            <span class="text-3xl font-extrabold text-emerald-600 mt-2 block">{{ $activeCount }}</span>
            <span class="text-[11px] text-emerald-700/70 mt-1 block">Sedang menjalani masa tugas</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider block">Selesai Masa PKL</span>
            <span class="text-3xl font-extrabold text-slate-800 mt-2 block">{{ $completedCount }}</span>
            <span class="text-[11px] text-slate-400 mt-1 block">Telah menyelesaikan masa praktik</span>
        </div>
    </div>

    {{-- Distribusi Bidang Table & Bars --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        <h4 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
            <i data-lucide="bar-chart-2" class="w-4 h-4 text-blue-600"></i>
            <span>Distribusi Peserta Berdasarkan Bidang</span>
        </h4>

        <div class="space-y-4">
            @foreach ($byDept as $d)
                @php
                    $pct = $totalCount > 0 ? round(($d->students_count / $totalCount) * 100, 1) : 0;
                @endphp
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between text-xs font-semibold">
                        <span class="text-slate-800">{{ $d->name }}</span>
                        <span class="text-slate-600">{{ $d->students_count }} Peserta ({{ $pct }}%)</span>
                    </div>
                    <div class="w-full h-3 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-blue-600 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection