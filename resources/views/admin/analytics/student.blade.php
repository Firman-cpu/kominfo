<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta
        name="description"
        content="{{ $student->name }} — Analytics PRAKERIN DISKOMINFO."
    >

    <meta name="theme-color" content="#f5f7fa">

    <title>{{ $student->name }} — Analytics PRAKERIN</title>

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Libraries --}}
    <script defer src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
</head>

<body class="min-h-screen overflow-x-hidden bg-[#f5f7fa] text-[#263449] antialiased selection:bg-blue-200 selection:text-[#243f63]">

    {{-- BACKGROUND --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-40 -top-40 h-[460px] w-[460px] rounded-full bg-sky-200/40 blur-[100px]"></div>
        <div class="absolute -right-40 top-[18%] h-[460px] w-[460px] rounded-full bg-blue-200/30 blur-[110px]"></div>
        <div class="absolute -bottom-64 left-[35%] h-[460px] w-[460px] rounded-full bg-indigo-100/60 blur-[110px]"></div>

        <div class="absolute inset-0 bg-[linear-gradient(to_right,#365b88_1px,transparent_1px),linear-gradient(to_bottom,#365b88_1px,transparent_1px)] bg-[size:56px_56px] opacity-[0.035]"></div>

        <div class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2 bg-gradient-to-r from-transparent via-blue-400/50 to-transparent"></div>
    </div>


    <main class="relative mx-auto max-w-6xl px-4 pb-16 pt-8 sm:px-6 sm:pt-12 lg:px-8 lg:pb-24">

        {{-- BACK BUTTON --}}
        <a
            data-anim
            href="{{ route('admin.analytics.index') }}"
            class="group inline-flex items-center gap-2.5 rounded-full border border-[#dce5f0] bg-white/90 px-4 py-2.5 shadow-sm shadow-slate-200/40 transition duration-300 hover:-translate-y-0.5 hover:border-blue-300 hover:shadow-md hover:shadow-blue-100/70"
        >
            <i
                data-lucide="arrow-left"
                class="h-4 w-4 text-[#365b88] transition-transform duration-300 group-hover:-translate-x-1"
            ></i>

            <span class="text-xs font-bold tracking-wide text-[#365b88]">
                Kembali ke Analytics
            </span>
        </a>


        {{-- STUDENT PROFILE --}}
        <section
            data-anim
            class="relative mt-6 overflow-hidden rounded-3xl border border-[#e0e7f0] bg-white/95 p-6 sm:p-9 lg:p-10"
        >
            <div class="pointer-events-none absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#243f63] via-[#416b9e] to-sky-400"></div>
            <div class="relative">

                {{-- SECTION LABEL --}}
                <div class="mb-7 inline-flex items-center gap-2 px-3.5 py-2">
                    <i data-lucide="user-round-search" class="h-4 w-4 text-[#416b9e]"></i>

                    <span class="font-mono text-[10px] font-bold uppercase tracking-[0.16em] text-[#416b9e]">
                        student.analytics.detail
                    </span>
                </div>


                {{-- IDENTITY --}}
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:gap-6">

                    <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-[#243f63] text-3xl font-black text-white sm:h-24 sm:w-24 sm:text-4xl">
                        <i data-lucide="user-round" class="h-20 w-20 mt-8 text-white"></i>
                    </div>

                    <div class="min-w-0 flex-1">

                        <h1 class="break-words text-3xl font-black leading-tight tracking-tight text-[#243f63] sm:text-4xl lg:text-5xl">
                            {{ $student->name }}
                        </h1>

                        <div class="mt-4 flex flex-wrap gap-2.5">

                            <span class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium text-[#718096]">
                                <i data-lucide="contact-round" class="h-3.5 w-3.5 text-[#416b9e]"></i>
                                NIS:
                                <span class="font-bold text-[#263449]">{{ $student->nis }}</span>
                            </span>

                            <span class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium text-[#718096]">
                                <i data-lucide="book-open" class="h-3.5 w-3.5 text-[#416b9e]"></i>
                                Jurusan:
                                <span class="font-bold text-[#263449]">{{ $student->major }}</span>
                            </span>

                            <span class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium text-[#718096]">
                                <i data-lucide="graduation-cap" class="h-3.5 w-3.5 text-[#416b9e]"></i>
                                Kelas:
                                <span class="font-bold text-[#263449]">{{ $student->class }}</span>
                            </span>

                        </div>
                    </div>

                </div>


                {{-- DIVIDER --}}
                <div class="my-8 h-px bg-gradient-to-r from-[#dce5f0] via-[#e9eef5] to-transparent"></div>


                {{-- OVERALL PERFORMANCE --}}
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                    {{-- SCORE --}}
                    <article class="group p-5">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#8390a1]">
                                Overall Performance
                            </span>

                            <div class="flex h-9 w-9 items-center justify-center">
                                <i data-lucide="gauge" class="h-4 w-4"></i>
                            </div>
                        </div>

                        <div class="mt-4 flex items-baseline gap-2">
                            <span
                                class="text-4xl font-black tracking-tight text-[#243f63]"
                                data-counter="{{ (int) round($average) }}"
                            >
                                {{ $average }}
                            </span>

                            <span class="text-sm font-semibold text-[#8390a1]">/ 100</span>
                        </div>

                        <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-[#e8edf4]">
                            <div
                                class="counter-progress h-full rounded-full bg-gradient-to-r from-[#365b88] to-sky-400"
                                data-progress="{{ max(0, min(100, (float) $average)) }}"
                            ></div>
                        </div>
                    </article>


                    {{-- CATEGORY --}}
                    <article class="group p-5">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#8390a1]">
                                Kategori Performa
                            </span>

                            <div class="flex h-9 w-9 items-center justify-center">
                                <i data-lucide="badge-check" class="h-4 w-4"></i>
                            </div>
                        </div>

                        <div class="mt-4 break-words text-2xl font-black tracking-tight text-emerald-700 sm:text-3xl">
                            {{ $category }}
                        </div>

                        <p class="mt-2 text-xs leading-5 text-[#8390a1]">
                            Klasifikasi berdasarkan hasil penilaian siswa.
                        </p>
                    </article>


                    {{-- DESCRIPTION --}}
                    <article class="group p-5">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-[10px] font-bold uppercase tracking-[0.14em] text-[#8390a1]">
                                Ringkasan Performa
                            </span>

                            <div class="flex h-9 w-9 items-center justify-center">
                                <i data-lucide="info" class="h-4 w-4"></i>
                            </div>
                        </div>

                        <p class="mt-4 text-sm leading-7 text-[#64748b]">
                            {{ $description }}
                        </p>
                    </article>

                </div>
            </div>
        </section>

        {{-- RADAR CHART --}}
        <section class="mt-10">

            <div data-anim class="mb-5 flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center">
                    <i data-lucide="radar" class="h-6 w-6"></i>
                </div>

                <div>
                    <h2 class="text-sm font-extrabold text-[#263449]">
                        Analisis Profil
                    </h2>
                    <p class="mt-0.5 text-xs text-[#8390a1]">
                        Perbandingan nilai berdasarkan enam aspek kompetensi.
                    </p>
                </div>
            </div>


            <article
                data-anim
                class="chart-card relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-4 shadow-sm shadow-slate-200/40 sm:p-7"
            >
                <div class="relative">
                    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h3 class="text-sm font-bold text-[#263449]">
                                Radar Profil Aspek
                            </h3>

                            <p class="mt-1 text-xs text-[#8390a1]">
                                Skala penilaian 0–100
                            </p>
                        </div>

                        <span class="inline-flex items-center gap-2 px-3 py-1.5 text-[10px] font-bold text-[#365b88]">
                            <span class="h-2 w-2"></span>
                            Profil Individu
                        </span>
                    </div>

                    <div class="relative h-[300px] w-full sm:h-[380px] lg:h-[420px]">
                        <canvas id="radarChart" role="img" aria-label="Grafik radar profil aspek siswa"></canvas>
                    </div>
                </div>
            </article>
        </section>


        {{-- HISTORY CHART --}}
        <section class="mt-10">

            <div data-anim class="mb-5 flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center">
                    <i data-lucide="activity" class="h-5 w-5"></i>
                </div>

                <div>
                    <h2 class="text-sm font-extrabold text-[#263449]">
                        Tren Performa
                    </h2>
                    <p class="mt-0.5 text-xs text-[#8390a1]">
                        Perkembangan hasil penilaian dari waktu ke waktu.
                    </p>
                </div>
            </div>


            <article
                data-anim
                class="chart-card relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-4 shadow-sm shadow-slate-200/40 sm:p-7"
            >

                <div class="relative">
                    <div class="mb-5">
                        <h3 class="text-sm font-bold text-[#263449]">
                            Riwayat Skor Performa
                        </h3>

                        <p class="mt-1 text-xs text-[#8390a1]">
                            Perubahan nilai keseluruhan berdasarkan tanggal penilaian.
                        </p>
                    </div>

                    <div class="relative h-[260px] w-full sm:h-[300px]">
                        <canvas id="historyChart" role="img" aria-label="Grafik tren skor performa siswa"></canvas>
                    </div>
                </div>
            </article>
        </section>


        {{-- ASPECT AVERAGES --}}
        <section class="mt-10">

            <div data-anim class="mb-5 flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center text-[#365b88]">
                    <i data-lucide="chart-no-axes-combined" class="h-6 w-6"></i>
                </div>

                <div>
                    <h2 class="text-sm font-extrabold text-[#263449]">
                        Rata-rata Aspek
                    </h2>
                    <p class="mt-0.5 text-xs text-[#8390a1]">
                        Rincian hasil pada setiap kompetensi siswa.
                    </p>
                </div>
            </div>


            @php
                $aspects = [
                    [
                        'label' => 'Kedisiplinan',
                        'value' => $aspectAverages['discipline'],
                        'icon' => 'shield-check',
                        'iconColor' => 'text-blue-600',
                        'barColor' => 'bg-blue-500',
                    ],
                    [
                        'label' => 'Tanggung Jawab',
                        'value' => $aspectAverages['responsibility'],
                        'icon' => 'target',
                        'iconColor' => 'text-cyan-600',
                        'barColor' => 'bg-cyan-500',
                    ],
                    [
                        'label' => 'Kerja Sama',
                        'value' => $aspectAverages['teamwork'],
                        'icon' => 'handshake',
                        'iconColor' => 'text-indigo-600',
                        'barColor' => 'bg-indigo-500',
                    ],
                    [
                        'label' => 'Komunikasi',
                        'value' => $aspectAverages['communication'],
                        'icon' => 'messages-square',
                        'iconColor' => 'text-teal-600',
                        'barColor' => 'bg-teal-500',
                    ],
                    [
                        'label' => 'Inisiatif',
                        'value' => $aspectAverages['initiative'],
                        'icon' => 'lightbulb',
                        'iconColor' => 'text-amber-600',
                        'barColor' => 'bg-amber-500',
                    ],
                    [
                        'label' => 'Kualitas Kerja',
                        'value' => $aspectAverages['work_quality'],
                        'icon' => 'award',
                        'iconColor' => 'text-sky-600',
                        'barColor' => 'bg-sky-500',
                    ],
                ];
            @endphp


            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($aspects as $aspect)
                    <article
                        data-anim
                        class="aspect-item group rounded-2xl border border-[#e0e7f0] bg-white p-5"
                    >
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center">
                                    <i
                                        data-lucide="{{ $aspect['icon'] }}"
                                        class="h-5 w-5 {{ $aspect['iconColor'] }}"
                                    ></i>
                                </div>

                                <span class="text-xs font-bold text-[#64748b]">
                                    {{ $aspect['label'] }}
                                </span>
                            </div>

                            <span class="text-xl font-black tracking-tight text-[#243f63]">
                                {{ $aspect['value'] }}
                            </span>
                        </div>

                        <div class="mt-5 h-2 overflow-hidden rounded-full bg-[#edf1f6]">
                            <div
                                class="aspect-progress h-full rounded-full {{ $aspect['barColor'] }}"
                                data-progress="{{ max(0, min(100, (float) $aspect['value'])) }}"
                            ></div>
                        </div>

                        <div class="mt-2 flex items-center justify-between text-[10px] font-medium text-[#9aa5b4]">
                            <span>Skor kompetensi</span>
                            <span>100 poin</span>
                        </div>
                    </article>
                @endforeach

            </div>
        </section>


        {{-- ASSESSMENT HISTORY --}}
        <section class="mt-10">

            <div data-anim class="mb-5 flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center">
                    <i data-lucide="calendar-check" class="h-6 w-6"></i>
                </div>

                <div>
                    <h2 class="text-sm font-extrabold text-[#263449]">
                        Riwayat Penilaian
                    </h2>
                    <p class="mt-0.5 text-xs text-[#8390a1]">
                        Rekap hasil penilaian dan catatan pembimbing.
                    </p>
                </div>
            </div>


            <div class="space-y-4">

                @forelse ($assessments as $assessment)
                    <article
                        data-anim
                        class="assess-card relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-5 shadow-sm shadow-slate-200/30 transition duration-300 hover:border-blue-200 hover:shadow-md hover:shadow-blue-100/40 sm:p-6"
                    >

                        <div class="relative">

                            {{-- ASSESSMENT HEADER --}}
                            <div class="flex flex-wrap items-center justify-between gap-4">

                                <div class="flex items-center gap-3">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center">
                                        <i data-lucide="calendar-days" class="h-5 w-5"></i>
                                    </div>

                                    <div>
                                        <h3 class="text-base font-extrabold text-[#263449]">
                                            {{ $assessment->assessment_date->format('d M Y') }}
                                        </h3>

                                        <p class="mt-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-[#9aa5b4]">
                                            Assessment Record
                                        </p>
                                    </div>
                                </div>

                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-bold text-emerald-700">
                                    <i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>
                                    Tercatat
                                </span>

                            </div>


                            {{-- SCORES --}}
                            <div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">

                                <div class="p-3.5 justify-center items-center flex flex-col">
                                    <div class="flex items-center gap-2 text-[#718096]">
                                        <i data-lucide="shield-check" class="h-3.5 w-3.5 text-blue-600"></i>
                                        <span class="text-[10px] font-semibold">Kedisiplinan</span>
                                    </div>

                                    <div class="mt-2 text-xl font-black text-blue-700">
                                        {{ $assessment->discipline }}
                                    </div>
                                </div>


                                <div class="p-3.5 justify-center items-center flex flex-col">
                                    <div class="flex items-center gap-2 text-[#718096]">
                                        <i data-lucide="target" class="h-3.5 w-3.5 text-cyan-600"></i>
                                        <span class="text-[10px] font-semibold">Tanggung Jawab</span>
                                    </div>

                                    <div class="mt-2 text-xl font-black text-cyan-700">
                                        {{ $assessment->responsibility }}
                                    </div>
                                </div>


                                <div class="p-3.5 justify-center items-center flex flex-col">
                                    <div class="flex items-center gap-2 text-[#718096]">
                                        <i data-lucide="handshake" class="h-3.5 w-3.5 text-indigo-600"></i>
                                        <span class="text-[10px] font-semibold">Kerja Sama</span>
                                    </div>

                                    <div class="mt-2 text-xl font-black text-indigo-700">
                                        {{ $assessment->teamwork }}
                                    </div>
                                </div>


                                <div class="p-3.5 justify-center items-center flex flex-col">
                                    <div class="flex items-center gap-2 text-[#718096]">
                                        <i data-lucide="messages-square" class="h-3.5 w-3.5 text-teal-600"></i>
                                        <span class="text-[10px] font-semibold">Komunikasi</span>
                                    </div>

                                    <div class="mt-2 text-xl font-black text-teal-700">
                                        {{ $assessment->communication }}
                                    </div>
                                </div>


                                <div class="p-3.5 justify-center items-center flex flex-col">
                                    <div class="flex items-center gap-2 text-[#718096]">
                                        <i data-lucide="lightbulb" class="h-3.5 w-3.5 text-amber-600"></i>
                                        <span class="text-[10px] font-semibold">Inisiatif</span>
                                    </div>

                                    <div class="mt-2 text-xl font-black text-amber-700">
                                        {{ $assessment->initiative }}
                                    </div>
                                </div>


                                <div class="p-3.5 justify-center items-center flex flex-col">
                                    <div class="flex items-center gap-2 text-[#718096]">
                                        <i data-lucide="award" class="h-3.5 w-3.5 text-sky-600"></i>
                                        <span class="text-[10px] font-semibold">Kualitas Kerja</span>
                                    </div>

                                    <div class="mt-2 text-xl font-black text-sky-700">
                                        {{ $assessment->work_quality }}
                                    </div>
                                </div>

                            </div>


                            {{-- NOTES --}}
                            @if ($assessment->notes)
                                <div class="mt-4 rounded-xl border border-amber-100 bg-amber-50/70 p-4">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="notebook-pen" class="h-4 w-4 text-amber-700"></i>

                                        <h4 class="text-xs font-extrabold text-amber-800">
                                            Catatan Pembimbing
                                        </h4>
                                    </div>

                                    <p class="mt-2 whitespace-pre-line text-sm leading-7 text-[#64748b]">
                                        {{ $assessment->notes }}
                                    </p>
                                </div>
                            @endif

                        </div>
                    </article>

                @empty
                    <div
                        data-anim
                        class="rounded-2xl border border-dashed border-[#d6e0ec] bg-white/80 px-5 py-12 text-center"
                    >
                        <div class="mx-auto flex h-7 w-7 items-center justify-center">
                            <i data-lucide="clipboard-list" class="h-7 w-7"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-bold text-[#263449]">
                            Belum Ada Penilaian
                        </h3>

                        <p class="mt-1 text-xs text-[#8390a1]">
                            Riwayat penilaian siswa akan muncul di sini.
                        </p>
                    </div>
                @endforelse

            </div>
        </section>


        {{-- FOOTER --}}
        <footer
            data-anim
            class="mt-12 flex flex-col items-center justify-center gap-2 border-t border-[#e0e7f0] pt-7 text-center sm:flex-row sm:gap-3"
        >
            <span class="inline-flex items-center gap-2 text-[10px] font-semibold text-[#718096]">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                Student Analytics
            </span>

            <span class="hidden text-[#cbd5e1] sm:inline">|</span>

            <span class="text-[10px] text-[#9aa5b4]">
                &copy; {{ date('Y') }} DISKOMINFO Pacitan
            </span>
        </footer>

    </main>


    {{-- ICONS, CHARTS & ANIMATIONS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            'use strict';

            var root = document.documentElement;

            /*
             * ICONS
             */
            if (
                window.lucide &&
                typeof window.lucide.createIcons === 'function'
            ) {
                window.lucide.createIcons({
                    attrs: {
                        'stroke-width': 1.8
                    }
                });
            }


            /*
             * CHART DATA
             */
            var personalChartData = @json($personalChartData);
            var radarChartData = @json($radarChartData);


            /*
             * CHART THEME
             */
            var TEXT = '#718096';
            var GRID = 'rgba(54, 91, 136, 0.10)';
            var BORDER = 'rgba(54, 91, 136, 0.18)';

            var MONO = 'ui-monospace, SFMono-Regular, Menlo, monospace';

            var chartInstances = [];


            /*
             * COMMON CHART OPTIONS
             */
            function commonTooltip() {
                return {
                    backgroundColor: '#243f63',
                    titleColor: '#ffffff',
                    bodyColor: '#eaf3ff',
                    borderColor: 'rgba(255, 255, 255, 0.15)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: true,
                    titleFont: {
                        family: MONO,
                        size: 11,
                        weight: '700'
                    },
                    bodyFont: {
                        family: MONO,
                        size: 11
                    }
                };
            }


            /*
             * DRAW CHARTS
             */
            function drawAllCharts() {
                if (typeof Chart === 'undefined') {
                    return;
                }

                /*
                 * RADAR CHART
                 */
                var radarCanvas = document.getElementById('radarChart');

                if (radarCanvas && !radarCanvas.dataset.initialized) {
                    radarCanvas.dataset.initialized = 'true';

                    var radarContext = radarCanvas.getContext('2d');

                    var radarGradient = radarContext.createLinearGradient(
                        0,
                        0,
                        0,
                        radarCanvas.clientHeight || 420
                    );

                    radarGradient.addColorStop(
                        0,
                        'rgba(65, 107, 158, 0.35)'
                    );

                    radarGradient.addColorStop(
                        1,
                        'rgba(125, 211, 252, 0.08)'
                    );

                    var radarChart = new Chart(radarContext, {
                        type: 'radar',

                        data: {
                            labels: radarChartData.labels,

                            datasets: [{
                                label: 'Performa Siswa',
                                data: radarChartData.values,

                                borderColor: '#416b9e',
                                backgroundColor: radarGradient,

                                borderWidth: 2.5,

                                pointRadius: 4,
                                pointHoverRadius: 6,

                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#416b9e',
                                pointBorderWidth: 2,

                                fill: true
                            }]
                        },

                        options: {
                            responsive: true,
                            maintainAspectRatio: false,

                            animation: {
                                duration: 1000,
                                easing: 'easeOutQuart'
                            },

                            interaction: {
                                intersect: false
                            },

                            plugins: {
                                legend: {
                                    position: 'bottom',

                                    labels: {
                                        color: TEXT,

                                        font: {
                                            family: MONO,
                                            size: 10,
                                            weight: '600'
                                        },

                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        padding: 20
                                    }
                                },

                                tooltip: commonTooltip()
                            },

                            scales: {
                                r: {
                                    min: 0,
                                    max: 100,

                                    ticks: {
                                        stepSize: 20,
                                        color: '#8390a1',
                                        backdropColor: 'transparent',

                                        font: {
                                            family: MONO,
                                            size: 9
                                        }
                                    },

                                    grid: {
                                        color: GRID
                                    },

                                    angleLines: {
                                        color: GRID
                                    },

                                    pointLabels: {
                                        color: '#52647b',

                                        font: {
                                            family: MONO,
                                            size: 10,
                                            weight: '600'
                                        }
                                    }
                                }
                            }
                        }
                    });

                    chartInstances.push(radarChart);
                }


                /*
                 * HISTORY LINE CHART
                 */
                var historyCanvas = document.getElementById('historyChart');

                if (historyCanvas && !historyCanvas.dataset.initialized) {
                    historyCanvas.dataset.initialized = 'true';

                    var historyContext = historyCanvas.getContext('2d');

                    var historyGradient = historyContext.createLinearGradient(
                        0,
                        0,
                        0,
                        historyCanvas.clientHeight || 300
                    );

                    historyGradient.addColorStop(
                        0,
                        'rgba(65, 107, 158, 0.22)'
                    );

                    historyGradient.addColorStop(
                        1,
                        'rgba(65, 107, 158, 0.01)'
                    );

                    var historyChart = new Chart(historyContext, {
                        type: 'line',

                        data: {
                            labels: personalChartData.labels,

                            datasets: [{
                                label: 'Skor Performa',

                                data: personalChartData.values,

                                borderColor: '#416b9e',
                                backgroundColor: historyGradient,

                                borderWidth: 3,
                                tension: 0.35,

                                pointRadius: 4,
                                pointHoverRadius: 7,

                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#416b9e',
                                pointBorderWidth: 2,

                                fill: true
                            }]
                        },

                        options: {
                            responsive: true,
                            maintainAspectRatio: false,

                            animation: {
                                duration: 1000,
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

                                tooltip: commonTooltip()
                            },

                            scales: {
                                x: {
                                    ticks: {
                                        color: TEXT,
                                        maxRotation: 0,
                                        autoSkip: true,

                                        font: {
                                            family: MONO,
                                            size: 10
                                        }
                                    },

                                    grid: {
                                        display: false
                                    },

                                    border: {
                                        color: BORDER
                                    }
                                },

                                y: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 100,

                                    ticks: {
                                        stepSize: 20,
                                        color: TEXT,

                                        font: {
                                            family: MONO,
                                            size: 10
                                        }
                                    },

                                    grid: {
                                        color: GRID
                                    },

                                    border: {
                                        color: BORDER
                                    }
                                }
                            }
                        }
                    });

                    chartInstances.push(historyChart);
                }
            }


            /*
             * WAIT FOR CHART.JS
             */
            var chartAttempts = 0;

            var chartInterval = window.setInterval(function () {
                chartAttempts++;

                if (typeof Chart !== 'undefined') {
                    window.clearInterval(chartInterval);

                    try {
                        drawAllCharts();
                    } catch (error) {
                        console.error('[analytics] Chart initialization failed:', error);
                    }

                    return;
                }

                if (chartAttempts >= 60) {
                    window.clearInterval(chartInterval);
                    console.warn('[analytics] Chart.js gagal dimuat.');
                }
            }, 100);


            /*
             * GSAP ANIMATIONS
             *
             * Content remains visible if GSAP fails to load.
             */
            if (window.gsap) {
                try {
                    gsap.config({
                        force3D: true
                    });

                    gsap.ticker.lagSmoothing(500, 33);

                    gsap.from('[data-anim]', {
                        y: 18,
                        opacity: 0,
                        duration: 0.65,
                        stagger: 0.035,
                        ease: 'power3.out',
                        clearProps: 'transform,opacity'
                    });


                    /*
                     * SCORE COUNTER
                     */
                    document.querySelectorAll('[data-counter]').forEach(function (element) {
                        var target = parseInt(element.dataset.counter, 10);

                        if (!Number.isFinite(target)) {
                            return;
                        }

                        var counter = {
                            value: 0
                        };

                        gsap.to(counter, {
                            value: target,
                            duration: 1.2,
                            ease: 'power2.out',

                            onUpdate: function () {
                                element.textContent = Math.round(counter.value);
                            },

                            onComplete: function () {
                                element.textContent = target;
                            }
                        });
                    });


                    /*
                     * PROGRESS BARS
                     */
                    document.querySelectorAll('[data-progress]').forEach(function (element) {
                        var target = parseFloat(element.dataset.progress);

                        if (!Number.isFinite(target)) {
                            target = 0;
                        }

                        target = Math.max(0, Math.min(100, target));

                        gsap.fromTo(
                            element,
                            {
                                width: '0%'
                            },
                            {
                                width: target + '%',
                                duration: 1,
                                delay: 0.15,
                                ease: 'power3.out'
                            }
                        );
                    });


                    /*
                     * SUBTLE HOVER FEEDBACK
                     */
                    document.querySelectorAll(
                        '.stat-item, .aspect-item, .assess-card, .insight-card, .chart-card'
                    ).forEach(function (element) {
                        element.addEventListener('mouseenter', function () {
                            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                                return;
                            }

                            gsap.to(element, {
                                duration: 0.2,
                                ease: 'power2.out'
                            });
                        });
                    });

                } catch (error) {
                    console.warn('[analytics] Animation initialization failed:', error);
                }
            }


            /*
             * ACCESSIBILITY: REDUCED MOTION
             */
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                if (window.gsap) {
                    gsap.globalTimeline.timeScale(3);
                }
            }

        });
    </script>

</body>
</html>