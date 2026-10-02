<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PRAKERIN DISKOMINFO — Sistem monitoring siswa Praktik Kerja Lapangan.">

    <title>PRAKERIN — DISKOMINFO</title>

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
    </style>
</head>

<body
    x-data="{ mobileOpen: false, scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 20"
    class="min-h-screen overflow-x-hidden bg-[#0a1520] text-slate-100 antialiased selection:bg-sky-400/30"
>

    {{-- BACKGROUND — ICE ATMOSPHERE --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="orb-1 absolute -left-40 -top-40 h-[500px] w-[500px] rounded-full bg-sky-500/20 blur-[130px]"></div>
        <div class="orb-2 absolute -right-40 top-[18%] h-[500px] w-[500px] rounded-full bg-cyan-400/15 blur-[140px]"></div>
        <div class="orb-3 absolute bottom-[-250px] left-[35%] h-[500px] w-[500px] rounded-full bg-blue-500/15 blur-[140px]"></div>

        <div class="absolute inset-0 opacity-[0.05] [background-image:linear-gradient(rgba(186,230,253,1)_1px,transparent_1px),linear-gradient(90deg,rgba(186,230,253,1)_1px,transparent_1px)] [background-size:56px_56px] [mask-image:linear-gradient(to_bottom,black,transparent_70%)]"></div>

        <div class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2 bg-gradient-to-r from-transparent via-sky-400/60 to-transparent"></div>
    </div>


    {{-- HERO --}}
    <main>
        <section class="relative mx-auto max-w-7xl px-4 pb-20 pt-16 sm:px-6 sm:pt-20 lg:px-8 lg:pb-28 lg:pt-28">
            <div class="grid items-center gap-14 lg:grid-cols-[0.9fr_1.1fr] lg:gap-20">

                <div class="relative">
                    <div class="hero-badge mb-7 inline-flex items-center gap-2 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-3 py-1.5">
                        <i data-lucide="terminal" class="h-3.5 w-3.5 text-sky-300"></i>
                        <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                            system.monitoring.init
                        </span>
                    </div>

                    <h1 class="hero-title max-w-3xl text-6xl font-black leading-[0.88] tracking-[-0.065em] text-white sm:text-7xl lg:text-[6.5rem]">
                        PRAKERIN
                        <span class="shimmer-text mt-2 block bg-gradient-to-r from-sky-200 via-cyan-200 to-blue-300 bg-clip-text text-transparent">
                            DISKOMINFO
                        </span>
                    </h1>

                    <p class="hero-sub mt-8 max-w-xl text-sm leading-7 text-slate-400 sm:text-base">
                        Platform monitoring siswa Praktik Kerja Lapangan
                        yang mengubah data kegiatan menjadi informasi
                        yang lebih terstruktur, cepat, dan mudah dipantau.
                    </p>

                    <div class="hero-buttons mt-9 flex flex-wrap items-center gap-3">
                        <a href="{{ route('students.index') }}"
                           class="btn-magnetic group inline-flex items-center gap-3 rounded-xl bg-gradient-to-r from-sky-500 via-cyan-400 to-blue-500 px-5 py-3.5 text-xs font-bold text-white shadow-xl shadow-sky-500/30 transition duration-300 hover:-translate-y-1 hover:shadow-sky-400/50">
                            <i data-lucide="database" class="h-4 w-4"></i>
                            Lihat Data Siswa
                            <i data-lucide="arrow-up-right"
                               class="h-4 w-4 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5"></i>
                        </a>
                    </div>
                </div>


                {{-- DASHBOARD VISUAL --}}
                <div class="relative min-h-[430px] lg:min-h-[520px]">

                    <div class="absolute right-[-50px] top-[-70px] h-64 w-64 rounded-full border border-sky-400/[0.12]"></div>
                    <div class="absolute right-[-15px] top-[-35px] h-52 w-52 rounded-full border border-cyan-300/[0.1]"></div>

                    <div
                        class="dash-window absolute inset-x-0 top-8 overflow-hidden rounded-3xl border border-sky-200/[0.12] bg-[#0f1b2c]/90 shadow-2xl shadow-black/50 backdrop-blur-2xl lg:left-5 lg:right-[-15px] lg:rotate-[1.5deg]"
                        data-parallax="6"
                    >
                        <div class="flex h-11 items-center justify-between border-b border-sky-200/[0.08] bg-sky-100/[0.02] px-4">
                            <div class="flex items-center gap-1.5">
                                <span class="h-2.5 w-2.5 rounded-full bg-sky-200/60"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-cyan-200/60"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-teal-200/60"></span>
                            </div>

                            <div class="flex items-center gap-2 rounded-md border border-sky-200/[0.08] bg-black/30 px-3 py-1">
                                <i data-lucide="lock-keyhole" class="h-2.5 w-2.5 text-slate-500"></i>
                                <span class="font-mono text-[8px] text-slate-500">localhost/prakerin</span>
                            </div>

                            <i data-lucide="ellipsis" class="h-4 w-4 text-slate-500"></i>
                        </div>

                        <div class="grid min-h-[360px] grid-cols-[105px_1fr]">
                            <aside class="border-r border-sky-200/[0.06] bg-black/10 p-3">
                                <div class="mb-5 flex items-center gap-2 px-2">
                                    <div class="h-5 w-5 rounded-md bg-gradient-to-br from-sky-400 to-cyan-300"></div>
                                    <div class="h-2 w-10 rounded-full bg-slate-700"></div>
                                </div>

                                @foreach ([
                                    ['layout-dashboard', 'Overview', 'sky'],
                                    ['users', 'Students', 'cyan'],
                                    ['clipboard-check', 'Assessment', 'blue'],
                                    ['chart-no-axes-combined', 'Analytics', 'teal'],
                                ] as [$icon, $label, $accent])
                                    <div class="mb-1.5 flex items-center gap-2 rounded-lg px-2 py-2 {{ $label === 'Overview' ? 'bg-sky-400/15 text-sky-100' : 'text-slate-500' }}">
                                        <i data-lucide="{{ $icon }}"
                                           class="h-3.5 w-3.5 {{ $label === 'Overview' ? 'text-sky-300' : '' }}"></i>
                                        <span class="font-mono text-[7px]">{{ $label }}</span>
                                    </div>
                                @endforeach
                            </aside>

                            <div class="p-5">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <div class="font-mono text-[7px] uppercase tracking-[0.15em] text-slate-500">overview</div>
                                        <div class="mt-1 text-sm font-bold text-slate-100">Monitoring Dashboard</div>
                                    </div>
                                    <div class="flex items-center gap-1.5 rounded-full bg-teal-300/10 px-2 py-1">
                                        <span class="h-1.5 w-1.5 rounded-full bg-teal-300 animate-pulse"></span>
                                        <span class="font-mono text-[7px] text-teal-200">LIVE</span>
                                    </div>
                                </div>

                                <div class="mt-5 grid grid-cols-3 gap-2">
                                    <div class="rounded-xl border border-sky-200/[0.08] bg-sky-100/[0.03] p-3">
                                        <div class="flex items-center justify-between">
                                            <span class="font-mono text-[7px] text-slate-500">STUDENTS</span>
                                            <i data-lucide="users" class="h-3 w-3 text-sky-300"></i>
                                        </div>
                                        <div class="mt-2 text-lg font-black text-white"
                                             data-counter="{{ $totalStudents }}">{{ $totalStudents }}</div>
                                    </div>

                                    <div class="rounded-xl border border-sky-200/[0.08] bg-sky-100/[0.03] p-3">
                                        <div class="flex items-center justify-between">
                                            <span class="font-mono text-[7px] text-slate-500">ACTIVE</span>
                                            <i data-lucide="activity" class="h-3 w-3 text-cyan-300"></i>
                                        </div>
                                        <div class="mt-2 text-lg font-black text-white"
                                             data-counter="{{ $activeStudents }}">{{ $activeStudents }}</div>
                                    </div>

                                    <div class="rounded-xl border border-sky-200/[0.08] bg-sky-100/[0.03] p-3">
                                        <div class="flex items-center justify-between">
                                            <span class="font-mono text-[7px] text-slate-500">SYSTEM</span>
                                            <i data-lucide="radio" class="h-3 w-3 text-teal-300"></i>
                                        </div>
                                        <div class="mt-2 text-lg font-black text-teal-300">ON</div>
                                    </div>
                                </div>

                                <div class="relative mt-3 h-[145px] overflow-hidden rounded-xl border border-sky-200/[0.08] bg-black/10">
                                    <div class="absolute inset-0 opacity-40 [background-image:linear-gradient(rgba(186,230,253,.06)_1px,transparent_1px),linear-gradient(90deg,rgba(186,230,253,.06)_1px,transparent_1px)] [background-size:28px_28px]"></div>
                                    <div class="absolute -bottom-20 left-[20%] h-40 w-72 rounded-full bg-sky-400/15 blur-3xl"></div>

                                    <svg viewBox="0 0 600 180" preserveAspectRatio="none" class="absolute inset-0 h-full w-full">
                                        <defs>
                                            <linearGradient id="chartGradient" x1="0" x2="1">
                                                <stop offset="0%" stop-color="#7dd3fc"/>
                                                <stop offset="50%" stop-color="#67e8f9"/>
                                                <stop offset="100%" stop-color="#60a5fa"/>
                                            </linearGradient>
                                        </defs>

                                        <path class="chart-path"
                                              d="M0 140
                                                 C55 130 65 105 115 112
                                                 S170 150 215 102
                                                 S280 75 325 94
                                                 S390 118 430 58
                                                 S500 45 600 25"
                                              fill="none"
                                              stroke="url(#chartGradient)"
                                              stroke-width="3"
                                              vector-effect="non-scaling-stroke"/>
                                    </svg>

                                    <div class="absolute bottom-3 left-4 font-mono text-[7px] text-slate-500">
                                        ACTIVITY / PERFORMANCE
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="float-card-a absolute bottom-3 left-[-5px] z-10 w-44 rounded-2xl border border-sky-200/[0.12] bg-[#0f1b2c]/90 p-4 shadow-2xl shadow-sky-900/40 backdrop-blur-xl sm:left-[-20px]"
                         data-parallax="-14">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-[8px] uppercase tracking-wider text-slate-500">database</span>
                            <i data-lucide="database" class="h-3.5 w-3.5 text-cyan-300"></i>
                        </div>
                        <div class="mt-2 flex items-end gap-2">
                            <span class="text-2xl font-black text-white">{{ $totalStudents }}</span>
                            <span class="mb-1 font-mono text-[8px] text-teal-300">records</span>
                        </div>
                        <div class="mt-3 h-1 overflow-hidden rounded-full bg-sky-100/[0.06]">
                            <div class="h-full w-[76%] rounded-full bg-gradient-to-r from-cyan-300 to-sky-400"></div>
                        </div>
                    </div>

                    <div class="float-card-b absolute right-[-5px] top-[-5px] z-10 hidden rounded-xl border border-sky-300/15 bg-[#0f1b2c]/90 px-3 py-2 shadow-xl backdrop-blur-xl sm:block"
                         data-parallax="14">
                        <div class="flex items-center gap-2">
                            <span class="text-sky-300">/</span>
                            <span class="font-mono text-[8px] text-slate-400">data.is_live()</span>
                            <span class="text-teal-300">✓</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        {{-- STATS STRIP --}}
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="stats-strip grid overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/70 backdrop-blur-xl sm:grid-cols-3">

                <div class="stat-item group border-b border-sky-200/[0.07] p-5 sm:border-b-0 sm:border-r">
                    <div class="flex items-center gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-sky-300/15 bg-sky-300/[0.08] transition group-hover:scale-110">
                            <i data-lucide="users-round" class="h-5 w-5 text-sky-300"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-black tracking-tight text-white" data-counter="{{ $totalStudents }}">{{ $totalStudents }}</div>
                            <div class="mt-0.5 font-mono text-[9px] uppercase tracking-wider text-slate-500">
                                Total Siswa PKL
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stat-item group border-b border-sky-200/[0.07] p-5 sm:border-b-0 sm:border-r">
                    <div class="flex items-center gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-cyan-300/15 bg-cyan-300/[0.08] transition group-hover:scale-110">
                            <i data-lucide="radio" class="h-5 w-5 text-cyan-300"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-black tracking-tight text-white" data-counter="{{ $activeStudents }}">{{ $activeStudents }}</div>
                            <div class="mt-0.5 font-mono text-[9px] uppercase tracking-wider text-slate-500">
                                Siswa Aktif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stat-item group p-5">
                    <div class="flex items-center gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-teal-300/15 bg-teal-300/[0.08] transition group-hover:scale-110">
                            <i data-lucide="database-zap" class="h-5 w-5 text-teal-300"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-black tracking-tight text-teal-300">LIVE</div>
                            <div class="mt-0.5 font-mono text-[9px] uppercase tracking-wider text-slate-500">
                                Data dari Database
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


    {{-- FLOATING NAV --}}
    @include('partials.navbar')

    {{-- PAGE TRANSITION --}}
    @include('partials.page-transition')


    {{-- CDN LIBRARIES --}}
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollToPlugin.min.js"></script>


    {{-- SCRIPT — ICONS + ANIMATIONS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
        }

        if (!window.gsap) {
            console.warn('[gsap] not loaded — animations skipped');
            return;
        }

        gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

        /* ENTRANCE */
        const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

        tl.from('.hero-badge', { y: 24, opacity: 0, duration: 0.7, delay: 0.2 })
          .from('.hero-title', { y: 50, opacity: 0, duration: 1 }, '-=0.4')
          .from('.hero-sub', { y: 24, opacity: 0, duration: 0.7 }, '-=0.7')
          .from('.hero-buttons', { y: 24, opacity: 0, duration: 0.7 }, '-=0.55')
          .from('.hero-footer', { y: 12, opacity: 0, duration: 0.6 }, '-=0.5')
          .from('.dash-window', { y: 60, opacity: 0, scale: 0.96, duration: 1.1 }, '-=1.3')
          .from('.float-card-a', { x: -40, opacity: 0, duration: 0.8 }, '-=0.8')
          .from('.float-card-b', { x: 40, opacity: 0, duration: 0.8 }, '-=0.7');

        /* AMBIENT */
        gsap.to('.float-card-a', { y: -12, duration: 3.2, repeat: -1, yoyo: true, ease: 'sine.inOut', delay: 2.8 });
        gsap.to('.float-card-b', { y: 12, duration: 3.6, repeat: -1, yoyo: true, ease: 'sine.inOut', delay: 3 });
        gsap.to('.orb-1', { x: 40, y: 30, duration: 14, repeat: -1, yoyo: true, ease: 'sine.inOut' });
        gsap.to('.orb-2', { x: -30, y: 40, duration: 16, repeat: -1, yoyo: true, ease: 'sine.inOut' });
        gsap.to('.orb-3', { x: 20, y: -30, duration: 18, repeat: -1, yoyo: true, ease: 'sine.inOut' });

        /* CHART DRAW */
        document.querySelectorAll('.chart-path').forEach(function (path) {
            try {
                const len = path.getTotalLength();
                gsap.set(path, { strokeDasharray: len, strokeDashoffset: len });
                gsap.to(path, {
                    strokeDashoffset: 0, duration: 2.2, ease: 'power2.out',
                    scrollTrigger: { trigger: path, start: 'top 85%', once: true }
                });
            } catch (e) {}
        });

        /* COUNTERS */
        document.querySelectorAll('[data-counter]').forEach(function (el) {
            const target = parseInt(el.dataset.counter, 10) || 0;
            const obj = { val: 0 };
            gsap.to(obj, {
                val: target, duration: 1.6, ease: 'power2.out',
                scrollTrigger: { trigger: el, start: 'top 90%', once: true },
                onUpdate: function () { el.textContent = Math.round(obj.val); }
            });
        });

        /* STATS REVEAL */
        gsap.from('.stats-strip', {
            y: 40, opacity: 0, duration: 1, ease: 'power3.out',
            scrollTrigger: { trigger: '.stats-strip', start: 'top 88%', once: true }
        });
        gsap.from('.stat-item', {
            y: 24, opacity: 0, duration: 0.7, stagger: 0.1, ease: 'power2.out',
            scrollTrigger: { trigger: '.stats-strip', start: 'top 85%', once: true }
        });

        /* MOUSE PARALLAX */
        const parallaxEls = document.querySelectorAll('[data-parallax]');
        const centerX = function () { return window.innerWidth / 2; };
        const centerY = function () { return window.innerHeight / 2; };

        window.addEventListener('mousemove', function (e) {
            const dx = (e.clientX - centerX()) / centerX();
            const dy = (e.clientY - centerY()) / centerY();
            parallaxEls.forEach(function (el) {
                const strength = parseFloat(el.dataset.parallax) || 0;
                gsap.to(el, {
                    x: dx * strength, y: dy * strength * 0.6,
                    duration: 1.2, ease: 'power3.out', overwrite: 'auto'
                });
            });
        });

        /* BUTTON MAGNETIC */
        document.querySelectorAll('.btn-magnetic').forEach(function (btn) {
            btn.addEventListener('mousemove', function (e) {
                const rect = btn.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                gsap.to(btn, { x: x * 0.15, y: y * 0.25, duration: 0.4, ease: 'power2.out' });
            });
            btn.addEventListener('mouseleave', function () {
                gsap.to(btn, { x: 0, y: 0, duration: 0.6, ease: 'elastic.out(1, 0.4)' });
            });
        });

    });
    </script>

</body>

</html>