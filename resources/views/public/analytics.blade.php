<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Analytics & Statistik Siswa PRAKERIN — DISKOMINFO Kabupaten Pacitan.">

    <title>Analytics PRAKERIN — DISKOMINFO Pacitan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }

        @keyframes shimmer {
            0%   { background-position: 0% center; }
            100% { background-position: 200% center; }
        }
        .shimmer-text {
            background-size: 200% auto;
            animation: shimmer 6s linear infinite;
        }

        .js-bar { transform-origin: left center; }
        .orb { will-change: transform; }

        .dot-grid {
            background-image: radial-gradient(#c9d5e5 1px, transparent 1px);
            background-size: 22px 22px;
            mask-image: radial-gradient(ellipse at 50% 0%, #000 0%, transparent 70%);
            -webkit-mask-image: radial-gradient(ellipse at 50% 0%, #000 0%, transparent 70%);
        }

        @media (prefers-reduced-motion: reduce) {
            .shimmer-text { animation: none; }
        }
    </style>
</head>

@php
    $clamp = fn ($v) => max(0, min(100, (float) $v));
    $pct   = fn ($v) => $totalStudents > 0 ? round(($v / $totalStudents) * 100) : 0;

    $avgValue       = (float) $average;
    $completionRate = $pct($completedStudents);

    $aspectsList = $aspects->map(function ($a) use ($clamp) {
        return [
            'label' => $a->name,
            'key' => $a->key,
            'val' => $clamp($a->scores_avg_score ?? 0),
        ];
    });

    $hasAssessments = $totalAssessments > 0;
    $bestAspect     = $hasAssessments ? $aspectsList->sortByDesc('val')->first() : null;
    $lowestAspect   = $hasAssessments ? $aspectsList->sortBy('val')->first() : null;

    $stats = [
        ['label' => 'Total Peserta', 'value' => $totalStudents,     'icon' => 'users-round', 'tint' => '#eef3fa', 'border' => '#dde7f5', 'color' => '#365b88', 'to' => '#8ba8ca', 'share' => 100],
        ['label' => 'Sedang Aktif',  'value' => $activeStudents,    'icon' => 'activity',    'tint' => '#eaf7f9', 'border' => '#d5edf0', 'color' => '#2d7d8f', 'to' => '#7fc6d0', 'share' => $pct($activeStudents)],
        ['label' => 'Selesai PKL',   'value' => $completedStudents, 'icon' => 'check-check', 'tint' => '#e9f7ee', 'border' => '#d0eddb', 'color' => '#2d7a4f', 'to' => '#7ecf9e', 'share' => $pct($completedStudents)],
    ];

    /* Gauge rata-rata */
    $gaugeR    = 52;
    $gaugeCirc = 2 * M_PI * $gaugeR;
    $gaugeDash = $gaugeCirc * ($clamp($avgValue) / 100);

    /* Donut */
    $segments = [
        ['label' => 'Aktif',       'value' => $activeStudents,    'color' => '#2d7d8f'],
        ['label' => 'Selesai PKL', 'value' => $completedStudents, 'color' => '#2d7a4f'],
    ];
    $donutR    = 72;
    $donutCirc = 2 * M_PI * $donutR;
    $donutGap  = 5;
    $donutOff  = 0;
@endphp

<body
    x-data="{ mobileOpen: false, scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 20"
    class="min-h-screen overflow-x-hidden bg-[#f5f7fa] text-[#263449] antialiased selection:bg-[#dbe6f5]"
>

    {{-- BACKGROUND --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden" aria-hidden="true">
        <div class="orb orb-1 absolute -left-40 -top-40 h-[400px] w-[400px] rounded-full bg-[#dce7f5]/70 blur-[120px]"></div>
        <div class="orb orb-2 absolute -right-40 top-1/4 h-[420px] w-[420px] rounded-full bg-[#e3ecf7]/70 blur-[130px]"></div>
        <div class="orb orb-3 absolute bottom-0 left-1/3 h-[380px] w-[380px] rounded-full bg-[#dde7f3]/60 blur-[110px]"></div>
        <div class="dot-grid absolute inset-0 opacity-40"></div>
    </div>

    {{-- MAIN CONTAINER --}}
    <main class="relative mx-auto max-w-7xl px-4 pb-28 pt-24 sm:px-6 sm:pt-28 lg:px-8">

        {{-- HEADER --}}
        <header class="analytics-head mb-10 flex flex-col justify-between gap-6 lg:mb-12 lg:flex-row lg:items-end">
            <div class="max-w-2xl">
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-[#d8e2ef] bg-white/90 px-3.5 py-1.5 shadow-[0_2px_8px_rgba(35,57,84,0.04)] backdrop-blur-md">
                    <span class="flex h-2 w-2 rounded-full bg-[#365b88]"></span>
                    <span class="font-mono text-[10px] font-bold uppercase tracking-[0.16em] text-[#365b88]">Analytics & Statistik</span>
                </div>

                <h1 class="text-3xl font-extrabold tracking-tight text-[#263449] sm:text-4xl lg:text-5xl">
                    Performa & Statistik PRAKERIN
                </h1>

                <p class="mt-3 text-base leading-relaxed text-[#5a6e85]">
                    Evaluasi komprehensif peserta Praktik Kerja Industri dan Magang pada Dinas Komunikasi dan Informatika Kabupaten Pacitan.
                </p>
            </div>
        </header>

        {{-- STATS SECTION --}}
        <section class="mb-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                {{-- RATA-RATA KESELURUHAN (GAUGE) --}}
                <div class="relative overflow-hidden rounded-2xl border border-[#d5e2f0] bg-gradient-to-br from-[#1e3a5f] to-[#365b88] p-6 text-white shadow-[0_4px_20px_rgba(35,57,84,0.08)] sm:p-8 lg:col-span-4">
                    <div class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-white/10 blur-2xl"></div>

                    <p class="font-mono text-[10px] font-bold uppercase tracking-[0.16em] text-white/70">Rata-rata Nilai Evaluasi</p>

                    <div class="relative my-6 flex items-center justify-center">
                        <svg class="h-36 w-36 -rotate-90 transform" viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="{{ $gaugeR }}" stroke="rgba(255,255,255,0.15)" stroke-width="10" fill="none" />
                            <circle cx="60" cy="60" r="{{ $gaugeR }}" stroke="#ffffff" stroke-width="10" stroke-linecap="round" fill="none"
                                    stroke-dasharray="{{ $gaugeCirc }}" stroke-dashoffset="{{ $gaugeCirc - $gaugeDash }}" />
                        </svg>

                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <span class="text-3xl font-bold tracking-tight sm:text-4xl">{{ $avgValue }}</span>
                            <span class="font-mono text-[9px] uppercase tracking-wider text-white/60">Skor / 100</span>
                        </div>
                    </div>

                    <p class="relative text-center font-mono text-[10px] uppercase tracking-wider text-white/60">
                        Berdasarkan {{ $totalAssessments }} data penilaian
                    </p>
                </div>

                {{-- 3 KARTU STATUS --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 lg:col-span-8">
                    @foreach ($stats as $stat)
                        <div class="stat-card group overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-5 shadow-[0_4px_20px_rgba(35,57,84,0.055)] transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-mono text-[9px] font-bold uppercase tracking-[0.16em] text-[#8394a7]">{{ $stat['label'] }}</p>
                                    <div class="mt-3 text-3xl font-bold tracking-tight text-[#263449]">{{ $stat['value'] }}</div>
                                </div>
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl border"
                                     style="background: {{ $stat['tint'] }}; border-color: {{ $stat['border'] }}; color: {{ $stat['color'] }};">
                                    <i data-lucide="{{ $stat['icon'] }}" class="h-5 w-5"></i>
                                </div>
                            </div>

                            <div class="mt-5 flex items-center gap-3">
                                <div class="h-1.5 flex-1 overflow-hidden rounded-full" style="background: {{ $stat['tint'] }};">
                                    <div class="js-bar h-full rounded-full"
                                         style="width: {{ $stat['share'] }}%; background: linear-gradient(90deg, {{ $stat['color'] }}, {{ $stat['to'] }});"></div>
                                </div>
                                <span class="font-mono text-[10px] font-semibold text-[#8394a7]">{{ $stat['share'] }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ASPEK + DISTRIBUSI BIDANG --}}
        <div class="grid items-start gap-6 lg:grid-cols-2 lg:gap-8">
            {{-- RATA-RATA PER ASPEK DINAMIS --}}
            <section class="overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white shadow-[0_4px_20px_rgba(35,57,84,0.055)]">
                <div class="border-b border-[#e8edf3] px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-[#dde7f5] bg-[#eef3fa] text-[#365b88]">
                            <i data-lucide="bar-chart-3" class="h-4 w-4"></i>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-[#30425a]">Rata-rata Per Aspek Kinerja</h2>
                            <p class="font-mono text-[9px] uppercase tracking-[0.12em] text-[#8394a7]">aspect.averages</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-5 px-6 py-6">
                    @foreach ($aspectsList as $aspect)
                        <div>
                            <div class="mb-2 flex items-center justify-between gap-3">
                                <span class="text-xs font-semibold text-[#3d5470]">{{ $aspect['label'] }}</span>
                                <span class="font-mono text-xs font-bold text-[#263449]">
                                    {{ $aspect['val'] }}<span class="text-[#8394a7]">/100</span>
                                </span>
                            </div>
                            <div class="h-2 overflow-hidden rounded-full bg-[#f0f4f9]">
                                <div class="js-bar h-full rounded-full bg-blue-600"
                                     style="width: {{ $aspect['val'] }}%;"></div>
                            </div>
                        </div>
                    @endforeach

                    @unless ($hasAssessments)
                        <p class="rounded-xl border border-dashed border-[#dde7f5] bg-[#f9fbfe] py-5 text-center text-sm text-[#8394a7]">
                            Belum ada data penilaian.
                        </p>
                    @endunless
                </div>
            </section>

            {{-- DISTRIBUSI 4 BIDANG PENEMPATAN --}}
            <section class="overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white shadow-[0_4px_20px_rgba(35,57,84,0.055)]">
                <div class="border-b border-[#e8edf3] px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-[#dde7f5] bg-[#eef3fa] text-[#365b88]">
                            <i data-lucide="building-2" class="h-4 w-4"></i>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-[#30425a]">Distribusi Bidang Penempatan</h2>
                            <p class="font-mono text-[9px] uppercase tracking-[0.12em] text-[#8394a7]">department.distribution</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 px-6 py-6">
                    @foreach ($departments as $dept)
                        @php
                            $dPct = $totalStudents > 0 ? round(($dept->students_count / $totalStudents) * 100) : 0;
                        @endphp
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-slate-800">{{ $dept->name }}</span>
                                <span class="text-xs font-mono font-bold text-[#365b88]">{{ $dept->students_count }} Peserta</span>
                            </div>
                            <div class="h-2 overflow-hidden rounded-full bg-white border border-slate-200">
                                <div class="h-full rounded-full bg-blue-600" style="width: {{ $dPct }}%"></div>
                            </div>
                            <div class="mt-2 flex items-center justify-between text-[11px] text-slate-500">
                                <span class="text-emerald-700 font-medium">{{ $dept->active_count }} Sedang Aktif</span>
                                <span>{{ $dept->completed_count }} Selesai PKL</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

    </main>

    {{-- FLOATING NAVIGATION --}}
    @include('partials.navbar')

    {{-- PAGE TRANSITION --}}
    @include('partials.page-transition')

    <script src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide && typeof window.lucide.createIcons === 'function') {
                window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
            }
        });
    </script>
</body>
</html>