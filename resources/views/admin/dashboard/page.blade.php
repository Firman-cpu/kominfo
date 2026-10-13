<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard — PRAKERIN DISKOMINFO PACITAN.">
    <meta name="theme-color" content="#f5f7fa">

    <title>Admin Dashboard — PRAKERIN</title>

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Prevent animation flash --}}
    <script>
        document.documentElement.classList.add('gsap-init');
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        html.gsap-init [data-anim] {
            opacity: 0;
        }

        @keyframes shimmer {
            0% {
                background-position: 0% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        .shimmer-text {
            background-size: 200% auto;
            animation: shimmer 6s linear infinite;
        }

        .orb {
            will-change: transform;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
        }

        .orb-1 {
            background: radial-gradient(
                circle,
                rgba(65, 107, 158, 0.15) 0%,
                rgba(65, 107, 158, 0.07) 35%,
                rgba(65, 107, 158, 0.02) 60%,
                transparent 75%
            );
        }

        .orb-2 {
            background: radial-gradient(
                circle,
                rgba(125, 211, 252, 0.22) 0%,
                rgba(125, 211, 252, 0.08) 38%,
                rgba(125, 211, 252, 0.02) 62%,
                transparent 78%
            );
        }

        .orb-3 {
            background: radial-gradient(
                circle,
                rgba(59, 130, 246, 0.12) 0%,
                rgba(59, 130, 246, 0.05) 38%,
                rgba(59, 130, 246, 0.01) 62%,
                transparent 78%
            );
        }

        .stat-item,
        .action-card,
        .btn-magnetic {
            backface-visibility: hidden;
        }

        .grid-mask {
            -webkit-mask-image: linear-gradient(to bottom, black, transparent 85%);
            mask-image: linear-gradient(to bottom, black, transparent 85%);
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
</head>

<body
    class="min-h-screen overflow-x-hidden bg-[#f5f7fa] text-[#263449] antialiased selection:bg-[#416b9e]/15"
>

    {{-- BACKGROUND --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="orb orb-1 absolute -left-40 -top-40 h-[500px] w-[500px] rounded-full"></div>
        <div class="orb orb-2 absolute -right-40 top-[18%] h-[500px] w-[500px] rounded-full"></div>
        <div class="orb orb-3 absolute bottom-[-250px] left-[35%] h-[500px] w-[500px] rounded-full"></div>

        <div class="grid-mask absolute inset-0 opacity-70 [background-image:linear-gradient(#e6ecf4_1px,transparent_1px),linear-gradient(90deg,#e6ecf4_1px,transparent_1px)] [background-size:56px_56px]"></div>

        <div class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2 bg-gradient-to-r from-transparent via-[#416b9e]/40 to-transparent"></div>
    </div>


    <main class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 sm:pt-14 lg:px-8 lg:pb-28">

        {{-- HERO / WELCOME --}}
        <section class="relative">
            <div class="grid items-end gap-8 lg:grid-cols-[1fr_auto]">

                <div>
                    <div
                        data-anim
                        class="mb-6 inline-flex items-center gap-2 rounded-full border border-[#dce6f2] bg-white/80 px-3 py-1.5 shadow-sm"
                    >
                        <i data-lucide="shield-check" class="h-3.5 w-3.5 text-[#365b88]"></i>

                        <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-[#365b88]">
                            admin.dashboard.active
                        </span>
                    </div>

                    <h1
                        data-anim
                        class="max-w-3xl text-5xl font-black leading-[0.9] tracking-[-0.055em] text-[#263449] sm:text-6xl lg:text-7xl"
                    >
                        ADMIN

                        <span class="shimmer-text mt-1 block bg-gradient-to-r from-[#243f63] via-[#416b9e] to-sky-500 bg-clip-text text-transparent">
                            DASHBOARD
                        </span>
                    </h1>

                    <p data-anim class="mt-6 max-w-xl text-sm leading-7 text-[#718096] sm:text-base">
                        Selamat datang kembali,

                        <span class="font-mono font-semibold text-[#365b88]">
                            {{ session('admin_username') }}
                        </span>.

                        Kelola data siswa Praktik Kerja Lapangan dari satu pusat kendali.
                    </p>
                </div>


                {{-- LOGOUT --}}
                <form
                    data-anim
                    action="{{ route('admin.logout') }}"
                    method="POST"
                >
                    @csrf

                    <button
                        type="submit"
                        class="btn-magnetic group inline-flex items-center gap-3 rounded-xl border border-red-200 bg-white px-4 py-3 text-xs font-bold uppercase tracking-[0.14em] text-red-600 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-red-300 hover:bg-red-50 hover:shadow-md focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-red-500/10"
                    >
                        <i data-lucide="log-out" class="h-4 w-4"></i>
                        Logout
                    </button>
                </form>

            </div>

            <div data-anim class="mt-8 h-px w-full bg-gradient-to-r from-[#416b9e]/30 via-[#416b9e]/10 to-transparent"></div>
        </section>


        {{-- STATISTICS --}}
        <section class="mt-12">

            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[10px] font-bold uppercase tracking-[0.18em] text-[#718096]">
                    student.statistics
                </span>

                <span class="h-px flex-1 bg-[#e0e7f0]"></span>

                <span class="flex items-center gap-1.5 font-mono text-[9px] text-[#8390a1]">
                    <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-emerald-500"></span>
                    LIVE
                </span>
            </div>


            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                {{-- TOTAL STUDENTS --}}
                <div
                    data-anim
                    class="stat-item group relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-5 shadow-[0_4px_20px_-12px_rgba(36,63,99,0.16)] transition duration-300 hover:-translate-y-1 hover:border-[#b9cbe0] hover:shadow-lg"
                >
                    <div class="relative flex items-start justify-between">
                        <div>
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-[#8390a1]">
                                Total Siswa
                            </span>

                            <div
                                class="mt-3 text-4xl font-black tracking-tight text-[#263449]"
                                data-counter="{{ $totalStudents }}"
                            >
                                {{ $totalStudents }}
                            </div>
                        </div>

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#dce6f2] bg-[#f1f6fc] transition duration-300 group-hover:scale-110">
                            <i data-lucide="users-round" class="h-5 w-5 text-[#365b88]"></i>
                        </div>
                    </div>

                    <div class="relative mt-4 h-1 overflow-hidden rounded-full bg-[#edf1f6]">
                        <div class="h-full w-[84%] rounded-full bg-gradient-to-r from-[#243f63] to-[#416b9e]"></div>
                    </div>

                    <div class="mt-3 flex items-center justify-between text-[10px] text-[#8390a1]">
                        <span>Seluruh data siswa</span>
                        <i data-lucide="users" class="h-3.5 w-3.5 text-[#9aa7b8]"></i>
                    </div>
                </div>


                {{-- ACTIVE STUDENTS --}}
                <div
                    data-anim
                    class="stat-item group relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-5 shadow-[0_4px_20px_-12px_rgba(36,63,99,0.16)] transition duration-300 hover:-translate-y-1 hover:border-cyan-200 hover:shadow-lg"
                >
                    <div class="relative flex items-start justify-between">
                        <div>
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-[#8390a1]">
                                Siswa Aktif
                            </span>

                            <div
                                class="mt-3 text-4xl font-black tracking-tight text-[#263449]"
                                data-counter="{{ $activeStudents }}"
                            >
                                {{ $activeStudents }}
                            </div>
                        </div>

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-cyan-100 bg-cyan-50 transition duration-300 group-hover:scale-110">
                            <i data-lucide="activity" class="h-5 w-5 text-cyan-700"></i>
                        </div>
                    </div>

                    <div class="relative mt-4 h-1 overflow-hidden rounded-full bg-[#edf1f6]">
                        <div class="h-full w-[62%] rounded-full bg-gradient-to-r from-cyan-500 to-teal-400"></div>
                    </div>

                    <div class="mt-3 flex items-center justify-between text-[10px] text-[#8390a1]">
                        <span>Sedang menjalani PKL</span>
                        <i data-lucide="activity" class="h-3.5 w-3.5 text-cyan-600"></i>
                    </div>
                </div>


                {{-- COMPLETED STUDENTS --}}
                <div
                    data-anim
                    class="stat-item group relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-5 shadow-[0_4px_20px_-12px_rgba(36,63,99,0.16)] transition duration-300 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-lg"
                >
                    <div class="relative flex items-start justify-between">
                        <div>
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-[#8390a1]">
                                Selesai PKL
                            </span>

                            <div
                                class="mt-3 text-4xl font-black tracking-tight text-[#263449]"
                                data-counter="{{ $completedStudents }}"
                            >
                                {{ $completedStudents }}
                            </div>
                        </div>

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-emerald-100 bg-emerald-50 transition duration-300 group-hover:scale-110">
                            <i data-lucide="check-check" class="h-5 w-5 text-emerald-600"></i>
                        </div>
                    </div>

                    <div class="relative mt-4 h-1 overflow-hidden rounded-full bg-[#edf1f6]">
                        <div class="h-full w-[48%] rounded-full bg-gradient-to-r from-emerald-500 to-teal-400"></div>
                    </div>

                    <div class="mt-3 flex items-center justify-between text-[10px] text-[#8390a1]">
                        <span>Program telah selesai</span>
                        <i data-lucide="check-circle-2" class="h-3.5 w-3.5 text-emerald-600"></i>
                    </div>
                </div>


                {{-- INACTIVE STUDENTS --}}
                <div
                    data-anim
                    class="stat-item group relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-5 shadow-[0_4px_20px_-12px_rgba(36,63,99,0.16)] transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-lg"
                >
                    <div class="relative flex items-start justify-between">
                        <div>
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-[#8390a1]">
                                Tidak Aktif
                            </span>

                            <div
                                class="mt-3 text-4xl font-black tracking-tight text-[#263449]"
                                data-counter="{{ $inactiveStudents }}"
                            >
                                {{ $inactiveStudents }}
                            </div>
                        </div>

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 transition duration-300 group-hover:scale-110">
                            <i data-lucide="user-minus" class="h-5 w-5 text-slate-500"></i>
                        </div>
                    </div>

                    <div class="relative mt-4 h-1 overflow-hidden rounded-full bg-[#edf1f6]">
                        <div class="h-full w-[22%] rounded-full bg-gradient-to-r from-slate-400 to-slate-300"></div>
                    </div>

                    <div class="mt-3 flex items-center justify-between text-[10px] text-[#8390a1]">
                        <span>Perlu pemantauan</span>
                        <i data-lucide="user-round-x" class="h-3.5 w-3.5 text-slate-500"></i>
                    </div>
                </div>

            </div>
        </section>


        {{-- QUICK ACTIONS --}}
        <section class="mt-14">

            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[10px] font-bold uppercase tracking-[0.18em] text-[#718096]">
                    admin.controls
                </span>

                <span class="h-px flex-1 bg-[#e0e7f0]"></span>

                <span class="font-mono text-[9px] text-[#9aa7b8]">
                    QUICK ACCESS
                </span>
            </div>


            <div class="grid gap-4 lg:grid-cols-3">

                {{-- ANALYTICS --}}
                <a
                    data-anim
                    href="{{ route('admin.analytics.index') }}"
                    class="action-card group relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-6 shadow-[0_4px_20px_-12px_rgba(36,63,99,0.16)] transition duration-300 hover:-translate-y-1 hover:border-[#b9cbe0] hover:shadow-xl focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-[#416b9e]/15"
                >
                    <div class="relative">
                        <div class="flex items-start justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-[#dce6f2] bg-[#f1f6fc] transition duration-300 group-hover:scale-110">
                                <i data-lucide="chart-no-axes-combined" class="h-5 w-5 text-[#365b88]"></i>
                            </div>

                            <i data-lucide="arrow-up-right" class="h-4 w-4 text-[#a0aaba] transition duration-300 group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-[#365b88]"></i>
                        </div>

                        <h3 class="mt-6 text-lg font-bold text-[#263449]">
                            Analytics Siswa
                        </h3>

                        <p class="mt-2 text-xs leading-6 text-[#718096]">
                            Lihat performa, tren, dan metrik aktivitas siswa PKL.
                        </p>

                        <div class="mt-5 flex items-center justify-between border-t border-[#edf1f6] pt-4">
                            <span class="font-mono text-[9px] uppercase tracking-[0.12em] text-[#9aa7b8]">
                                /admin/analytics
                            </span>

                            <span class="flex items-center gap-1 text-[10px] font-semibold text-[#365b88] opacity-0 transition duration-300 group-hover:opacity-100">
                                Buka
                                <i data-lucide="arrow-right" class="h-3 w-3"></i>
                            </span>
                        </div>
                    </div>
                </a>


                {{-- ASSESSMENTS --}}
                <a
                    data-anim
                    href="{{ route('admin.assessments.index') }}"
                    class="action-card group relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-6 shadow-[0_4px_20px_-12px_rgba(36,63,99,0.16)] transition duration-300 hover:-translate-y-1 hover:border-cyan-200 hover:shadow-xl focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-cyan-500/10"
                >
                    <div class="relative">
                        <div class="flex items-start justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-cyan-100 bg-cyan-50 transition duration-300 group-hover:scale-110">
                                <i data-lucide="clipboard-check" class="h-5 w-5 text-cyan-700"></i>
                            </div>

                            <i data-lucide="arrow-up-right" class="h-4 w-4 text-[#a0aaba] transition duration-300 group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-cyan-700"></i>
                        </div>

                        <h3 class="mt-6 text-lg font-bold text-[#263449]">
                            Kelola Penilaian Siswa
                        </h3>

                        <p class="mt-2 text-xs leading-6 text-[#718096]">
                            Input dan perbarui nilai serta evaluasi siswa PKL.
                        </p>

                        <div class="mt-5 flex items-center justify-between border-t border-[#edf1f6] pt-4">
                            <span class="font-mono text-[9px] uppercase tracking-[0.12em] text-[#9aa7b8]">
                                /admin/assessments
                            </span>

                            <span class="flex items-center gap-1 text-[10px] font-semibold text-cyan-700 opacity-0 transition duration-300 group-hover:opacity-100">
                                Buka
                                <i data-lucide="arrow-right" class="h-3 w-3"></i>
                            </span>
                        </div>
                    </div>
                </a>


                {{-- STUDENTS --}}
                <a
                    data-anim
                    href="{{ route('admin.students.index') }}"
                    class="action-card group relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-6 shadow-[0_4px_20px_-12px_rgba(36,63,99,0.16)] transition duration-300 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-xl focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-emerald-500/10"
                >
                    <div class="relative">
                        <div class="flex items-start justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-emerald-100 bg-emerald-50 transition duration-300 group-hover:scale-110">
                                <i data-lucide="database" class="h-5 w-5 text-emerald-700"></i>
                            </div>

                            <i data-lucide="arrow-up-right" class="h-4 w-4 text-[#a0aaba] transition duration-300 group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-emerald-700"></i>
                        </div>

                        <h3 class="mt-6 text-lg font-bold text-[#263449]">
                            Kelola Data Siswa
                        </h3>

                        <p class="mt-2 text-xs leading-6 text-[#718096]">
                            Tambah, ubah, dan hapus data siswa Praktik Kerja Lapangan.
                        </p>

                        <div class="mt-5 flex items-center justify-between border-t border-[#edf1f6] pt-4">
                            <span class="font-mono text-[9px] uppercase tracking-[0.12em] text-[#9aa7b8]">
                                /admin/students
                            </span>

                            <span class="flex items-center gap-1 text-[10px] font-semibold text-emerald-700 opacity-0 transition duration-300 group-hover:opacity-100">
                                Buka
                                <i data-lucide="arrow-right" class="h-3 w-3"></i>
                            </span>
                        </div>
                    </div>
                </a>

            </div>
        </section>


        {{-- FOOTER --}}
        <footer data-anim class="mt-14 border-t border-[#e0e7f0] pt-6">

            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">

                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#243f63] text-white">
                        <i data-lucide="graduation-cap" class="h-4 w-4"></i>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-[#3b4d65]">
                            PRAKERIN DISKOMINFO
                        </p>

                        <p class="mt-0.5 text-[10px] text-[#9aa7b8]">
                            Kabupaten Pacitan
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-3 font-mono text-[9px] text-[#8390a1]">
                    <span class="flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        session.authenticated
                    </span>

                    <span class="text-[#d1d9e4]">/</span>

                    <span class="text-[#416b9e]">
                        admin.panel
                    </span>
                </div>

                <p class="text-[10px] text-[#9aa7b8]">
                    &copy; {{ date('Y') }} DISKOMINFO Pacitan
                </p>

            </div>

        </footer>

    </main>


    {{-- ICONS + ANIMATIONS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var root = document.documentElement;

            function showContent() {
                root.classList.remove('gsap-init');

                document.querySelectorAll('[data-anim]').forEach(function (el) {
                    el.style.opacity = '';
                    el.style.transform = '';
                    el.style.visibility = '';
                });
            }

            // Icons
            if (window.lucide && typeof window.lucide.createIcons === 'function') {
                window.lucide.createIcons({
                    attrs: {
                        'stroke-width': 1.8
                    }
                });
            }

            // GSAP fallback
            if (!window.gsap) {
                showContent();
                console.warn('[gsap] not loaded — animations skipped');
                return;
            }

            var prefersReducedMotion = window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;

            try {
                if (prefersReducedMotion) {
                    showContent();
                    return;
                }

                gsap.config({
                    force3D: true
                });

                gsap.ticker.lagSmoothing(500, 33);

                // Entrance animation
                var timeline = gsap.timeline({
                    defaults: {
                        ease: 'power3.out'
                    },
                    onComplete: function () {
                        document.querySelectorAll('[data-anim]').forEach(function (el) {
                            el.style.opacity = '';
                            el.style.transform = '';
                        });
                    }
                });

                timeline.from('[data-anim]', {
                    y: 22,
                    opacity: 0,
                    duration: 0.65,
                    stagger: {
                        each: 0.045,
                        from: 'start'
                    },
                    clearProps: 'transform'
                });

                // Release CSS pre-hide after GSAP has initialized.
                root.classList.remove('gsap-init');

                // Ambient background movement
                gsap.to('.orb-1', {
                    x: 40,
                    y: 30,
                    duration: 14,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });

                gsap.to('.orb-2', {
                    x: -30,
                    y: 40,
                    duration: 16,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });

                gsap.to('.orb-3', {
                    x: 20,
                    y: -30,
                    duration: 18,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });

                // Statistics counters
                document.querySelectorAll('[data-counter]').forEach(function (el) {
                    var target = parseInt(el.dataset.counter, 10) || 0;
                    var start = null;
                    var duration = 1200;

                    function step(timestamp) {
                        if (start === null) {
                            start = timestamp;
                        }

                        var progress = Math.min(
                            (timestamp - start) / duration,
                            1
                        );

                        var eased = 1 - Math.pow(1 - progress, 3);

                        el.textContent = Math.round(target * eased);

                        if (progress < 1) {
                            requestAnimationFrame(step);
                        } else {
                            el.textContent = target;
                        }
                    }

                    requestAnimationFrame(step);
                });

                // Magnetic logout button: mouse only
                var finePointer = window.matchMedia(
                    '(hover: hover) and (pointer: fine)'
                ).matches;

                if (finePointer) {
                    document.querySelectorAll('.btn-magnetic').forEach(function (btn) {
                        btn.addEventListener('mousemove', function (event) {
                            var rect = btn.getBoundingClientRect();

                            var x = event.clientX - rect.left - rect.width / 2;
                            var y = event.clientY - rect.top - rect.height / 2;

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
                                duration: 0.55,
                                ease: 'elastic.out(1, 0.45)'
                            });
                        });
                    });
                }

            } catch (error) {
                console.warn('[gsap] animation error — showing content', error);
                showContent();
            }

            // Safety net
            window.setTimeout(function () {
                root.classList.remove('gsap-init');

                document.querySelectorAll('[data-anim]').forEach(function (el) {
                    if (getComputedStyle(el).opacity === '0') {
                        el.style.opacity = '';
                        el.style.transform = '';
                    }
                });
            }, 1800);
        });
    </script>

</body>

</html>