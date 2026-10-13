<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem pendataan, pemantauan, dan penilaian siswa Praktik Kerja Lapangan di Dinas Komunikasi dan Informatika Kabupaten Pacitan.">

    <meta name="theme-color" content="#f5f7fa">

    <title>PRAKERIN — DISKOMINFO PACITAN</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    x-data="{ mobileOpen: false, scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 20"
    class="min-h-screen overflow-x-hidden bg-[#f5f7fa] text-[#263449] antialiased selection:bg-[#dbe6f5] selection:text-[#19375e]"
>

    {{-- BACKGROUND --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="orb-1 absolute -left-40 -top-40 h-[400px] w-[400px] rounded-full bg-[#dce7f5]/70 blur-[120px]"></div>
        <div class="orb-2 absolute -right-40 top-[15%] h-[400px] w-[400px] rounded-full bg-[#e1eaf4]/70 blur-[120px]"></div>
        <div class="orb-3 absolute bottom-[-200px] left-[30%] h-[400px] w-[400px] rounded-full bg-[#e3e9f1]/60 blur-[120px]"></div>
        <div class="absolute inset-0 bg-white/10"></div>
    </div>

    <main>

        {{-- HERO --}}
        <section class="relative mx-auto max-w-7xl px-4 pb-14 pt-12 sm:px-6 sm:pb-20 sm:pt-16 lg:px-8 lg:pb-24 lg:pt-24">

            <div class="grid items-center gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:gap-16">

                {{-- HERO CONTENT --}}
                <div class="relative z-10">

                    <div class="hero-badge mb-6 inline-flex items-center gap-2.5 rounded-lg border border-[#dce4ef] bg-white/90 px-3.5 py-2 shadow-sm shadow-[#263449]/[0.02]">
                        <i data-lucide="clipboard-list" class="h-4 w-4 text-[#36577f]"></i>
                        <span class="font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-[#526a87]">
                            Sistem Administrasi PRAKERIN
                        </span>
                    </div>

                    <h1 class="hero-title max-w-3xl text-5xl font-bold leading-[0.98] tracking-[-0.065em] text-[#263449] sm:text-6xl lg:text-[5.5rem]">
                        PRAKERIN
                        <span class="mt-2 block bg-gradient-to-r from-[#1e3a5f] via-[#416b9e] to-[#294d78] bg-clip-text text-transparent">
                            DISKOMINFO
                        </span>
                    </h1>

                    <p class="hero-sub mt-7 max-w-xl text-sm leading-7 text-[#718096] sm:text-base sm:leading-8">
                        Platform pengelolaan data dan penilaian siswa Praktik Kerja Lapangan
                        di Dinas Komunikasi dan Informatika Kabupaten Pacitan.
                        Dirancang untuk membantu pencatatan, pemantauan kegiatan,
                        dan evaluasi siswa secara lebih terstruktur dan efisien.
                    </p>

                    <div class="hero-buttons mt-8 flex flex-wrap items-center gap-3">

                        <a
                            href="{{ route('students.index') }}"
                            class="btn-magnetic group inline-flex items-center gap-3 rounded-lg bg-[#243f63] px-5 py-3.5 text-sm font-semibold text-white shadow-md shadow-[#243f63]/15 transition duration-300 hover:-translate-y-0.5 hover:bg-[#193451] hover:shadow-lg hover:shadow-[#243f63]/20 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#36577f]"
                        >
                            <i data-lucide="users" class="h-4 w-4"></i>
                            Kelola Data Siswa
                            <i data-lucide="arrow-up-right" class="h-4 w-4 transition duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"></i>
                        </a>
                    </div>
                </div>


                {{-- DASHBOARD PREVIEW --}}
                <div class="relative min-h-[400px] sm:min-h-[450px] lg:min-h-[500px]">

                    {{-- DECORATIVE RINGS --}}
                    <div class="absolute right-[-20px] top-[-35px] h-56 w-56 rounded-full border border-[#d9e3ef]"></div>
                    <div class="absolute right-[10px] top-[-5px] h-44 w-44 rounded-full border border-[#dfe7f0]"></div>

                    {{-- MAIN WINDOW --}}
                    <div
                        class="dash-window absolute inset-x-0 top-6 overflow-hidden rounded-2xl border border-[#e0e6ef] bg-white shadow-[0_24px_60px_rgba(31,52,79,0.10)] lg:left-5 lg:right-[-10px] lg:rotate-[1deg]"
                        data-parallax="6"
                    >

                        {{-- WINDOW HEADER --}}
                        <div class="flex h-12 items-center justify-between border-b border-[#e8edf3] bg-[#fafbfd] px-3 sm:px-4">

                            <div class="flex items-center gap-1.5">
                                <span class="h-2.5 w-2.5 rounded-full bg-[#d9b6ae]"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-[#e4d2a6]"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-[#a9c6b5]"></span>
                            </div>

                            <div class="flex items-center gap-2 rounded-md border border-[#e3e9f1] bg-white px-2.5 py-1 sm:px-3">
                                <i data-lucide="shield-check" class="h-3 w-3 text-[#456b97]"></i>
                                <span class="font-mono text-[8px] text-[#77869a] sm:text-[9px]">
                                    prakerin / dashboard
                                </span>
                            </div>

                            <i data-lucide="ellipsis" class="h-4 w-4 text-[#8996a7]"></i>

                        </div>

                        <div class="grid min-h-[330px] grid-cols-[82px_minmax(0,1fr)] sm:grid-cols-[112px_minmax(0,1fr)]">

                            {{-- SIDEBAR --}}
                            <aside class="border-r border-[#e8edf3] bg-[#f8fafc] p-2.5 sm:p-3">

                                <div class="mb-6 flex items-center gap-2 px-1 sm:px-1.5">

                                    <img
                                        src="{{ asset('image/logo.png') }}"
                                        alt="Logo Diskominfo Kabupaten Pacitan"
                                        class="h-7 w-7 shrink-0 object-contain sm:h-8 sm:w-8"
                                    >

                                    <span class="hidden font-semibold text-[#344760] sm:block sm:text-[10px]">
                                        PRAKERIN
                                    </span>

                                </div>

                                @foreach ([
                                    ['layout-dashboard', 'Ringkasan'],
                                    ['users', 'Data Siswa'],
                                    ['clipboard-check', 'Penilaian'],
                                    ['chart-no-axes-combined', 'Statistik'],
                                ] as [$icon, $label])

                                    <div class="mb-1.5 flex items-center gap-2 rounded-lg px-2 py-2 {{ $label === 'Ringkasan' ? 'bg-[#e8eef7] text-[#294b76]' : 'text-[#8794a5]' }}">

                                        <i data-lucide="{{ $icon }}" class="h-3.5 w-3.5 shrink-0"></i>

                                        <span class="hidden font-medium sm:block sm:text-[9px]">
                                            {{ $label }}
                                        </span>

                                    </div>

                                @endforeach

                            </aside>


                            {{-- DASHBOARD CONTENT --}}
                            <div class="min-w-0 p-3 sm:p-5">

                                {{-- HEADING --}}
                                <div class="flex items-start justify-between gap-2">

                                    <div>
                                        <p class="font-mono text-[8px] uppercase tracking-[0.12em] text-[#8a97a8]">
                                            Ringkasan
                                        </p>

                                        <h2 class="mt-1 text-xs font-bold text-[#30425a] sm:text-sm">
                                            Dashboard PRAKERIN
                                        </h2>

                                        <p class="mt-1 hidden text-[9px] text-[#8a97a8] sm:block">
                                            Ikhtisar data peserta praktik kerja lapangan
                                        </p>
                                    </div>

                                    <div class="flex shrink-0 items-center gap-1.5 rounded-full border border-[#dce7f2] bg-[#f1f5fa] px-2 py-1">
                                        <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-[#5e85b4]"></span>
                                        <span class="font-mono text-[7px] font-medium text-[#45668d]">
                                            TERDATA
                                        </span>
                                    </div>

                                </div>


                                {{-- MINI STAT CARDS --}}
                                <div class="mt-5 grid grid-cols-3 gap-1.5 sm:gap-2">

                                    <div class="rounded-lg border border-[#e4eaf2] bg-[#fbfcfe] p-2 sm:rounded-xl sm:p-3">

                                        <div class="flex items-center justify-between gap-1">
                                            <span class="font-mono text-[6px] text-[#8996a7] sm:text-[8px]">
                                                TOTAL
                                            </span>
                                            <i data-lucide="users" class="hidden h-3.5 w-3.5 text-[#5478a4] sm:block"></i>
                                        </div>

                                        <div
                                            class="mt-2 text-base font-bold tracking-tight text-[#30425a] sm:text-xl"
                                            data-counter="{{ $totalStudents }}"
                                        >{{ $totalStudents }}</div>

                                        <p class="mt-1 text-[7px] text-[#8996a7] sm:text-[9px]">
                                            Siswa
                                        </p>

                                    </div>


                                    <div class="rounded-lg border border-[#e4eaf2] bg-[#fbfcfe] p-2 sm:rounded-xl sm:p-3">

                                        <div class="flex items-center justify-between gap-1">
                                            <span class="font-mono text-[6px] text-[#8996a7] sm:text-[8px]">
                                                AKTIF
                                            </span>
                                            <i data-lucide="user-check" class="hidden h-3.5 w-3.5 text-[#5478a4] sm:block"></i>
                                        </div>

                                        <div
                                            class="mt-2 text-base font-bold tracking-tight text-[#30425a] sm:text-xl"
                                            data-counter="{{ $activeStudents }}"
                                        >{{ $activeStudents }}</div>

                                        <p class="mt-1 text-[7px] text-[#8996a7] sm:text-[9px]">
                                            Siswa aktif
                                        </p>

                                    </div>


                                    <div class="rounded-lg border border-[#e4eaf2] bg-[#fbfcfe] p-2 sm:rounded-xl sm:p-3">

                                        <div class="flex items-center justify-between gap-1">
                                            <span class="font-mono text-[6px] text-[#8996a7] sm:text-[8px]">
                                                MODUL
                                            </span>
                                            <i data-lucide="clipboard-check" class="hidden h-3.5 w-3.5 text-[#5478a4] sm:block"></i>
                                        </div>

                                        <div class="mt-2 text-base font-bold tracking-tight text-[#365b88] sm:text-xl">
                                            PKL
                                        </div>

                                        <p class="mt-1 text-[7px] text-[#8996a7] sm:text-[9px]">
                                            Pendataan
                                        </p>

                                    </div>

                                </div>


                                {{-- CHART --}}
                                <div class="relative mt-4 h-[135px] overflow-hidden rounded-xl border border-[#e4eaf2] bg-[#fbfcfe] sm:h-[155px]">

                                    <div class="absolute inset-0 bg-[linear-gradient(to_bottom,#e7edf5_1px,transparent_1px),linear-gradient(to_right,#e7edf5_1px,transparent_1px)] bg-[size:28px_28px] opacity-70"></div>

                                    <div class="absolute -bottom-16 left-[20%] h-32 w-64 rounded-full bg-[#dbe6f5]/70 blur-3xl"></div>

                                    <svg viewBox="0 0 600 180" preserveAspectRatio="none" class="absolute inset-0 h-full w-full">

                                        <defs>
                                            <linearGradient id="chartGradient" x1="0" x2="1">
                                                <stop offset="0%" stop-color="#365b88"/>
                                                <stop offset="50%" stop-color="#6288b6"/>
                                                <stop offset="100%" stop-color="#8ba8ca"/>
                                            </linearGradient>
                                        </defs>

                                        <path
                                            class="chart-path"
                                            d="M0 140 C55 130 65 105 115 112 S170 150 215 102 S280 75 325 94 S390 118 430 58 S500 45 600 25"
                                            fill="none"
                                            stroke="url(#chartGradient)"
                                            stroke-width="3"
                                            vector-effect="non-scaling-stroke"
                                        />

                                    </svg>

                                    <div class="absolute bottom-3 left-3 font-mono text-[7px] font-medium tracking-wide text-[#8291a5] sm:left-4 sm:text-[8px]">
                                        RINGKASAN AKTIVITAS SISWA
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>


                    {{-- FLOATING DATA CARD --}}
                    <div
                        class="float-card-a absolute bottom-1 left-[-3px] z-10 w-40 rounded-xl border border-[#e0e7f0] bg-white p-3.5 shadow-[0_12px_32px_rgba(35,57,84,0.09)] sm:bottom-0 sm:left-[-18px] sm:w-48 sm:p-4"
                        data-parallax="-14"
                    >

                        <div class="flex items-center justify-between">
                            <span class="font-mono text-[8px] uppercase tracking-wider text-[#8291a5]">
                                Rekap Data
                            </span>
                            <i data-lucide="database" class="h-4 w-4 text-[#456b97]"></i>
                        </div>

                        <div class="mt-2 flex items-end gap-2">
                            <span class="text-2xl font-bold tracking-tight text-[#30425a]">
                                {{ $totalStudents }}
                            </span>
                            <span class="mb-1 text-[9px] text-[#8190a3]">
                                data siswa
                            </span>
                        </div>

                        <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-[#eaf0f7]">
                            <div class="h-full w-[76%] rounded-full bg-gradient-to-r from-[#365b88] to-[#8ba8ca]"></div>
                        </div>

                    </div>


                    {{-- FLOATING STATUS --}}
                    <div
                        class="float-card-b absolute right-[-4px] top-[-5px] z-10 hidden rounded-lg border border-[#e0e7f0] bg-white px-3 py-2 shadow-[0_8px_24px_rgba(35,57,84,0.07)] sm:block"
                        data-parallax="14"
                    >

                        <div class="flex items-center gap-2">
                            <i data-lucide="file-check" class="h-3.5 w-3.5 text-[#456b97]"></i>

                            <span class="font-mono text-[8px] text-[#718198]">
                                rekap.data()
                            </span>

                            <span class="text-xs text-[#456b97]">✓</span>
                        </div>

                    </div>

                </div>
            </div>
        </section>


        {{-- UNIFIED STATISTICS CARD --}}
        <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 sm:pb-20 lg:px-8">

            <div class="stats-strip overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white shadow-[0_8px_30px_rgba(35,57,84,0.045)]">

                {{-- CARD HEADER --}}
                <div class="flex flex-col gap-2 border-b border-[#e8edf3] px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">

                    <div>
                        <div class="flex items-center gap-2">
                            <span class="h-5 w-1 rounded-full bg-[#365b88]"></span>
                            <h2 class="text-sm font-bold tracking-tight text-[#30425a] sm:text-base">
                                Ringkasan Data PRAKERIN
                            </h2>
                        </div>

                        <p class="mt-2 pl-3 text-xs leading-5 text-[#8390a1]">
                            Ikhtisar jumlah peserta dan cakupan pendataan siswa.
                        </p>
                    </div>

                    <div class="inline-flex w-fit items-center gap-2 rounded-lg border border-[#e1e8f1] bg-[#f7f9fc] px-3 py-2">
                        <i data-lucide="database" class="h-3.5 w-3.5 text-[#5478a4]"></i>
                        <span class="text-[10px] font-medium text-[#61758e]">
                            Data Sistem PRAKERIN
                        </span>
                    </div>

                </div>


                {{-- STATISTICS --}}
                <div class="grid sm:grid-cols-3">

                    {{-- TOTAL STUDENTS --}}
                    <div class="stat-item group border-b border-[#e8edf3] p-5 transition-colors duration-300 hover:bg-[#f9fbfe] sm:border-b-0 sm:border-r sm:p-6">

                        <div class="flex items-center gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#e0e8f3] bg-[#eef3fa] text-[#365b88] transition duration-300 group-hover:scale-105">
                                <i data-lucide="users-round" class="h-5 w-5"></i>
                            </div>

                            <div>
                                <div
                                    class="text-2xl font-bold tracking-tight text-[#263b55]"
                                    data-counter="{{ $totalStudents }}"
                                >{{ $totalStudents }}</div>

                                <div class="mt-1 text-xs font-medium text-[#7b899b]">
                                    Total Siswa PRAKERIN
                                </div>
                            </div>

                        </div>

                    </div>


                    {{-- ACTIVE STUDENTS --}}
                    <div class="stat-item group border-b border-[#e8edf3] p-5 transition-colors duration-300 hover:bg-[#f9fbfe] sm:border-b-0 sm:border-r sm:p-6">

                        <div class="flex items-center gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#e0e8f3] bg-[#eef3fa] text-[#456b97] transition duration-300 group-hover:scale-105">
                                <i data-lucide="user-check" class="h-5 w-5"></i>
                            </div>

                            <div>
                                <div
                                    class="text-2xl font-bold tracking-tight text-[#263b55]"
                                    data-counter="{{ $activeStudents }}"
                                >{{ $activeStudents }}</div>

                                <div class="mt-1 text-xs font-medium text-[#7b899b]">
                                    Siswa Aktif PRAKERIN
                                </div>
                            </div>

                        </div>

                    </div>


                    {{-- DATA RECAP --}}
                    <div class="stat-item group p-5 transition-colors duration-300 hover:bg-[#f9fbfe] sm:p-6">

                        <div class="flex items-center gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#e0e8f3] bg-[#eef3fa] text-[#365b88] transition duration-300 group-hover:scale-105">
                                <i data-lucide="clipboard-check" class="h-5 w-5"></i>
                            </div>

                            <div>
                                <div class="text-lg font-bold tracking-tight text-[#365b88]">
                                    PRAKERIN
                                </div>

                                <div class="mt-1 text-xs font-medium text-[#7b899b]">
                                    Pendataan dan Penilaian
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>


    {{-- FLOATING NAVIGATION --}}
    @include('partials.navbar')

    {{-- PAGE TRANSITION --}}
    @include('partials.page-transition')


    {{-- CDN LIBRARIES --}}
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollToPlugin.min.js"></script>


    {{-- ICONS + ANIMATIONS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({
                attrs: { 'stroke-width': 1.8 }
            });
        }

        if (!window.gsap) {
            console.warn('[gsap] not loaded — animations skipped');
            return;
        }

        gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

        /* ENTRANCE */
        const tl = gsap.timeline({
            defaults: { ease: 'power3.out' }
        });

        tl.from('.hero-badge', {
            y: 20,
            opacity: 0,
            duration: 0.6,
            delay: 0.15
        })
        .from('.hero-title', {
            y: 35,
            opacity: 0,
            duration: 0.8
        }, '-=0.35')
        .from('.hero-sub', {
            y: 18,
            opacity: 0,
            duration: 0.6
        }, '-=0.5')
        .from('.hero-buttons', {
            y: 15,
            opacity: 0,
            duration: 0.6
        }, '-=0.4')
        .from('.hero-footer', {
            y: 12,
            opacity: 0,
            duration: 0.5
        }, '-=0.35')
        .from('.dash-window', {
            y: 35,
            opacity: 0,
            scale: 0.98,
            duration: 0.9
        }, '-=1.0')
        .from('.float-card-a', {
            x: -25,
            opacity: 0,
            duration: 0.6
        }, '-=0.6')
        .from('.float-card-b', {
            x: 25,
            opacity: 0,
            duration: 0.6
        }, '-=0.5');

        /* AMBIENT */
        gsap.to('.float-card-a', {
            y: -8,
            duration: 3.2,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            delay: 2
        });

        gsap.to('.float-card-b', {
            y: 8,
            duration: 3.6,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            delay: 2.5
        });

        gsap.to('.orb-1', {
            x: 30,
            y: 20,
            duration: 14,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut'
        });

        gsap.to('.orb-2', {
            x: -25,
            y: 25,
            duration: 16,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut'
        });

        gsap.to('.orb-3', {
            x: 15,
            y: -20,
            duration: 18,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut'
        });

        /* CHART DRAW */
        document.querySelectorAll('.chart-path').forEach(function (path) {
            try {
                const len = path.getTotalLength();

                gsap.set(path, {
                    strokeDasharray: len,
                    strokeDashoffset: len
                });

                gsap.to(path, {
                    strokeDashoffset: 0,
                    duration: 2.2,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: path,
                        start: 'top 85%',
                        once: true
                    }
                });
            } catch (e) {
                console.warn('[chart] animation skipped', e);
            }
        });

        /* COUNTERS */
        document.querySelectorAll('[data-counter]').forEach(function (el) {
            const target = parseInt(el.dataset.counter, 10) || 0;
            const obj = { val: 0 };

            gsap.to(obj, {
                val: target,
                duration: 1.6,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 90%',
                    once: true
                },
                onUpdate: function () {
                    el.textContent = Math.round(obj.val);
                }
            });
        });

        /* STATS REVEAL */
        gsap.from('.stats-strip', {
            y: 25,
            opacity: 0,
            duration: 0.8,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: '.stats-strip',
                start: 'top 88%',
                once: true
            }
        });

        gsap.from('.stat-item', {
            y: 15,
            opacity: 0,
            duration: 0.6,
            stagger: 0.1,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: '.stats-strip',
                start: 'top 85%',
                once: true
            }
        });

        /* MOUSE PARALLAX */
        const parallaxEls = document.querySelectorAll('[data-parallax]');

        const centerX = function () {
            return window.innerWidth / 2;
        };

        const centerY = function () {
            return window.innerHeight / 2;
        };

        let mouseFrame = null;

        window.addEventListener('mousemove', function (e) {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                return;
            }

            if (mouseFrame) {
                cancelAnimationFrame(mouseFrame);
            }

            const mouseX = e.clientX;
            const mouseY = e.clientY;

            mouseFrame = requestAnimationFrame(function () {
                const dx = (mouseX - centerX()) / centerX();
                const dy = (mouseY - centerY()) / centerY();

                parallaxEls.forEach(function (el) {
                    const strength = parseFloat(el.dataset.parallax) || 0;

                    gsap.to(el, {
                        x: dx * strength,
                        y: dy * strength * 0.6,
                        duration: 1.2,
                        ease: 'power3.out',
                        overwrite: 'auto'
                    });
                });
            });
        });

        /* MAGNETIC BUTTON */
        document.querySelectorAll('.btn-magnetic').forEach(function (btn) {

            btn.addEventListener('mousemove', function (e) {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    return;
                }

                const rect = btn.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;

                gsap.to(btn, {
                    x: x * 0.1,
                    y: y * 0.15,
                    duration: 0.35,
                    ease: 'power2.out'
                });
            });

            btn.addEventListener('mouseleave', function () {
                gsap.to(btn, {
                    x: 0,
                    y: 0,
                    duration: 0.5,
                    ease: 'power2.out'
                });
            });

        });

    });
    </script>

</body>
</html>