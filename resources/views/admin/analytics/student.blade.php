<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $student->name }} — Analytics PRAKERIN DISKOMINFO.">

    <title>{{ $student->name }} — Analytics</title>

    {{-- Preconnect --}}
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Pre-hide SEBELUM paint --}}
    <script>
        document.documentElement.classList.add('gsap-init');
    </script>

    <style>
        [x-cloak] { display: none !important; }

        html.gsap-init [data-anim] { opacity: 0; }

        @keyframes shimmer {
            0%   { background-position: 0% center; }
            100% { background-position: 200% center; }
        }
        .shimmer-text {
            background-size: 200% auto;
            animation: shimmer 6s linear infinite;
        }

        /* Orb pakai radial-gradient — 0 cost GPU */
        .orb {
            will-change: transform;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
        }
        .orb-1 {
            background: radial-gradient(circle,
                rgba(14, 165, 233, 0.28) 0%,
                rgba(14, 165, 233, 0.14) 35%,
                rgba(14, 165, 233, 0.04) 60%,
                transparent 75%);
        }
        .orb-2 {
            background: radial-gradient(circle,
                rgba(34, 211, 238, 0.22) 0%,
                rgba(34, 211, 238, 0.1) 38%,
                rgba(34, 211, 238, 0.03) 62%,
                transparent 78%);
        }
        .orb-3 {
            background: radial-gradient(circle,
                rgba(59, 130, 246, 0.24) 0%,
                rgba(59, 130, 246, 0.1) 38%,
                rgba(59, 130, 246, 0.03) 62%,
                transparent 78%);
        }

        .stat-item,
        .chart-card,
        .aspect-item,
        .assess-card,
        .insight-card {
            will-change: transform;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
        }

        .chart-wrap-radar  { position: relative; height: 420px; width: 100%; }
        .chart-wrap-history { position: relative; height: 320px; width: 100%; }
    </style>

    {{-- Libs di HEAD + defer --}}
    <script defer src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
</head>

