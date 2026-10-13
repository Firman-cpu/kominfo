<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Analytics performa, rata-rata penilaian, dan peringkat siswa PRAKERIN DISKOMINFO Kabupaten Pacitan.">
    <meta name="theme-color" content="#f5f7fa">

    <title>Analytics Siswa — PRAKERIN DISKOMINFO</title>

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
</head>

<body class="min-h-screen overflow-x-hidden bg-[#f5f7fa] text-[#263449] antialiased selection:bg-sky-200 selection:text-[#243f63]">

    {{-- BACKGROUND --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-[linear-gradient(rgba(54,91,136,0.035)_1px,transparent_1px),linear-gradient(90deg,rgba(54,91,136,0.035)_1px,transparent_1px)] bg-[size:48px_48px]"></div>

        <div class="orb orb-1 absolute -left-40 -top-40 h-[480px] w-[480px] rounded-full bg-[radial-gradient(circle,rgba(56,189,248,0.19),rgba(56,189,248,0.05)_45%,transparent_72%)] blur-2xl"></div>

        <div class="orb orb-2 absolute -right-40 top-[20%] h-[480px] w-[480px] rounded-full bg-[radial-gradient(circle,rgba(99,102,241,0.12),rgba(56,189,248,0.04)_48%,transparent_72%)] blur-2xl"></div>

        <div class="orb orb-3 absolute -bottom-64 left-[30%] h-[520px] w-[520px] rounded-full bg-[radial-gradient(circle,rgba(45,212,191,0.12),transparent_70%)] blur-2xl"></div>
    </div>

    <main class="mx-auto max-w-7xl px-4 pb-12 pt-7 sm:px-6 sm:pb-16 sm:pt-10 lg:px-8">

        {{-- TOP NAVIGATION --}}
        <nav data-anim class="mb-9 flex flex-wrap items-center justify-between gap-4">
            <a href="{{ route('admin.dashboard.page') }}"
                class="group inline-flex items-center gap-2 px-4 py-3 transition duration-300 hover:-translate-x-0.5">

                <img
                    src="{{ asset('image/logo.png') }}"
                    alt="Logo DISKOMINFO Kabupaten Pacitan"
                    class="h-12 w-auto object-contain"
                >

                <span>
                    <span class="block text-sm font-bold text-[#243f63]">DINAS KOMUNIKASI DAN INFORMATIKA</span>
                    <span class="block text-[10px] tracking-wide text-[#8390a1]">KABUPATEN PACITAN</span>
                </span>
            </a>

            <a href="{{ route('admin.dashboard.page') }}"
                class="group inline-flex items-center gap-2 rounded-xl border border-[#dfe6ef] bg-white px-4 py-3 text-xs font-semibold text-[#526176] transition duration-300 hover:-translate-y-0.5 hover:border-[#b9cee5] hover:text-[#243f63] hover:shadow-sm">

                <i data-lucide="arrow-left" class="h-4 w-4 transition-transform group-hover:-translate-x-1"></i>
                <span>Kembali ke Dashboard</span>
            </a>
        </nav>

        {{-- HERO --}}
        <header class="mb-10 overflow-hidden">

            <div class="relative p-6 sm:p-9 lg:p-12">

                <div class="relative grid gap-8 lg:grid-cols-[1fr_auto] lg:items-end">
                    <div>
                        <div data-anim class="mb-5 inline-flex items-center gap-2 rounded-full border border-sky-200 bg-sky-50 px-3.5 py-2">
                            <span class="relative flex h-2 w-2">
                                <span class="relative inline-flex h-2 w-2 rounded-full bg-sky-500"></span>
                            </span>

                            <span class="font-mono text-[10px] font-bold uppercase tracking-[0.18em] text-[#365b88]">
                                Analytics Center
                            </span>
                        </div>

                        <h1 data-anim class="text-4xl font-black leading-[0.98] tracking-[-0.055em] text-[#243f63] sm:text-5xl lg:text-7xl">
                            ANALYTICS
                            <span class="mt-1 block bg-gradient-to-r from-[#416b9e] via-sky-500 to-cyan-500 bg-clip-text text-transparent">
                                SISWA.
                            </span>
                        </h1>
                    </div>
                </div>

                <div data-anim class="mt-3 flex flex-wrap items-center gap-x-5 text-[11px] text-[#8390a1]">
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="shield-check" class="h-4 w-4 text-[#416b9e]"></i>
                        Sistem Penilaian PKL
                    </span>

                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="chart-column-increasing" class="h-4 w-4 text-[#416b9e]"></i>
                        Analisis Performa
                    </span>

                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="users-round" class="h-4 w-4 text-[#416b9e]"></i>
                        Data Peserta
                    </span>
                </div>
            </div>
        </header>

        {{-- OVERVIEW --}}
        <section class="mb-11">
            <div data-anim class="mb-5 flex items-center gap-3">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#416b9e]">01 / Overview</p>
                    <h2 class="mt-1 text-lg font-bold text-[#243f63]">Ringkasan Analytics</h2>
                </div>

                <span class="h-px flex-1 bg-[#dfe7f0]"></span>

                <span class="hidden items-center gap-1.5 px-3 py-1.5 text-[10px] font-semibold text-[#718096] sm:inline-flex">
                    <i data-lucide="database" class="h-3.5 w-3.5"></i>
                    Overview
                </span>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- TOTAL SISWA --}}
                <article data-anim class="flex flex-row items-center justify-center w-300 relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-5">

                    <div class="relative flex items-start justify-between gap-30">
                        <div class="relative flex items-start justify-between gap-3">
                        <div>
                            <div class="flex flex-row items-center justify-between">
                            <p class="text-xs font-semibold text-[#718096]">Total Siswa</p>
                            <div class="flex h-12 w-12 items-center justify-center text-sky-600 transition duration-300 group-hover:scale-105">
                            <i data-lucide="users-round" class="h-5 w-5"></i>
                        </div>
                        </div>
                            <p class="text-center text-4xl font-black tracking-tight text-[#243f63]" data-counter="{{ $totalStudents }}">
                                {{ $totalStudents }}
                            </p>
                            <p class="mt-2 text-center text-[11px] text-[#8390a1]">Peserta terdaftar</p>
                        </div>

                        
                    </div>


                {{-- TOTAL PENILAIAN --}}
                    <div class="relative flex items-start justify-between gap-30">
                        <div class="relative flex items-start justify-between gap-3">
                        <div>
                            <div class="flex flex-row items-center justify-between">
                            <p class="text-xs font-semibold text-[#718096]">Total Penilaian</p>
                            <div class="flex h-12 w-12 items-center justify-center text-cyan-600 transition duration-300 group-hover:scale-105">
                                <i data-lucide="clipboard-check" class="h-5 w-5"></i>
                            </div>
                        </div>
                            <p class="text-center text-4xl font-black tracking-tight text-[#243f63]" data-counter="{{ $totalAssessments }}">
                                {{ $totalAssessments }}
                            </p>
                            <p class="mt-2 text-center text-[11px] text-[#8390a1]">Penilaian tercatat</p>
                        </div>


                    </div>


                {{-- RATA-RATA --}}

                    <div class="relative flex items-start justify-between gap-30">
                        <div class="relative flex items-start justify-between gap-3">
                        <div>
                            <div class= "flex flex-row items-center justify-between">
                            <p class="text-xs font-semibold text-[#718096]">Rata-rata Nilai</p>
                            <div class="flex h-12 w-12 items-center justify-center text-teal-600 transition duration-300 group-hover:scale-105">
                                <i data-lucide="gauge" class="h-5 w-5"></i>
                            </div>
                        </div>
                            <p class="text-center text-4xl font-black tracking-tight text-[#243f63]" data-counter="{{ (int) round($average) }}">
                                {{ $average }}
                            </p>
                            <p class="mt-2 text-center text-[11px] text-[#8390a1]">Rata-rata keseluruhan</p>
                        </div>
                    </div>

                {{-- KATEGORI --}}

                    <div class="relative flex items-start justify-between gap-30">
                        <div class="relative flex items-start justify-between gap-3">
                        <div>
                            <div class= "flex flex-row items-center justify-between">
                            <p class="text-xs font-semibold text-[#718096]">Kategori Performa</p>
                            <div class="flex h-12 w-12 items-center justify-center t    ext-indigo-600 transition duration-300 group-hover:scale-105">
                                <i data-lucide="badge-check" class="h-5 w-5"></i>
                            </div>
                        </div>
                            <p class="text-center text-4xl font-black tracking-tight text-[#243f63]" data-counter="{{ (int) round($average) }}">
                                {{ $category }}
                            </p>
                            <p class="mt-2 text-center text-[11px] text-[#8390a1]">Hasil evaluasi nilai</p>
                        </div>
                    </div>
                </article>

            </div>
        </section>

        {{-- PERFORMANCE CHART --}}
        <section class="mb-11">
            <div data-anim class="mb-5 flex items-center gap-3">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#416b9e]">02 / Performance</p>
                    <h2 class="mt-1 text-lg font-bold text-[#243f63]">Grafik Performa Siswa</h2>
                </div>

                <span class="h-px flex-1 bg-[#dfe7f0]"></span>

                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-semibold text-[#718096]">
                    <i data-lucide="chart-column-increasing" class="h-3.5 w-3.5"></i>
                    Grafik Nilai
                </span>
            </div>

            <div data-anim class="chart-card overflow-hidden rounded-3xl border border-[#e0e7f0] bg-white shadow-[0_12px_40px_rgba(36,63,99,0.045)]">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-[#edf1f6] px-5 py-5 sm:px-7">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center text-[#365b88]">
                            <i data-lucide="chart-no-axes-combined" class="h-7 w-7"></i>
                        </div>

                        <div>
                            <h3 class="text-sm font-bold text-[#243f63]">Rata-rata Performa</h3>
                            <p class="mt-1 text-xs text-[#8390a1]">Visualisasi nilai berdasarkan data penilaian</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 px-3 py-2 text-[10px] font-semibold">
                        Skala 0–100
                    </div>
                </div>

                <div class="p-4 sm:p-7">
                    <div class="relative h-[280px] w-full sm:h-[340px] lg:h-[380px]">
                        <canvas id="performanceChart" role="img" aria-label="Grafik rata-rata performa siswa"></canvas>

                        <div id="chartFallback" class="absolute inset-0 hidden items-center justify-center2 p-6 text-center">
                            <div>
                                <i data-lucide="chart-no-axes-column" class="mx-auto h-9 w-9 text-[#8390a1]"></i>
                                <p class="mt-3 text-sm font-semibold text-[#526176]">Grafik belum dapat dimuat</p>
                                <p class="mt-1 text-xs text-[#8390a1]">Periksa koneksi internet lalu muat ulang halaman.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ASPECT AVERAGES --}}
        <section class="mb-11">
            <div data-anim class="mb-5 flex items-center gap-3">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#416b9e]">03 / Assessment</p>
                    <h2 class="mt-1 text-lg font-bold text-[#243f63]">Rata-rata Per Aspek</h2>
                </div>

                <span class="h-px flex-1 bg-[#dfe7f0]"></span>
            </div>

            @php
                $aspects = [
                    [
                        'label' => 'Kedisiplinan',
                        'value' => $aspectAverages['discipline'],
                        'icon' => 'shield-check',
                        'iconClass' => 'text-sky-600 border-sky-100',
                        'barClass' => 'from-sky-400 to-cyan-400',
                    ],
                    [
                        'label' => 'Tanggung Jawab',
                        'value' => $aspectAverages['responsibility'],
                        'icon' => 'target',
                        'iconClass' => 'text-cyan-600 border-cyan-100',
                        'barClass' => 'from-cyan-400 to-teal-400',
                    ],
                    [
                        'label' => 'Kerja Sama',
                        'value' => $aspectAverages['teamwork'],
                        'icon' => 'handshake',
                        'iconClass' => 'text-blue-600 border-blue-100',
                        'barClass' => 'from-blue-400 to-indigo-400',
                    ],
                    [
                        'label' => 'Komunikasi',
                        'value' => $aspectAverages['communication'],
                        'icon' => 'messages-square',
                        'iconClass' => 'text-teal-600 border-teal-100',
                        'barClass' => 'from-teal-400 to-emerald-400',
                    ],
                    [
                        'label' => 'Inisiatif',
                        'value' => $aspectAverages['initiative'],
                        'icon' => 'lightbulb',
                        'iconClass' => 'text-amber-600 border-amber-100',
                        'barClass' => 'from-amber-400 to-orange-400',
                    ],
                    [
                        'label' => 'Kualitas Kerja',
                        'value' => $aspectAverages['work_quality'],
                        'icon' => 'award',
                        'iconClass' => 'text-indigo-600 border-indigo-100',
                        'barClass' => 'from-indigo-400 to-violet-400',
                    ],
                ];
            @endphp

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($aspects as $aspect)
                    @php
                        $aspectValue = max(0, min(100, (float) $aspect['value']));
                    @endphp

                    <article data-anim class="stat-item group rounded-2xl border border-[#e0e7f0] bg-white p-5">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex min-w-0 items-center gap-3">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center {{ $aspect['iconClass'] }}">
                                    <i data-lucide="{{ $aspect['icon'] }}" class="h-5 w-5"></i>
                                </div>

                                <h3 class="text-sm font-bold text-[#34445b]">
                                    {{ $aspect['label'] }}
                                </h3>
                            </div>

                            <span class="text-xl font-black tracking-tight text-[#243f63]">
                                {{ $aspect['value'] }}
                            </span>
                        </div>

                        <div class="mt-5 h-2 overflow-hidden rounded-full bg-[#edf2f8]">
                            <div data-progress="{{ $aspectValue }}"
                                class="aspect-progress h-full rounded-full bg-gradient-to-r {{ $aspect['barClass'] }}"
                                style="width: {{ $aspectValue }}%;">
                            </div>
                        </div>

                        <div class="mt-2 flex items-center justify-between text-[10px] text-[#8390a1]">
                            <span>Skor aspek</span>
                            <span>{{ number_format($aspectValue, 1) }} / 100</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        {{-- ALL STUDENTS --}}
        <section class="mb-10">
            <div data-anim class="mb-5 flex items-center gap-3">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#416b9e]">04 / Student Directory</p>
                    <h2 class="mt-1 text-lg font-bold text-[#243f63]">Performa Seluruh Siswa</h2>
                </div>

                <span class="h-px flex-1 bg-[#dfe7f0]"></span>

                <span class="px-3 py-1.5 text-[10px] font-semibold text-[#718096]">
                    {{ count($studentPerformance) }} siswa
                </span>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($studentPerformance as $student)
                    <article data-anim class="student-item group relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-5">
                        <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-sky-100/50 blur-3xl"></div>

                        <div class="relative">
                            <div class="flex items-start gap-3">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#dce6f2] bg-[#edf3fa] font-bold uppercase text-[#365b88]">
                                    {{ mb_substr($student['name'] ?? 'S', 0, 1) }}
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h3 class="truncate text-sm font-bold text-[#243f63]">
                                        {{ $student['name'] }}
                                    </h3>

                                    <p class="mt-1 truncate text-[11px] text-[#8390a1]">
                                        NIS {{ $student['nis'] }}
                                    </p>
                                </div>

                                <span class="shrink-0 rounded-full border border-teal-100 bg-teal-50 px-2.5 py-1 text-[9px] font-bold text-teal-700">
                                    {{ $student['category'] }}
                                </span>
                            </div>

                            <div class="mt-6 flex items-end justify-between gap-3">
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#8390a1]">
                                        Nilai rata-rata
                                    </p>

                                    <p class="mt-1 text-3xl font-black tracking-tight text-[#365b88]">
                                        {{ $student['average'] }}
                                    </p>
                                </div>

                                <a href="{{ route('admin.analytics.student', $student['id']) }}"
                                    class="inline-flex items-center gap-2 px-3 py-2.5 text-xs font-semibold text-[#365b88] transition">

                                    Detail
                                    <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                                </a>
                            </div>

                            <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-[#edf2f8]">
                                <div data-progress="{{ max(0, min(100, (float) $student['average'])) }}"
                                    class="student-progress h-full rounded-full bg-gradient-to-r from-sky-400 via-cyan-400 to-teal-400"
                                    style="width: {{ max(0, min(100, (float) $student['average'])) }}%;">
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div data-anim class="col-span-full rounded-2xl border border-dashed border-[#d5e0ec] bg-white/80 px-5 py-12 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#edf3fa] text-[#416b9e]">
                            <i data-lucide="clipboard-list" class="h-6 w-6"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-bold text-[#34445b]">Belum ada data penilaian</h3>
                        <p class="mt-1 text-xs text-[#8390a1]">Data performa siswa akan muncul setelah penilaian tersedia.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- FOOTER --}}
        <footer data-anim class="flex flex-col items-center justify-between gap-4 border-t border-[#dfe7f0] pt-6 text-center sm:flex-row sm:text-left">
            <div class="flex items-center gap-3">

                <div>
                    <p class="text-xs font-bold text-[#526176]">PRAKERIN DINAS KOMUNIKASI DAN INFORMATIKA</p>
                    <p class="mt-1 text-[10px] text-[#8390a1]">Kabupaten Pacitan</p>
                </div>
            </div>

            <p class="text-[10px] text-[#8390a1]">
                &copy; {{ date('Y') }} DISKOMINFO Pacitan
            </p>
        </footer>

    </main>

    {{-- ICONS, ANIMATION & CHART --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // Lucide icons
            if (window.lucide && typeof window.lucide.createIcons === 'function') {
                window.lucide.createIcons({
                    attrs: {
                        'stroke-width': 1.8
                    }
                });
            }

            // Chart.js
            const chartData = @json($chartData);
            const canvas = document.getElementById('performanceChart');
            const fallback = document.getElementById('chartFallback');

            function showChartFallback() {
                if (canvas) canvas.classList.add('hidden');

                if (fallback) {
                    fallback.classList.remove('hidden');
                    fallback.classList.add('flex');
                }

                if (window.lucide) {
                    window.lucide.createIcons();
                }
            }

            function drawChart() {
                if (!canvas || typeof window.Chart === 'undefined') {
                    showChartFallback();
                    return;
                }

                if (canvas.chartInstance) {
                    canvas.chartInstance.destroy();
                }

                const context = canvas.getContext('2d');
                const gradient = context.createLinearGradient(0, 0, 0, 360);

                gradient.addColorStop(0, 'rgba(56, 189, 248, 0.85)');
                gradient.addColorStop(0.55, 'rgba(103, 232, 249, 0.55)');
                gradient.addColorStop(1, 'rgba(96, 165, 250, 0.18)');

                canvas.chartInstance = new Chart(context, {
                    type: 'bar',

                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Rata-rata Nilai',
                            data: chartData.values,
                            backgroundColor: gradient,
                            borderColor: 'rgba(56, 139, 201, 0.8)',
                            borderWidth: 1,
                            borderRadius: 8,
                            borderSkipped: false,
                            maxBarThickness: 46,
                            hoverBackgroundColor: 'rgba(56, 189, 248, 0.9)'
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        animation: {
                            duration: reducedMotion ? 0 : 850,
                            easing: 'easeOutQuart'
                        },

                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },

                        plugins: {
                            legend: {
                                display: false
                            },

                            tooltip: {
                                backgroundColor: '#243f63',
                                titleColor: '#ffffff',
                                bodyColor: '#dbeafe',
                                borderColor: 'rgba(186, 230, 253, 0.25)',
                                borderWidth: 1,
                                padding: 12,
                                cornerRadius: 10,
                                displayColors: false,

                                titleFont: {
                                    family: 'ui-sans-serif, system-ui, sans-serif',
                                    size: 12,
                                    weight: '600'
                                },

                                bodyFont: {
                                    family: 'ui-sans-serif, system-ui, sans-serif',
                                    size: 12,
                                    weight: '700'
                                },

                                callbacks: {
                                    label: function (context) {
                                        return 'Rata-rata: ' + context.parsed.y;
                                    }
                                }
                            }
                        },

                        scales: {
                            x: {
                                ticks: {
                                    color: '#718096',
                                    maxRotation: 35,
                                    minRotation: 0,

                                    font: {
                                        family: 'ui-sans-serif, system-ui, sans-serif',
                                        size: 10
                                    }
                                },

                                grid: {
                                    display: false
                                },

                                border: {
                                    color: '#e2e8f0'
                                }
                            },

                            y: {
                                beginAtZero: true,
                                max: 100,

                                ticks: {
                                    color: '#8390a1',
                                    stepSize: 20,

                                    font: {
                                        family: 'ui-sans-serif, system-ui, sans-serif',
                                        size: 10
                                    },

                                    padding: 8
                                },

                                grid: {
                                    color: 'rgba(148, 163, 184, 0.15)'
                                },

                                border: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Libraries loaded with defer normally execute before DOMContentLoaded.
            // Keep a short retry as a fallback for slow CDN connections.
            if (typeof window.Chart !== 'undefined') {
                drawChart();
            } else {
                let attempts = 0;

                const chartRetry = window.setInterval(function () {
                    attempts++;

                    if (typeof window.Chart !== 'undefined') {
                        window.clearInterval(chartRetry);
                        drawChart();
                    } else if (attempts >= 40) {
                        window.clearInterval(chartRetry);
                        showChartFallback();
                    }
                }, 150);
            }

            // GSAP entrance animation
            const animatedElements = document.querySelectorAll('[data-anim]');

            if (window.gsap && !reducedMotion) {
                window.gsap.fromTo(
                    animatedElements,
                    {
                        y: 18,
                        autoAlpha: 0
                    },
                    {
                        y: 0,
                        autoAlpha: 1,
                        duration: 0.6,
                        stagger: 0.045,
                        ease: 'power3.out',
                        clearProps: 'transform'
                    }
                );

                // Ambient background movement
                window.gsap.to('.orb-1', {
                    x: 35,
                    y: 25,
                    duration: 13,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });

                window.gsap.to('.orb-2', {
                    x: -30,
                    y: 35,
                    duration: 16,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });

                window.gsap.to('.orb-3', {
                    x: 20,
                    y: -25,
                    duration: 18,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });

                // Stat counters
                document.querySelectorAll('[data-counter]').forEach(function (element) {
                    const target = Number(element.dataset.counter) || 0;
                    const duration = 1000;
                    const startedAt = performance.now();

                    function animateCounter(now) {
                        const progress = Math.min((now - startedAt) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);

                        element.textContent = Math.round(target * eased);

                        if (progress < 1) {
                            requestAnimationFrame(animateCounter);
                        } else {
                            element.textContent = target;
                        }
                    }

                    requestAnimationFrame(animateCounter);
                });

                // Animate aspect and student progress bars
                window.gsap.fromTo(
                    '.aspect-progress, .student-progress',
                    {
                        scaleX: 0,
                        transformOrigin: 'left center'
                    },
                    {
                        scaleX: 1,
                        duration: 0.9,
                        stagger: 0.06,
                        delay: 0.2,
                        ease: 'power2.out'
                    }
                );
            } else {
                animatedElements.forEach(function (element) {
                    element.style.opacity = '1';
                    element.style.visibility = 'visible';
                    element.style.transform = 'none';
                });
            }

            // Safety net: keep content visible if an animation fails.
            window.setTimeout(function () {
                document.querySelectorAll('[data-anim]').forEach(function (element) {
                    element.style.opacity = '1';
                    element.style.visibility = 'visible';
                    element.style.transform = 'none';
                });
            }, 1800);
        });
    </script>

</body>
</html>