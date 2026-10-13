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
    /* ───────────── DATA HELPERS ───────────── */
    $clamp = fn ($v) => max(0, min(100, (float) $v));
    $pct   = fn ($v) => $totalStudents > 0 ? round(($v / $totalStudents) * 100) : 0;

    $avgValue       = (float) $average;
    $completionRate = $pct($completedStudents);

    $aspects = [
        ['label' => 'Kedisiplinan',   'key' => 'discipline',     'icon' => 'clock',          'from' => '#365b88', 'to' => '#8ba8ca'],
        ['label' => 'Tanggung Jawab', 'key' => 'responsibility', 'icon' => 'shield-check',   'from' => '#2d7d8f', 'to' => '#7fc6d0'],
        ['label' => 'Kerja Sama',     'key' => 'teamwork',       'icon' => 'users',          'from' => '#2d7a4f', 'to' => '#7ecf9e'],
        ['label' => 'Komunikasi',     'key' => 'communication',  'icon' => 'message-circle', 'from' => '#7a5d2d', 'to' => '#d4a96a'],
        ['label' => 'Inisiatif',      'key' => 'initiative',     'icon' => 'lightbulb',      'from' => '#6d4e9e', 'to' => '#b49dd8'],
        ['label' => 'Kualitas Kerja', 'key' => 'work_quality',   'icon' => 'award',          'from' => '#7d2d3c', 'to' => '#d08090'],
    ];

    $aspects = collect($aspects)->map(function ($a) use ($aspectAverages, $clamp) {
        $a['val'] = $clamp($aspectAverages[$a['key']] ?? 0);
        return $a;
    });

    $hasAssessments = $totalAssessments > 0;
    $bestAspect     = $hasAssessments ? $aspects->sortByDesc('val')->first() : null;
    $lowestAspect   = $hasAssessments ? $aspects->sortBy('val')->first() : null;

    $stats = [
        ['label' => 'Total Siswa', 'value' => $totalStudents,     'icon' => 'users-round', 'tint' => '#eef3fa', 'border' => '#dde7f5', 'color' => '#365b88', 'to' => '#8ba8ca', 'share' => 100],
        ['label' => 'Siswa Aktif', 'value' => $activeStudents,     'icon' => 'activity',    'tint' => '#eaf7f9', 'border' => '#d5edf0', 'color' => '#2d7d8f', 'to' => '#7fc6d0', 'share' => $pct($activeStudents)],
        ['label' => 'Selesai PKL', 'value' => $completedStudents,  'icon' => 'check-check', 'tint' => '#e9f7ee', 'border' => '#d0eddb', 'color' => '#2d7a4f', 'to' => '#7ecf9e', 'share' => $pct($completedStudents)],
        ['label' => 'Tidak Aktif', 'value' => $inactiveStudents,   'icon' => 'user-minus',  'tint' => '#f3eefd', 'border' => '#e5dff5', 'color' => '#6d4e9e', 'to' => '#b49dd8', 'share' => $pct($inactiveStudents)],
    ];

    /* Gauge rata-rata */
    $gaugeR    = 52;
    $gaugeCirc = 2 * M_PI * $gaugeR;
    $gaugeDash = $gaugeCirc * ($clamp($avgValue) / 100);

    /* Donut */
    $segments = [
        ['label' => 'Aktif',       'value' => $activeStudents,    'color' => '#2d7d8f'],
        ['label' => 'Selesai PKL', 'value' => $completedStudents, 'color' => '#2d7a4f'],
        ['label' => 'Tidak Aktif', 'value' => $inactiveStudents,  'color' => '#6d4e9e'],
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
        <div class="orb orb-2 absolute -right-40 top-[15%] h-[400px] w-[400px] rounded-full bg-[#d0e8f0]/70 blur-[120px]"></div>
        <div class="orb orb-3 absolute bottom-[-200px] left-[30%] h-[400px] w-[400px] rounded-full bg-[#e3e9f1]/60 blur-[120px]"></div>
        <div class="dot-grid absolute inset-x-0 top-0 h-[520px] opacity-60"></div>
    </div>


    <main class="relative mx-auto max-w-7xl px-4 pb-40 pt-16 sm:px-6 sm:pt-20 lg:px-8 lg:pt-24">

        {{-- ═════════════ HERO ═════════════ --}}
        <section class="analytics-head mb-12 lg:mb-16">
            <div class="mb-5 inline-flex items-center gap-2.5 rounded-lg border border-[#dce4ef] bg-white/90 px-3.5 py-2 shadow-sm backdrop-blur">
                <i data-lucide="chart-no-axes-combined" class="h-4 w-4 text-[#36577f]"></i>
                <span class="font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-[#526a87]">
                    Statistik PRAKERIN
                </span>
            </div>

            <div class="flex flex-col gap-10 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h1 class="max-w-3xl text-5xl font-bold leading-[0.98] tracking-[-0.065em] text-[#263449] sm:text-6xl lg:text-7xl">
                        ANALYTICS
                        <span class="shimmer-text mt-2 block bg-gradient-to-r from-[#1e3a5f] via-[#416b9e] to-[#294d78] bg-clip-text text-transparent">
                            SISWA PKL
                        </span>
                    </h1>

                    <p class="mt-6 max-w-2xl text-sm leading-7 text-[#718096] sm:text-base">
                        Ringkasan performa, statistik penilaian, dan data distribusi siswa
                        Praktik Kerja Lapangan di DISKOMINFO Kabupaten Pacitan secara transparan.
                    </p>
                </div>

                {{-- Quick insight chips --}}
                <div class="flex flex-wrap gap-3 lg:max-w-sm lg:justify-end">
                    <div class="rounded-xl border border-[#e0e7f0] bg-white/90 px-4 py-3 shadow-sm backdrop-blur">
                        <p class="font-mono text-[9px] font-bold uppercase tracking-[0.16em] text-[#8394a7]">Tingkat Selesai</p>
                        <p class="mt-1 text-lg font-bold text-[#263449]">{{ $completionRate }}%</p>
                    </div>
                    <div class="rounded-xl border border-[#e0e7f0] bg-white/90 px-4 py-3 shadow-sm backdrop-blur">
                        <p class="font-mono text-[9px] font-bold uppercase tracking-[0.16em] text-[#8394a7]">Aspek Terkuat</p>
                        <p class="mt-1 text-lg font-bold text-[#263449]">{{ $bestAspect['label'] ?? '—' }}</p>
                    </div>
                    <div class="rounded-xl border border-[#e0e7f0] bg-white/90 px-4 py-3 shadow-sm backdrop-blur">
                        <p class="font-mono text-[9px] font-bold uppercase tracking-[0.16em] text-[#8394a7]">Perlu Ditingkatkan</p>
                        <p class="mt-1 text-lg font-bold text-[#263449]">{{ $lowestAspect['label'] ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </section>


        {{-- ═════════════ RINGKASAN DATA ═════════════ --}}
        <section class="mb-10 lg:mb-14">
            <div class="mb-6 flex items-center gap-3">
                <span class="h-5 w-1 rounded-full bg-[#365b88]"></span>
                <h2 class="text-sm font-bold tracking-tight text-[#30425a] sm:text-base">Ringkasan Data</h2>
                <span class="h-px flex-1 bg-[#e8edf3]"></span>
                <span class="flex items-center gap-1.5 font-mono text-[9px] font-semibold uppercase tracking-wider text-[#8394a7]">
                    <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-[#456b97]"></span>
                    Live
                </span>
            </div>

            <div class="grid gap-4 lg:grid-cols-12">

                {{-- RATA-RATA (gauge) --}}
                <div class="stat-card relative overflow-hidden rounded-2xl border border-[#2c4a72] bg-gradient-to-br from-[#1e3a5f] via-[#263449] to-[#365b88] p-6 text-white shadow-[0_12px_40px_rgba(35,57,84,0.22)] transition-transform duration-300 hover:-translate-y-1 lg:col-span-4">
                    <div class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-white/10 blur-3xl"></div>

                    <div class="relative flex items-center justify-between">
                        <p class="font-mono text-[9px] font-bold uppercase tracking-[0.16em] text-white/55">Rata-rata Nilai</p>
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-white/15 bg-white/10 text-white/80">
                            <i data-lucide="star" class="h-4 w-4"></i>
                        </div>
                    </div>

                    <div class="relative mx-auto mt-6 h-40 w-40">
                        <svg viewBox="0 0 128 128" class="h-full w-full -rotate-90" aria-hidden="true">
                            <circle cx="64" cy="64" r="{{ $gaugeR }}" fill="none" stroke="rgba(255,255,255,0.12)" stroke-width="10"/>
                            <circle
                                class="js-gauge"
                                data-circ="{{ round($gaugeCirc, 2) }}"
                                data-dash="{{ round($gaugeDash, 2) }}"
                                cx="64" cy="64" r="{{ $gaugeR }}"
                                fill="none"
                                stroke="#9fc0e8"
                                stroke-width="10"
                                stroke-linecap="round"
                                stroke-dasharray="{{ round($gaugeDash, 2) }} {{ round($gaugeCirc, 2) }}"
                            />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            @if ($avgValue > 0)
                                <span class="text-4xl font-bold tracking-tight" data-counter="{{ $avgValue }}" data-decimals="1">{{ $average }}</span>
                            @else
                                <span class="text-4xl font-bold tracking-tight">—</span>
                            @endif
                            <span class="font-mono text-[9px] uppercase tracking-wider text-white/45">dari 100</span>
                        </div>
                    </div>

                    <p class="relative mt-6 text-center font-mono text-[10px] uppercase tracking-wider text-white/50">
                        Berdasarkan {{ $totalAssessments }} penilaian
                    </p>
                </div>

                {{-- 4 KARTU STATUS --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:col-span-8">
                    @foreach ($stats as $stat)
                        <div class="stat-card group overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-5 shadow-[0_4px_20px_rgba(35,57,84,0.055)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_12px_32px_rgba(35,57,84,0.1)]">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-mono text-[9px] font-bold uppercase tracking-[0.16em] text-[#8394a7]">{{ $stat['label'] }}</p>
                                    <div class="mt-3 text-4xl font-bold tracking-tight text-[#263449]" data-counter="{{ $stat['value'] }}">{{ $stat['value'] }}</div>
                                </div>
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl border transition-transform duration-300 group-hover:scale-110"
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


        {{-- ═════════════ ASPEK + PERINGKAT ═════════════ --}}
        <div class="grid items-start gap-6 lg:grid-cols-2 lg:gap-8">

            {{-- RATA-RATA PER ASPEK --}}
            <section class="overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white shadow-[0_4px_20px_rgba(35,57,84,0.055)]">
                <div class="border-b border-[#e8edf3] px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-[#dde7f5] bg-[#eef3fa] text-[#365b88]">
                            <i data-lucide="bar-chart-3" class="h-4 w-4"></i>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-[#30425a]">Rata-rata Per Aspek</h2>
                            <p class="font-mono text-[9px] uppercase tracking-[0.12em] text-[#8394a7]">aspect.averages</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 px-6 py-6">
                    @foreach ($aspects as $aspect)
                        <div>
                            <div class="mb-2.5 flex items-center justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-2.5">
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-white"
                                          style="background: linear-gradient(135deg, {{ $aspect['from'] }}, {{ $aspect['to'] }});">
                                        <i data-lucide="{{ $aspect['icon'] }}" class="h-3.5 w-3.5"></i>
                                    </span>
                                    <span class="truncate text-xs font-semibold text-[#3d5470]">{{ $aspect['label'] }}</span>

                                    @if ($hasAssessments && $bestAspect && $aspect['key'] === $bestAspect['key'])
                                        <span class="hidden rounded-full border border-[#d0eddb] bg-[#e9f7ee] px-2 py-0.5 font-mono text-[8px] font-bold uppercase tracking-wider text-[#2d7a4f] sm:inline">Tertinggi</span>
                                    @elseif ($hasAssessments && $lowestAspect && $aspect['key'] === $lowestAspect['key'])
                                        <span class="hidden rounded-full border border-[#f0dfc4] bg-[#fdf6e8] px-2 py-0.5 font-mono text-[8px] font-bold uppercase tracking-wider text-[#8a6420] sm:inline">Terendah</span>
                                    @endif
                                </div>
                                <span class="shrink-0 font-mono text-xs font-bold text-[#263449]">
                                    {{ $aspect['val'] }}<span class="text-[#8394a7]">/100</span>
                                </span>
                            </div>

                            <div class="h-2 overflow-hidden rounded-full bg-[#f0f4f9]">
                                <div class="js-bar h-full rounded-full"
                                     style="width: {{ $aspect['val'] }}%; background: linear-gradient(90deg, {{ $aspect['from'] }}, {{ $aspect['to'] }});"></div>
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


            {{-- TOP 5 SISWA --}}
            <section class="overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white shadow-[0_4px_20px_rgba(35,57,84,0.055)]">
                <div class="border-b border-[#e8edf3] px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-[#dde7f5] bg-[#eef3fa] text-[#365b88]">
                            <i data-lucide="trophy" class="h-4 w-4"></i>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-[#30425a]">Peringkat Terbaik</h2>
                            <p class="font-mono text-[9px] uppercase tracking-[0.12em] text-[#8394a7]">top.performers</p>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-[#f0f4f9]">
                    @forelse ($topStudents as $i => $student)
                        @php
                            $rankClass = match ($i) {
                                0 => 'bg-amber-100 text-amber-700 border-amber-200',
                                1 => 'bg-slate-100 text-slate-600 border-slate-200',
                                2 => 'bg-orange-50 text-orange-600 border-orange-200',
                                default => 'bg-[#f0f4f9] text-[#718096] border-[#e0e7f0]',
                            };
                            $studentAvg = $clamp($student['average']);
                        @endphp

                        <div class="flex items-center gap-4 px-6 py-4 transition-colors hover:bg-[#f9fbfe] {{ $i === 0 ? 'bg-gradient-to-r from-amber-50/60 to-transparent' : '' }}">

                            {{-- Rank --}}
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border text-xs font-bold {{ $rankClass }}">
                                @if ($i === 0)
                                    <i data-lucide="crown" class="h-3.5 w-3.5"></i>
                                @else
                                    {{ $i + 1 }}
                                @endif
                            </div>

                            {{-- Avatar --}}
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#dde7f5] bg-[#eef3fa] text-sm font-bold text-[#365b88]">
                                {{ strtoupper(substr($student['name'], 0, 1)) }}
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold text-[#263449]">{{ $student['name'] }}</p>
                                <p class="truncate font-mono text-[10px] text-[#8394a7]">{{ $student['major'] }} · {{ $student['count'] }} penilaian</p>
                                <div class="mt-2 h-1 overflow-hidden rounded-full bg-[#f0f4f9]">
                                    <div class="js-bar h-full rounded-full bg-gradient-to-r from-[#365b88] to-[#8ba8ca]"
                                         style="width: {{ $studentAvg }}%"></div>
                                </div>
                            </div>

                            <div class="shrink-0 text-right">
                                <span class="text-lg font-bold text-[#263449]">{{ $student['average'] }}</span>
                                <p class="font-mono text-[9px] text-[#8394a7]">/ 100</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center gap-3 px-6 py-12 text-center">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-[#e0e7f0] bg-[#f5f7fa] text-[#8394a7]">
                                <i data-lucide="inbox" class="h-6 w-6"></i>
                            </div>
                            <p class="text-sm text-[#8394a7]">Belum ada data penilaian siswa.</p>
                        </div>
                    @endforelse
                </div>

                @if ($topStudents->count() > 0)
                    <div class="border-t border-[#e8edf3] px-6 py-4">
                        <a href="{{ route('students.index') }}"
                           class="group inline-flex items-center gap-2 text-xs font-semibold text-[#365b88] transition hover:text-[#263449]">
                            Lihat semua siswa
                            <i data-lucide="arrow-right" class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                @endif
            </section>

        </div>


        {{-- ═════════════ DISTRIBUSI STATUS ═════════════ --}}
        <section class="mt-6 overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white shadow-[0_4px_20px_rgba(35,57,84,0.055)] lg:mt-8">
            <div class="border-b border-[#e8edf3] px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-[#dde7f5] bg-[#eef3fa] text-[#365b88]">
                        <i data-lucide="pie-chart" class="h-4 w-4"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-[#30425a]">Distribusi Status Siswa</h2>
                        <p class="font-mono text-[9px] uppercase tracking-[0.12em] text-[#8394a7]">student.distribution</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-center gap-10 px-6 py-10 md:flex-row md:justify-center md:gap-16">

                {{-- Donut --}}
                <div class="relative h-52 w-52 shrink-0">
                    <svg viewBox="0 0 192 192" class="h-full w-full -rotate-90" role="img" aria-label="Distribusi status siswa">
                        <circle cx="96" cy="96" r="{{ $donutR }}" fill="none" stroke="#f0f4f9" stroke-width="22"/>

                        @foreach ($segments as $seg)
                            @php
                                $share = $totalStudents > 0 ? $seg['value'] / $totalStudents : 0;
                                $len   = $donutCirc * $share;
                                $dash  = $share > 0 && $share < 1 ? max($len - $donutGap, 0) : $len;
                                $rest  = $donutCirc - $dash;
                            @endphp

                            @if ($share > 0)
                                <circle
                                    class="js-seg"
                                    data-circ="{{ round($donutCirc, 2) }}"
                                    data-dash="{{ round($dash, 2) }}"
                                    data-rest="{{ round($rest, 2) }}"
                                    cx="96" cy="96" r="{{ $donutR }}"
                                    fill="none"
                                    stroke="{{ $seg['color'] }}"
                                    stroke-width="22"
                                    stroke-linecap="butt"
                                    stroke-dasharray="{{ round($dash, 2) }} {{ round($rest, 2) }}"
                                    stroke-dashoffset="{{ round(-$donutOff * $donutCirc, 2) }}"
                                />
                            @endif
                            @php $donutOff += $share; @endphp
                        @endforeach
                    </svg>

                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-4xl font-bold tracking-tight text-[#263449]">{{ $totalStudents }}</span>
                        <span class="font-mono text-[9px] uppercase tracking-wider text-[#8394a7]">Total Siswa</span>
                    </div>
                </div>

                {{-- Legend --}}
                <div class="w-full max-w-sm space-y-4">
                    @foreach ($segments as $seg)
                        <div>
                            <div class="mb-1.5 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2.5">
                                    <span class="h-3 w-3 shrink-0 rounded-full" style="background: {{ $seg['color'] }}"></span>
                                    <span class="text-sm font-semibold text-[#263449]">{{ $seg['label'] }}</span>
                                </div>
                                <span class="font-mono text-xs text-[#8394a7]">
                                    {{ $seg['value'] }} siswa
                                    <span class="text-[#aab4bf]">({{ $pct($seg['value']) }}%)</span>
                                </span>
                            </div>
                            <div class="h-1.5 overflow-hidden rounded-full bg-[#f0f4f9]">
                                <div class="js-bar h-full rounded-full" style="width: {{ $pct($seg['value']) }}%; background: {{ $seg['color'] }};"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>


        {{-- ═════════════ CTA ═════════════ --}}
        <section class="relative mt-6 overflow-hidden rounded-2xl border border-[#d5e2f0] bg-gradient-to-br from-[#1e3a5f] to-[#365b88] px-6 py-9 text-white shadow-[0_8px_30px_rgba(35,57,84,0.15)] sm:px-10 lg:mt-8">
            <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>

            <div class="relative flex flex-col items-start gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold sm:text-2xl">Ingin melihat profil lengkap siswa?</h2>
                    <p class="mt-1.5 text-sm text-white/70">Lihat daftar seluruh siswa PRAKERIN beserta data detail mereka.</p>
                </div>
                <a href="{{ route('students.index') }}"
                   class="inline-flex shrink-0 items-center gap-2.5 rounded-xl border border-white/20 bg-white/10 px-5 py-3 text-sm font-semibold text-white backdrop-blur-sm transition hover:-translate-y-0.5 hover:bg-white/20">
                    <i data-lucide="users" class="h-4 w-4"></i>
                    Lihat Data Siswa
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
            </div>
        </section>

    </main>


    {{-- FLOATING NAVIGATION --}}
    @include('partials.navbar')

    {{-- PAGE TRANSITION --}}
    @include('partials.page-transition')


    {{-- CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
        }

        if (!window.gsap || !window.ScrollTrigger) return;

        // Hormati preferensi reduced motion: biarkan semua nilai tampil statis
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        gsap.registerPlugin(ScrollTrigger);

        const ctx = gsap.context(function () {

            /* ENTRANCE */
            gsap.from('.analytics-head', {
                y: 30, opacity: 0, duration: 0.7, delay: 0.1, ease: 'power3.out'
            });

            /* STAT CARDS (stagger per batch, hover tetap aman karena clearProps) */
            gsap.set('.stat-card', { opacity: 0, y: 25 });
            ScrollTrigger.batch('.stat-card', {
                start: 'top 90%',
                once: true,
                onEnter: function (batch) {
                    gsap.to(batch, {
                        opacity: 1, y: 0, duration: 0.6, stagger: 0.08,
                        ease: 'power2.out', overwrite: true,
                        clearProps: 'transform,opacity'
                    });
                }
            });

            /* PROGRESS BARS */
            gsap.utils.toArray('.js-bar').forEach(function (bar) {
                gsap.from(bar, {
                    scaleX: 0,
                    duration: 1.1,
                    ease: 'power3.out',
                    scrollTrigger: { trigger: bar, start: 'top 95%', once: true }
                });
            });

            /* GAUGE RATA-RATA */
            gsap.utils.toArray('.js-gauge').forEach(function (el) {
                const circ = el.dataset.circ;
                const dash = el.dataset.dash;
                gsap.fromTo(el,
                    { attr: { 'stroke-dasharray': '0 ' + circ } },
                    {
                        attr: { 'stroke-dasharray': dash + ' ' + circ },
                        duration: 1.4, ease: 'power3.out',
                        scrollTrigger: { trigger: el, start: 'top 92%', once: true }
                    }
                );
            });

            /* DONUT SEGMENTS */
            gsap.utils.toArray('.js-seg').forEach(function (el, i) {
                const circ = el.dataset.circ;
                gsap.fromTo(el,
                    { attr: { 'stroke-dasharray': '0 ' + circ } },
                    {
                        attr: { 'stroke-dasharray': el.dataset.dash + ' ' + el.dataset.rest },
                        duration: 1.1, delay: i * 0.12, ease: 'power2.out',
                        scrollTrigger: { trigger: el, start: 'top 92%', once: true }
                    }
                );
            });

            /* COUNTERS */
            document.querySelectorAll('[data-counter]').forEach(function (el) {
                const target   = parseFloat(el.dataset.counter) || 0;
                const decimals = parseInt(el.dataset.decimals || '0', 10);
                const obj = { val: 0 };

                el.textContent = (0).toFixed(decimals);

                gsap.to(obj, {
                    val: target,
                    duration: 1.4,
                    ease: 'power2.out',
                    scrollTrigger: { trigger: el, start: 'top 92%', once: true },
                    onUpdate: function () {
                        el.textContent = obj.val.toFixed(decimals);
                    },
                    onComplete: function () {
                        el.textContent = target.toFixed(decimals);
                    }
                });
            });

            /* AMBIENT ORBS */
            gsap.to('.orb-1', { x: 30,  y: 20,  duration: 14, repeat: -1, yoyo: true, ease: 'sine.inOut' });
            gsap.to('.orb-2', { x: -25, y: 25,  duration: 16, repeat: -1, yoyo: true, ease: 'sine.inOut' });
            gsap.to('.orb-3', { x: 15,  y: -20, duration: 18, repeat: -1, yoyo: true, ease: 'sine.inOut' });

        });

        // Cleanup saat pindah halaman
        window.addEventListener('pagehide', function () { ctx.revert(); });
    });
    </script>

</body>
</html>