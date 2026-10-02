<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Analytics Siswa — PRAKERIN DISKOMINFO.">

    <title>Analytics Siswa — PRAKERIN</title>

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
        .action-card,
        .rank-item,
        .student-item {
            will-change: transform;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
        }

        /* Chart canvas wrapper konsisten dengan tema */
        .chart-wrap {
            position: relative;
            height: 340px;
            width: 100%;
        }
    </style>

    {{-- Chart.js di HEAD + defer --}}
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
            href="{{ route('admin.dashboard.page') }}"
            class="group inline-flex items-center gap-2.5 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-4 py-2 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/40 hover:bg-sky-400/[0.14]"
        >
            <i data-lucide="arrow-left" class="h-3.5 w-3.5 text-sky-300 transition group-hover:-translate-x-0.5"></i>
            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                Kembali ke Dashboard
            </span>
        </a>


        {{-- HERO --}}
        <section class="mt-6">
            <div data-anim class="mb-6 inline-flex items-center gap-2 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-3 py-1.5">
                <i data-lucide="chart-no-axes-combined" class="h-3.5 w-3.5 text-sky-300"></i>
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                    analytics.mode
                </span>
            </div>

            <h1 data-anim class="max-w-3xl text-5xl font-black leading-[0.9] tracking-[-0.055em] text-white sm:text-6xl lg:text-7xl">
                ANALYTICS
                <span class="shimmer-text mt-1 block bg-gradient-to-r from-sky-200 via-cyan-200 to-blue-300 bg-clip-text text-transparent">
                    SISWA
                </span>
            </h1>

            <p data-anim class="mt-6 max-w-xl text-sm leading-7 text-slate-400 sm:text-base">
                Ringkasan performa, rata-rata per aspek, dan peringkat
                siswa Praktik Kerja Lapangan.
            </p>

            <div data-anim class="mt-8 h-px w-full bg-gradient-to-r from-sky-400/30 via-cyan-300/10 to-transparent"></div>
        </section>


        {{-- OVERVIEW --}}
        <section class="mt-12">
            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    overview
                </span>
                <span class="h-px flex-1 bg-sky-200/[0.08]"></span>
                <span class="flex items-center gap-1.5 font-mono text-[9px] text-slate-500">
                    <span class="h-1.5 w-1.5 rounded-full bg-teal-300 animate-pulse"></span>
                    LIVE
                </span>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                {{-- TOTAL SISWA --}}
                <div data-anim class="stat-item group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-sky-300/30">
                    <div class="relative flex items-start justify-between">
                        <div>
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                Total Siswa
                            </span>
                            <div class="mt-3 text-4xl font-black tracking-tight text-white" data-counter="{{ $totalStudents }}">
                                {{ $totalStudents }}
                            </div>
                        </div>
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-sky-300/15 bg-sky-300/[0.08] transition group-hover:scale-110">
                            <i data-lucide="users-round" class="h-5 w-5 text-sky-300"></i>
                        </div>
                    </div>
                </div>

                {{-- TOTAL PENILAIAN --}}
                <div data-anim class="stat-item group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-cyan-300/30">
                    <div class="relative flex items-start justify-between">
                        <div>
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                Total Penilaian
                            </span>
                            <div class="mt-3 text-4xl font-black tracking-tight text-white" data-counter="{{ $totalAssessments }}">
                                {{ $totalAssessments }}
                            </div>
                        </div>
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-cyan-300/15 bg-cyan-300/[0.08] transition group-hover:scale-110">
                            <i data-lucide="clipboard-check" class="h-5 w-5 text-cyan-300"></i>
                        </div>
                    </div>
                </div>

                {{-- RATA-RATA --}}
                <div data-anim class="stat-item group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-teal-300/30">
                    <div class="relative flex items-start justify-between">
                        <div>
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                Rata-rata
                            </span>
                            <div class="mt-3 text-4xl font-black tracking-tight text-white" data-counter="{{ (int) round($average) }}">
                                {{ $average }}
                            </div>
                        </div>
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-teal-300/15 bg-teal-300/[0.08] transition group-hover:scale-110">
                            <i data-lucide="gauge" class="h-5 w-5 text-teal-300"></i>
                        </div>
                    </div>
                </div>

                {{-- STATUS --}}
                <div data-anim class="stat-item group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-blue-300/30">
                    <div class="relative flex items-start justify-between">
                        <div class="min-w-0">
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                Status
                            </span>
                            <div class="mt-3 truncate text-2xl font-black tracking-tight text-white sm:text-3xl">
                                {{ $category }}
                            </div>
                        </div>
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-blue-300/15 bg-blue-300/[0.08] transition group-hover:scale-110">
                            <i data-lucide="badge-check" class="h-5 w-5 text-blue-300"></i>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        {{-- PERFORMANCE CHART --}}
        <section class="mt-12">
            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    performance.chart
                </span>
                <span class="h-px flex-1 bg-sky-200/[0.08]"></span>
            </div>

            <div data-anim class="chart-card relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl sm:p-7">
                <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-sky-500/10 blur-[100px]"></div>

                <div class="relative">
                    <div class="mb-4 flex items-center gap-2">
                        <i data-lucide="bar-chart-3" class="h-4 w-4 text-sky-300"></i>
                        <span class="font-mono text-[10px] font-bold uppercase tracking-[0.18em] text-slate-400">
                            Rata-rata Performa
                        </span>
                    </div>

                    <div class="chart-wrap">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </section>


        {{-- ASPECT DATA --}}
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
                        ['label' => 'Kedisiplinan',    'value' => $aspectAverages['discipline'],     'icon' => 'shield',       'accent' => 'sky'],
                        ['label' => 'Tanggung Jawab',  'value' => $aspectAverages['responsibility'], 'icon' => 'target',       'accent' => 'cyan'],
                        ['label' => 'Kerja Sama',      'value' => $aspectAverages['teamwork'],       'icon' => 'handshake',    'accent' => 'blue'],
                        ['label' => 'Komunikasi',      'value' => $aspectAverages['communication'],  'icon' => 'message-square','accent' => 'teal'],
                        ['label' => 'Inisiatif',       'value' => $aspectAverages['initiative'],     'icon' => 'lightbulb',    'accent' => 'sky'],
                        ['label' => 'Kualitas Kerja',  'value' => $aspectAverages['work_quality'],   'icon' => 'award',        'accent' => 'cyan'],
                    ];
                @endphp

                @foreach ($aspects as $aspect)
                    <div data-anim class="stat-item group relative overflow-hidden rounded-2xl border border-sky-200/[0.08] bg-[#0f1b2c]/70 p-4 backdrop-blur-xl transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/25 hover:bg-[#0f1b2c]/90">
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


        {{-- RANKING --}}
        <section class="mt-12">
            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    top.5.performance
                </span>
                <span class="h-px flex-1 bg-sky-200/[0.08]"></span>
            </div>

            <div class="space-y-3">
                @forelse ($ranking as $index => $student)
                    <div data-anim class="rank-item group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/70 p-4 backdrop-blur-xl transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/30 hover:bg-[#0f1b2c]/90 sm:p-5">
                        <div class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-sky-500/10 blur-3xl transition group-hover:bg-sky-400/20"></div>

                        <div class="relative flex flex-wrap items-center gap-4">

                            {{-- RANK BADGE --}}
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-sky-300/15 bg-gradient-to-br from-sky-500/20 via-cyan-400/10 to-blue-500/20 font-black text-sky-100">
                                #{{ $index + 1 }}
                            </div>

                            {{-- NAME --}}
                            <div class="min-w-0 flex-1">
                                <div class="truncate text-base font-bold text-white">
                                    {{ $student['name'] }}
                                </div>
                                <div class="mt-0.5 font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">
                                    student.rank.{{ $index + 1 }}
                                </div>
                            </div>

                            {{-- AVERAGE --}}
                            <div class="text-right">
                                <div class="text-2xl font-black tracking-tight text-sky-200">
                                    {{ $student['average'] }}
                                </div>
                                <div class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">
                                    average
                                </div>
                            </div>

                            {{-- CATEGORY --}}
                            <div class="rounded-full border border-teal-300/20 bg-teal-300/[0.1] px-3 py-1">
                                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.14em] text-teal-200">
                                    {{ $student['category'] }}
                                </span>
                            </div>

                            {{-- LINK --}}
                            <a
                                href="{{ route('admin.analytics.student', $student['id']) }}"
                                class="inline-flex items-center gap-2 rounded-xl border border-sky-300/20 bg-sky-400/[0.08] px-3 py-2 text-[10px] font-bold uppercase tracking-[0.14em] text-sky-200 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/40 hover:bg-sky-400/[0.15] hover:text-sky-100"
                            >
                                <i data-lucide="arrow-up-right" class="h-3.5 w-3.5"></i>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div data-anim class="rounded-2xl border border-sky-200/[0.08] bg-[#0f1b2c]/60 p-6 text-center">
                        <p class="font-mono text-[10px] uppercase tracking-[0.18em] text-slate-500">
                            Belum ada data siswa.
                        </p>
                    </div>
                @endforelse
            </div>
        </section>


        {{-- ALL STUDENTS --}}
        <section class="mt-12">
            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    all.students
                </span>
                <span class="h-px flex-1 bg-sky-200/[0.08]"></span>
            </div>

            <div class="grid gap-3 lg:grid-cols-2">
                @forelse ($studentPerformance as $student)
                    <div data-anim class="student-item group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/70 p-5 backdrop-blur-xl transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/30 hover:bg-[#0f1b2c]/90">
                        <div class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-cyan-500/10 blur-3xl transition group-hover:bg-cyan-400/20"></div>

                        <div class="relative">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="truncate text-base font-bold text-white">
                                        {{ $student['name'] }}
                                    </h3>
                                    <div class="mt-1 font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">
                                        NIS {{ $student['nis'] }}
                                    </div>
                                </div>

                                <div class="shrink-0 rounded-full border border-teal-300/20 bg-teal-300/[0.1] px-3 py-1">
                                    <span class="font-mono text-[9px] font-bold uppercase tracking-[0.14em] text-teal-200">
                                        {{ $student['category'] }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4 flex items-end justify-between gap-3">
                                <div>
                                    <div class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">
                                        Performa
                                    </div>
                                    <div class="mt-1 text-3xl font-black tracking-tight text-sky-200">
                                        {{ $student['average'] }}
                                    </div>
                                </div>

                                <a
                                    href="{{ route('admin.analytics.student', $student['id']) }}"
                                    class="inline-flex items-center gap-2 rounded-xl border border-sky-300/20 bg-sky-400/[0.08] px-3 py-2 text-[10px] font-bold uppercase tracking-[0.14em] text-sky-200 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/40 hover:bg-sky-400/[0.15] hover:text-sky-100"
                                >
                                    <i data-lucide="arrow-up-right" class="h-3.5 w-3.5"></i>
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div data-anim class="col-span-full rounded-2xl border border-sky-200/[0.08] bg-[#0f1b2c]/60 p-6 text-center">
                        <p class="font-mono text-[10px] uppercase tracking-[0.18em] text-slate-500">
                            Belum ada data penilaian.
                        </p>
                    </div>
                @endforelse
            </div>
        </section>


        {{-- FOOTER NOTE --}}
        <div data-anim class="mt-14 flex items-center justify-center gap-3 font-mono text-[9px] text-slate-600">
            <span class="text-teal-300">●</span>
            analytics.loaded
            <span class="text-slate-700">/</span>
            <span class="text-sky-300/80">chart.ready</span>
        </div>

    </main>


    {{-- SCRIPT — ICONS + ANIMATIONS + CHART --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        var root = document.documentElement;

        /* ICONS */
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
        }

        /* ==== CHART.JS ==== */
        (function initChart() {
            if (typeof Chart === 'undefined') {
                // retry singkat kalau CDN telat
                var tries = 0;
                var t = setInterval(function () {
                    if (typeof Chart !== 'undefined' || ++tries > 40) {
                        clearInterval(t);
                        if (typeof Chart !== 'undefined') draw();
                    }
                }, 50);
                return;
            }
            draw();

            function draw() {
                var chartData = @json($chartData);
                var canvas = document.getElementById('performanceChart');
                if (!canvas) return;
                var ctx = canvas.getContext('2d');

                /* Gradient fill */
                var gradient = ctx.createLinearGradient(0, 0, 0, canvas.clientHeight || 340);
                gradient.addColorStop(0, 'rgba(125, 211, 252, 0.9)');
                gradient.addColorStop(0.5, 'rgba(103, 232, 249, 0.7)');
                gradient.addColorStop(1, 'rgba(96, 165, 250, 0.35)');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Rata-rata Nilai',
                            data: chartData.values,
                            backgroundColor: gradient,
                            borderColor: 'rgba(186, 230, 253, 0.9)',
                            borderWidth: 1,
                            borderRadius: 8,
                            borderSkipped: false,
                            maxBarThickness: 48
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: { duration: 900, easing: 'easeOutQuart' },
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'rgba(148, 163, 184, 1)',
                                    font: {
                                        family: 'ui-monospace, SFMono-Regular, Menlo, monospace',
                                        size: 10,
                                        weight: '600'
                                    },
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
                                titleFont: { family: 'ui-monospace, monospace', size: 10 },
                                bodyFont: { family: 'ui-monospace, monospace', size: 11, weight: '700' }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: 'rgba(148, 163, 184, 0.85)',
                                    font: { family: 'ui-monospace, monospace', size: 10 }
                                },
                                grid: { display: false },
                                border: { color: 'rgba(186, 230, 253, 0.1)' }
                            },
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    color: 'rgba(148, 163, 184, 0.85)',
                                    font: { family: 'ui-monospace, monospace', size: 10 },
                                    stepSize: 20
                                },
                                grid: { color: 'rgba(186, 230, 253, 0.08)' },
                                border: { color: 'rgba(186, 230, 253, 0.1)' }
                            }
                        }
                    }
                });
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

                /* Counters — rAF, tanpa ScrollTrigger */
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