<body class="min-h-screen overflow-x-hidden bg-[#0a1520] text-slate-100 antialiased selection:bg-sky-400/30">

    {{-- BACKGROUND — ICE ATMOSPHERE --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="orb orb-1 absolute -left-40 -top-40 h-[500px] w-[500px] rounded-full"></div>
        <div class="orb orb-2 absolute -right-40 top-[18%] h-[500px] w-[500px] rounded-full"></div>
        <div class="orb orb-3 absolute bottom-[-250px] left-[35%] h-[500px] w-[500px] rounded-full"></div>

        <div class="absolute inset-0 opacity-[0.05] [background-image:linear-gradient(rgba(186,230,253,1)_1px,transparent_1px),linear-gradient(90deg,rgba(186,230,253,1)_1px,transparent_1px)] [background-size:56px_56px] [mask-image:linear-gradient(to_bottom,black,transparent_70%)]"></div>

        <div class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2 bg-gradient-to-r from-transparent via-sky-400/60 to-transparent"></div>
    </div>


    <main class="relative mx-auto max-w-6xl px-4 pb-20 pt-12 sm:px-6 sm:pt-16 lg:px-8 lg:pb-28">

        {{-- BACK --}}
        <a
            data-anim
            href="{{ route('admin.analytics.index') }}"
            class="group inline-flex items-center gap-2.5 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-4 py-2 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/40 hover:bg-sky-400/[0.14]"
        >
            <i data-lucide="arrow-left" class="h-3.5 w-3.5 text-sky-300 transition group-hover:-translate-x-0.5"></i>
            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                Kembali ke Analytics
            </span>
        </a>


        {{-- HEADER / IDENTITY --}}
        <section
            data-anim
            class="profile-card relative mt-6 overflow-hidden rounded-3xl border border-sky-200/[0.12] bg-[#0f1b2c]/80 p-6 shadow-2xl shadow-black/50 backdrop-blur-xl sm:p-10"
        >
            <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-sky-400/50 to-transparent"></div>
            <div class="pointer-events-none absolute -right-24 -top-24 h-64 w-64 rounded-full bg-sky-500/10 blur-[100px]"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-20 h-64 w-64 rounded-full bg-cyan-400/10 blur-[110px]"></div>

            <div class="relative">

                <div class="mb-7 inline-flex items-center gap-2 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-3 py-1.5">
                    <i data-lucide="user-round-search" class="h-3.5 w-3.5 text-sky-300"></i>
                    <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                        student.analytics.detail
                    </span>
                </div>

                <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
                    <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 via-cyan-400 to-blue-500 text-3xl font-black text-white shadow-xl shadow-sky-500/30">
                        {{ strtoupper(substr($student->name, 0, 1)) }}
                    </div>

                    <div class="min-w-0">
                        <h1 class="text-4xl font-black leading-[0.95] tracking-[-0.045em] text-white sm:text-5xl">
                            {{ $student->name }}
                        </h1>

                        <div class="mt-3 flex flex-wrap gap-x-5 gap-y-1 font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500">
                            <span>NIS <span class="text-sky-200">{{ $student->nis }}</span></span>
                            <span>Jurusan <span class="text-sky-200">{{ $student->major }}</span></span>
                            <span>Kelas <span class="text-sky-200">{{ $student->class }}</span></span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 h-px w-full bg-gradient-to-r from-sky-400/30 via-cyan-300/10 to-transparent"></div>

                {{-- OVERALL PERFORMANCE --}}
                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                    <div class="stat-item group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-sky-100/[0.03] p-5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-sky-300/30">
                        <div class="flex items-start justify-between">
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                Overall Performance
                            </span>
                            <i data-lucide="gauge" class="h-4 w-4 text-sky-300"></i>
                        </div>
                        <div class="mt-3 flex items-baseline gap-1.5">
                            <span class="text-4xl font-black tracking-tight text-white" data-counter="{{ (int) round($average) }}">{{ $average }}</span>
                            <span class="font-mono text-xs text-slate-500">/ 100</span>
                        </div>
                    </div>

                    <div class="stat-item group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-sky-100/[0.03] p-5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-teal-300/30">
                        <div class="flex items-start justify-between">
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                Kategori
                            </span>
                            <i data-lucide="badge-check" class="h-4 w-4 text-teal-300"></i>
                        </div>
                        <div class="mt-3 text-3xl font-black tracking-tight text-teal-200">
                            {{ $category }}
                        </div>
                    </div>

                    <div class="stat-item sm:col-span-2 lg:col-span-1 group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-sky-100/[0.03] p-5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-cyan-300/30">
                        <div class="flex items-start justify-between">
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                Deskripsi
                            </span>
                            <i data-lucide="info" class="h-4 w-4 text-cyan-300"></i>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-300">
                            {{ $description }}
                        </p>
                    </div>

                </div>
            </div>
        </section>


        {{-- INSIGHT --}}
        <section class="mt-12">
            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    performance.insight
                </span>
                <span class="h-px flex-1 bg-sky-200/[0.08]"></span>
            </div>

            <div class="grid gap-4 md:grid-cols-2">

                {{-- STRONGEST --}}
                <div data-anim class="insight-card group relative overflow-hidden rounded-2xl border border-teal-300/20 bg-[#0f1b2c]/80 p-6 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-teal-300/40">
                    <div class="pointer-events-none absolute -right-20 -top-20 h-48 w-48 rounded-full bg-teal-400/15 blur-3xl"></div>

                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-teal-300">
                                Kekuatan Utama
                            </span>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-teal-300/20 bg-teal-300/[0.1]">
                                <i data-lucide="trending-up" class="h-4 w-4 text-teal-300"></i>
                            </div>
                        </div>

                        @if ($strongestAspect)
                            <div class="mt-5 text-3xl font-black tracking-tight text-white">
                                {{ $strongestAspect['label'] }}
                            </div>
                            <div class="mt-2 font-mono text-sm text-teal-200">
                                {{ $strongestAspect['score'] }}
                            </div>
                        @else
                            <div class="mt-5 font-mono text-[10px] uppercase tracking-[0.18em] text-slate-500">
                                Belum ada data.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- WEAKEST --}}
                <div data-anim class="insight-card group relative overflow-hidden rounded-2xl border border-amber-300/20 bg-[#0f1b2c]/80 p-6 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-amber-300/40">
                    <div class="pointer-events-none absolute -right-20 -top-20 h-48 w-48 rounded-full bg-amber-400/10 blur-3xl"></div>

                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-amber-300">
                                Perlu Perhatian
                            </span>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-amber-300/20 bg-amber-300/[0.1]">
                                <i data-lucide="alert-circle" class="h-4 w-4 text-amber-300"></i>
                            </div>
                        </div>

                        @if ($weakestAspect)
                            <div class="mt-5 text-3xl font-black tracking-tight text-white">
                                {{ $weakestAspect['label'] }}
                            </div>
                            <div class="mt-2 font-mono text-sm text-amber-200">
                                {{ $weakestAspect['score'] }}
                            </div>
                        @else
                            <div class="mt-5 font-mono text-[10px] uppercase tracking-[0.18em] text-slate-500">
                                Belum ada data.
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </section>


        {{-- RADAR CHART --}}
        <section class="mt-12">
            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    performance.analysis
                </span>
                <span class="h-px flex-1 bg-sky-200/[0.08]"></span>
            </div>

            <div data-anim class="chart-card relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl sm:p-7">
                <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-sky-500/10 blur-[100px]"></div>

                <div class="relative">
                    <div class="mb-4 flex items-center gap-2">
                        <i data-lucide="radar" class="h-4 w-4 text-sky-300"></i>
                        <span class="font-mono text-[10px] font-bold uppercase tracking-[0.18em] text-slate-400">
                            Radar Profil Aspek
                        </span>
                    </div>

                    <div class="chart-wrap-radar">
                        <canvas id="radarChart"></canvas>
                    </div>
                </div>
            </div>
        </section>


        {{-- HISTORY CHART --}}
        <section class="mt-12">
            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    performance.history
                </span>
                <span class="h-px flex-1 bg-sky-200/[0.08]"></span>
            </div>

            <div data-anim class="chart-card relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl sm:p-7">
                <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-cyan-500/10 blur-[100px]"></div>

                <div class="relative">
                    <div class="mb-4 flex items-center gap-2">
                        <i data-lucide="activity" class="h-4 w-4 text-cyan-300"></i>
                        <span class="font-mono text-[10px] font-bold uppercase tracking-[0.18em] text-slate-400">
                            Tren Skor Performa
                        </span>
                    </div>

                    <div class="chart-wrap-history">
                        <canvas id="historyChart"></canvas>
                    </div>
                </div>
            </div>
        </section>


        {{-- ASPECT DETAILS --}}
        <section class="mt-12">
            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    aspect.averages
                </span>
                <span class="h-px flex-1 bg-sky-200/[0.08]"></span>
            </div>

            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">

                @php
                    $aspects = [
                        ['label' => 'Kedisiplinan',   'value' => $aspectAverages['discipline'],     'icon' => 'shield',         'accent' => 'sky'],
                        ['label' => 'Tanggung Jawab', 'value' => $aspectAverages['responsibility'], 'icon' => 'target',         'accent' => 'cyan'],
                        ['label' => 'Kerja Sama',     'value' => $aspectAverages['teamwork'],       'icon' => 'handshake',      'accent' => 'blue'],
                        ['label' => 'Komunikasi',     'value' => $aspectAverages['communication'],  'icon' => 'message-square', 'accent' => 'teal'],
                        ['label' => 'Inisiatif',      'value' => $aspectAverages['initiative'],     'icon' => 'lightbulb',      'accent' => 'sky'],
                        ['label' => 'Kualitas Kerja', 'value' => $aspectAverages['work_quality'],   'icon' => 'award',          'accent' => 'cyan'],
                    ];
                @endphp

                @foreach ($aspects as $aspect)
                    <div data-anim class="aspect-item group relative overflow-hidden rounded-2xl border border-sky-200/[0.08] bg-[#0f1b2c]/70 p-4 backdrop-blur-xl transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/25 hover:bg-[#0f1b2c]/90">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                {{ $aspect['label'] }}
                            </span>
                            <i data-lucide="{{ $aspect['icon'] }}" class="h-3.5 w-3.5 text-{{ $aspect['accent'] }}-300"></i>
                        </div>
                        <div class="mt-3 text-2xl font-black tracking-tight text-white">
                            {{ $aspect['value'] }}
                        </div>
                    </div>
                @endforeach

            </div>
        </section>


        {{-- ASSESSMENT HISTORY --}}
        <section class="mt-12">
            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    assessment.history
                </span>
                <span class="h-px flex-1 bg-sky-200/[0.08]"></span>
            </div>

            <div class="space-y-3">
                @forelse ($assessments as $assessment)
                    <article data-anim class="assess-card relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/70 p-5 backdrop-blur-xl transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/25 hover:bg-[#0f1b2c]/90 sm:p-6">
                        <div class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-sky-500/10 blur-3xl"></div>

                        <div class="relative">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-sky-300/15 bg-sky-300/[0.08]">
                                        <i data-lucide="calendar-check" class="h-4 w-4 text-sky-300"></i>
                                    </div>
                                    <div>
                                        <div class="text-base font-bold text-white">
                                            {{ $assessment->assessment_date->format('d M Y') }}
                                        </div>
                                        <div class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">
                                            assessment.record
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 grid gap-2 sm:grid-cols-2 lg:grid-cols-3">

                                <div class="rounded-xl border border-sky-200/[0.07] bg-black/15 px-3 py-2">
                                    <div class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">Kedisiplinan</div>
                                    <div class="mt-0.5 text-sm font-bold text-sky-200">{{ $assessment->discipline }}</div>
                                </div>

                                <div class="rounded-xl border border-sky-200/[0.07] bg-black/15 px-3 py-2">
                                    <div class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">Tanggung Jawab</div>
                                    <div class="mt-0.5 text-sm font-bold text-cyan-200">{{ $assessment->responsibility }}</div>
                                </div>

                                <div class="rounded-xl border border-sky-200/[0.07] bg-black/15 px-3 py-2">
                                    <div class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">Kerja Sama</div>
                                    <div class="mt-0.5 text-sm font-bold text-blue-200">{{ $assessment->teamwork }}</div>
                                </div>

                                <div class="rounded-xl border border-sky-200/[0.07] bg-black/15 px-3 py-2">
                                    <div class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">Komunikasi</div>
                                    <div class="mt-0.5 text-sm font-bold text-teal-200">{{ $assessment->communication }}</div>
                                </div>

                                <div class="rounded-xl border border-sky-200/[0.07] bg-black/15 px-3 py-2">
                                    <div class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">Inisiatif</div>
                                    <div class="mt-0.5 text-sm font-bold text-sky-200">{{ $assessment->initiative }}</div>
                                </div>

                                <div class="rounded-xl border border-sky-200/[0.07] bg-black/15 px-3 py-2">
                                    <div class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">Kualitas Kerja</div>
                                    <div class="mt-0.5 text-sm font-bold text-cyan-200">{{ $assessment->work_quality }}</div>
                                </div>

                            </div>

                            @if ($assessment->notes)
                                <div class="mt-4 rounded-xl border border-sky-200/[0.07] bg-black/15 p-3">
                                    <div class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">
                                        Catatan
                                    </div>
                                    <p class="mt-1 text-xs leading-6 text-slate-300">
                                        {{ $assessment->notes }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </article>
                @empty
                    <div data-anim class="rounded-2xl border border-sky-200/[0.08] bg-[#0f1b2c]/60 p-6 text-center">
                        <p class="font-mono text-[10px] uppercase tracking-[0.18em] text-slate-500">
                            Belum ada penilaian.
                        </p>
                    </div>
                @endforelse
            </div>
        </section>


        {{-- FOOTER NOTE --}}
        <div data-anim class="mt-14 flex items-center justify-center gap-3 font-mono text-[9px] text-slate-600">
            <span class="text-teal-300">●</span>
            student.analytics.loaded
            <span class="text-slate-700">/</span>
            <span class="text-sky-300/80">charts.ready</span>
        </div>

    </main>


    {{-- SCRIPT — ICONS + CHARTS + ANIMATIONS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        var root = document.documentElement;

        /* ICONS */
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
        }

        /* ==== CHARTS ==== */
        (function initCharts() {

            var tries = 0;
            var t = setInterval(function () {
                if (typeof Chart !== 'undefined' || ++tries > 40) {
                    clearInterval(t);
                    if (typeof Chart !== 'undefined') drawAll();
                }
            }, 50);

            function drawAll() {

                var personalChartData = @json($personalChartData);
                var radarChartData    = @json($radarChartData);

                /* Shared theme tokens */
                var TEXT       = 'rgba(148, 163, 184, 0.85)';
                var TEXT_SOFT  = 'rgba(148, 163, 184, 0.7)';
                var GRID       = 'rgba(186, 230, 253, 0.08)';
                var BORDER     = 'rgba(186, 230, 253, 0.15)';
                var MONO       = 'ui-monospace, SFMono-Regular, Menlo, monospace';

                /* ---------- RADAR ---------- */
                var radarCanvas = document.getElementById('radarChart');
                if (radarCanvas) {
                    var rctx = radarCanvas.getContext('2d');

                    var rFill = rctx.createRadialGradient(0, 0, 20, 0, 0, 300);
                    rFill.addColorStop(0, 'rgba(125, 211, 252, 0.35)');
                    rFill.addColorStop(1, 'rgba(96, 165, 250, 0.08)');

                    new Chart(rctx, {
                        type: 'radar',
                        data: {
                            labels: radarChartData.labels,
                            datasets: [{
                                label: 'Performa',
                                data: radarChartData.values,
                                borderColor: 'rgba(125, 211, 252, 0.95)',
                                backgroundColor: rFill,
                                borderWidth: 2,
                                pointRadius: 4,
                                pointBackgroundColor: 'rgba(186, 230, 253, 1)',
                                pointBorderColor: 'rgba(14, 165, 233, 1)',
                                pointBorderWidth: 1.5,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: { duration: 900, easing: 'easeOutQuart' },
                            plugins: {
                                legend: {
                                    labels: {
                                        color: TEXT,
                                        font: { family: MONO, size: 10, weight: '600' },
                                        boxWidth: 10,
                                        boxHeight: 10
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 27, 44, 0.95)',
                                    borderColor: 'rgba(186, 230, 253, 0.25)',
                                    borderWidth: 1,
                                    titleColor: 'rgba(226, 232, 240, 1)',
                                    bodyColor: 'rgba(186, 230, 253, 1)',
                                    padding: 10,
                                    cornerRadius: 10,
                                    titleFont: { family: MONO, size: 10 },
                                    bodyFont: { family: MONO, size: 11, weight: '700' }
                                }
                            },
                            scales: {
                                r: {
                                    min: 0,
                                    max: 100,
                                    ticks: {
                                        stepSize: 20,
                                        color: TEXT_SOFT,
                                        backdropColor: 'transparent',
                                        font: { family: MONO, size: 9 }
                                    },
                                    grid:        { color: GRID },
                                    angleLines:  { color: GRID },
                                    pointLabels: {
                                        color: TEXT,
                                        font: { family: MONO, size: 10, weight: '600' }
                                    }
                                }
                            }
                        }
                    });
                }

                /* ---------- HISTORY LINE ---------- */
                var historyCanvas = document.getElementById('historyChart');
                if (historyCanvas) {
                    var hctx = historyCanvas.getContext('2d');

                    var lineFill = hctx.createLinearGradient(0, 0, 0, historyCanvas.clientHeight || 320);
                    lineFill.addColorStop(0, 'rgba(125, 211, 252, 0.28)');
                    lineFill.addColorStop(1, 'rgba(125, 211, 252, 0)');

                    new Chart(hctx, {
                        type: 'line',
                        data: {
                            labels: personalChartData.labels,
                            datasets: [{
                                label: 'Performance Score',
                                data: personalChartData.values,
                                borderColor: 'rgba(125, 211, 252, 0.95)',
                                backgroundColor: lineFill,
                                borderWidth: 3,
                                tension: 0.35,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                pointBackgroundColor: 'rgba(186, 230, 253, 1)',
                                pointBorderColor: 'rgba(14, 165, 233, 1)',
                                pointBorderWidth: 1.5,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: { duration: 900, easing: 'easeOutQuart' },
                            plugins: {
                                legend: {
                                    labels: {
                                        color: TEXT,
                                        font: { family: MONO, size: 10, weight: '600' },
                                        boxWidth: 10,
                                        boxHeight: 10
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 27, 44, 0.95)',
                                    borderColor: 'rgba(186, 230, 253, 0.25)',
                                    borderWidth: 1,
                                    titleColor: 'rgba(226, 232, 240, 1)',
                                    bodyColor: 'rgba(186, 230, 253, 1)',
                                    padding: 10,
                                    cornerRadius: 10,
                                    titleFont: { family: MONO, size: 10 },
                                    bodyFont: { family: MONO, size: 11, weight: '700' }
                                }
                            },
                            scales: {
                                x: {
                                    ticks: { color: TEXT, font: { family: MONO, size: 10 } },
                                    grid: { display: false },
                                    border: { color: BORDER }
                                },
                                y: {
                                    beginAtZero: true,
                                    max: 100,
                                    ticks: { color: TEXT, font: { family: MONO, size: 10 }, stepSize: 20 },
                                    grid: { color: GRID },
                                    border: { color: BORDER }
                                }
                            }
                        }
                    });
                }
            }
        })();


        /* ==== GSAP ==== */
        if (!window.gsap) {
            root.classList.remove('gsap-init');
        } else {
            gsap.config({ force3D: true });
            gsap.ticker.lagSmoothing(500, 33);

            try {
                var tl = gsap.timeline({
                    defaults: { ease: 'power3.out', clearProps: 'transform,opacity' }
                });

                tl.from('[data-anim]', {
                    y: 22,
                    opacity: 0,
                    duration: 0.6,
                    stagger: { each: 0.035, from: 'start' }
                });

                root.classList.remove('gsap-init');

                /* Ambient orb — transform only */
                gsap.to('.orb-1', { x: 40,  y: 30,  duration: 14, repeat: -1, yoyo: true, ease: 'sine.inOut' });
                gsap.to('.orb-2', { x: -30, y: 40,  duration: 16, repeat: -1, yoyo: true, ease: 'sine.inOut' });
                gsap.to('.orb-3', { x: 20,  y: -30, duration: 18, repeat: -1, yoyo: true, ease: 'sine.inOut' });

                /* Counters — rAF */
                document.querySelectorAll('[data-counter]').forEach(function (el) {
                    var target = parseInt(el.dataset.counter, 10) || 0;
                    var start = null;
                    var duration = 1100;

                    function step(ts) {
                        if (!start) start = ts;
                        var p = Math.min((ts - start) / duration, 1);
                        var eased = 1 - Math.pow(1 - p, 3);
                        el.textContent = Math.round(target * eased);
                        if (p < 1) requestAnimationFrame(step);
                        else el.textContent = target;
                    }
                    requestAnimationFrame(step);
                });

            } catch (err) {
                console.warn('[gsap] animation error — showing content', err);
                root.classList.remove('gsap-init');
            }
        }

        /* SAFETY NET */
        window.setTimeout(function () {
            root.classList.remove('gsap-init');
            document.querySelectorAll('[data-anim]').forEach(function (el) {
                if (getComputedStyle(el).opacity === '0') {
                    el.style.opacity = '';
                    el.style.transform = '';
                }
            });
        }, 1500);

    });
    </script>

</body>

</html>