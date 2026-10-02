<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard — PRAKERIN DISKOMINFO.">

    <title>Admin Dashboard — PRAKERIN</title>

    {{-- Preconnect: buka koneksi lebih awal --}}
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Pre-hide animatable elements SEBELUM paint pertama --}}
    <script>
        document.documentElement.classList.add('gsap-init');
    </script>

    <style>
        [x-cloak] { display: none !important; }

        /* Hide sampai GSAP siap — mencegah flash */
        html.gsap-init [data-anim] { opacity: 0; }

        @keyframes shimmer {
            0%   { background-position: 0% center; }
            100% { background-position: 200% center; }
        }
        .shimmer-text {
            background-size: 200% auto;
            animation: shimmer 6s linear infinite;
        }

        /* Orb pakai radial-gradient — visual identik dengan blur() */
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

        /* GPU promote untuk elemen yang dianimasikan */
        .stat-item,
        .action-card,
        .btn-magnetic {
            will-change: transform;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
        }
    </style>

    {{-- Script di HEAD + defer: paralel, tidak blok render --}}
    <script defer src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
</head>

<body
    x-data="{ mobileOpen: false, scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 20"
    class="min-h-screen overflow-x-hidden bg-[#0a1520] text-slate-100 antialiased selection:bg-sky-400/30"
>

    {{-- BACKGROUND — ICE ATMOSPHERE --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="orb orb-1 absolute -left-40 -top-40 h-[500px] w-[500px] rounded-full"></div>
        <div class="orb orb-2 absolute -right-40 top-[18%] h-[500px] w-[500px] rounded-full"></div>
        <div class="orb orb-3 absolute bottom-[-250px] left-[35%] h-[500px] w-[500px] rounded-full"></div>

        <div class="absolute inset-0 opacity-[0.05] [background-image:linear-gradient(rgba(186,230,253,1)_1px,transparent_1px),linear-gradient(90deg,rgba(186,230,253,1)_1px,transparent_1px)] [background-size:56px_56px] [mask-image:linear-gradient(to_bottom,black,transparent_70%)]"></div>

        <div class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2 bg-gradient-to-r from-transparent via-sky-400/60 to-transparent"></div>
    </div>


    <main class="relative mx-auto max-w-7xl px-4 pb-20 pt-12 sm:px-6 sm:pt-16 lg:px-8 lg:pb-28">

        {{-- HERO / WELCOME --}}
        <section class="relative">
            <div class="grid items-end gap-8 lg:grid-cols-[1fr_auto]">

                <div>
                    <div data-anim class="mb-6 inline-flex items-center gap-2 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-3 py-1.5">
                        <i data-lucide="shield-check" class="h-3.5 w-3.5 text-sky-300"></i>
                        <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                            admin.dashboard.active
                        </span>
                    </div>

                    <h1 data-anim class="max-w-3xl text-5xl font-black leading-[0.9] tracking-[-0.055em] text-white sm:text-6xl lg:text-7xl">
                        ADMIN
                        <span class="shimmer-text mt-1 block bg-gradient-to-r from-sky-200 via-cyan-200 to-blue-300 bg-clip-text text-transparent">
                            DASHBOARD
                        </span>
                    </h1>

                    <p data-anim class="mt-6 max-w-xl text-sm leading-7 text-slate-400 sm:text-base">
                        Selamat datang kembali,
                        <span class="font-mono text-sky-200">{{ session('admin_username') }}</span>.
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
                        class="btn-magnetic group inline-flex items-center gap-3 rounded-xl border border-red-400/25 bg-red-500/[0.08] px-4 py-3 text-xs font-bold uppercase tracking-[0.14em] text-red-200 transition duration-300 hover:-translate-y-0.5 hover:border-red-300/50 hover:bg-red-500/[0.15] hover:text-red-100"
                    >
                        <i data-lucide="log-out" class="h-4 w-4"></i>
                        Logout
                    </button>
                </form>
            </div>

            <div data-anim class="mt-8 h-px w-full bg-gradient-to-r from-sky-400/30 via-cyan-300/10 to-transparent"></div>
        </section>


        {{-- STATISTICS --}}
        <section class="mt-12">
            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    student.statistics
                </span>
                <span class="h-px flex-1 bg-sky-200/[0.08]"></span>
                <span class="flex items-center gap-1.5 font-mono text-[9px] text-slate-500">
                    <span class="h-1.5 w-1.5 rounded-full bg-teal-300 animate-pulse"></span>
                    LIVE
                </span>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                {{-- TOTAL --}}
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
                    <div class="relative mt-4 h-1 overflow-hidden rounded-full bg-sky-100/[0.06]">
                        <div class="h-full w-[84%] rounded-full bg-gradient-to-r from-sky-400 to-cyan-300"></div>
                    </div>
                </div>

                {{-- ACTIVE --}}
                <div data-anim class="stat-item group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-cyan-300/30">
                    <div class="relative flex items-start justify-between">
                        <div>
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                Siswa Aktif
                            </span>
                            <div class="mt-3 text-4xl font-black tracking-tight text-white" data-counter="{{ $activeStudents }}">
                                {{ $activeStudents }}
                            </div>
                        </div>
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-cyan-300/15 bg-cyan-300/[0.08] transition group-hover:scale-110">
                            <i data-lucide="activity" class="h-5 w-5 text-cyan-300"></i>
                        </div>
                    </div>
                    <div class="relative mt-4 h-1 overflow-hidden rounded-full bg-sky-100/[0.06]">
                        <div class="h-full w-[62%] rounded-full bg-gradient-to-r from-cyan-400 to-teal-300"></div>
                    </div>
                </div>

                {{-- COMPLETED --}}
                <div data-anim class="stat-item group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-teal-300/30">
                    <div class="relative flex items-start justify-between">
                        <div>
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                Selesai PKL
                            </span>
                            <div class="mt-3 text-4xl font-black tracking-tight text-white" data-counter="{{ $completedStudents }}">
                                {{ $completedStudents }}
                            </div>
                        </div>
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-teal-300/15 bg-teal-300/[0.08] transition group-hover:scale-110">
                            <i data-lucide="check-check" class="h-5 w-5 text-teal-300"></i>
                        </div>
                    </div>
                    <div class="relative mt-4 h-1 overflow-hidden rounded-full bg-sky-100/[0.06]">
                        <div class="h-full w-[48%] rounded-full bg-gradient-to-r from-teal-400 to-emerald-300"></div>
                    </div>
                </div>

                {{-- INACTIVE --}}
                <div data-anim class="stat-item group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-slate-300/25">
                    <div class="relative flex items-start justify-between">
                        <div>
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                Tidak Aktif
                            </span>
                            <div class="mt-3 text-4xl font-black tracking-tight text-white" data-counter="{{ $inactiveStudents }}">
                                {{ $inactiveStudents }}
                            </div>
                        </div>
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-slate-300/15 bg-slate-300/[0.08] transition group-hover:scale-110">
                            <i data-lucide="user-minus" class="h-5 w-5 text-slate-300"></i>
                        </div>
                    </div>
                    <div class="relative mt-4 h-1 overflow-hidden rounded-full bg-sky-100/[0.06]">
                        <div class="h-full w-[22%] rounded-full bg-gradient-to-r from-slate-400 to-slate-300"></div>
                    </div>
                </div>

            </div>
        </section>


        {{-- QUICK ACTIONS --}}
        <section class="mt-14">
            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    admin.controls
                </span>
                <span class="h-px flex-1 bg-sky-200/[0.08]"></span>
            </div>

            <div class="grid gap-4 lg:grid-cols-3">

                {{-- ANALYTICS --}}
                <a
                    data-anim
                    href="{{ route('admin.analytics.index') }}"
                    class="action-card group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-6 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-sky-300/30 hover:bg-[#0f1b2c]/90"
                >
                    <div class="relative">
                        <div class="flex items-start justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-sky-300/15 bg-sky-300/[0.08] transition group-hover:scale-110">
                                <i data-lucide="chart-no-axes-combined" class="h-5 w-5 text-sky-300"></i>
                            </div>
                            <i data-lucide="arrow-up-right" class="h-4 w-4 text-slate-500 transition group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-sky-300"></i>
                        </div>

                        <h3 class="mt-6 text-lg font-bold text-white">
                            Analytics Siswa
                        </h3>

                        <p class="mt-2 text-xs leading-6 text-slate-400">
                            Lihat performa, tren, dan metrik aktivitas siswa PKL.
                        </p>

                        <div class="mt-5 font-mono text-[9px] uppercase tracking-[0.18em] text-slate-600">
                            /admin/analytics
                        </div>
                    </div>
                </a>

                {{-- ASSESSMENTS --}}
                <a
                    data-anim
                    href="{{ route('admin.assessments.index') }}"
                    class="action-card group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-6 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-cyan-300/30 hover:bg-[#0f1b2c]/90"
                >
                    <div class="relative">
                        <div class="flex items-start justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-cyan-300/15 bg-cyan-300/[0.08] transition group-hover:scale-110">
                                <i data-lucide="clipboard-check" class="h-5 w-5 text-cyan-300"></i>
                            </div>
                            <i data-lucide="arrow-up-right" class="h-4 w-4 text-slate-500 transition group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-cyan-300"></i>
                        </div>

                        <h3 class="mt-6 text-lg font-bold text-white">
                            Kelola Penilaian Siswa
                        </h3>

                        <p class="mt-2 text-xs leading-6 text-slate-400">
                            Input dan perbarui nilai serta evaluasi siswa PKL.
                        </p>

                        <div class="mt-5 font-mono text-[9px] uppercase tracking-[0.18em] text-slate-600">
                            /admin/assessments
                        </div>
                    </div>
                </a>

                {{-- STUDENTS --}}
                <a
                    data-anim
                    href="{{ route('admin.students.index') }}"
                    class="action-card group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-6 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-teal-300/30 hover:bg-[#0f1b2c]/90"
                >
                    <div class="relative">
                        <div class="flex items-start justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-teal-300/15 bg-teal-300/[0.08] transition group-hover:scale-110">
                                <i data-lucide="database" class="h-5 w-5 text-teal-300"></i>
                            </div>
                            <i data-lucide="arrow-up-right" class="h-4 w-4 text-slate-500 transition group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-teal-300"></i>
                        </div>

                        <h3 class="mt-6 text-lg font-bold text-white">
                            Kelola Data Siswa
                        </h3>

                        <p class="mt-2 text-xs leading-6 text-slate-400">
                            Tambah, ubah, dan hapus data siswa Praktik Kerja Lapangan.
                        </p>

                        <div class="mt-5 font-mono text-[9px] uppercase tracking-[0.18em] text-slate-600">
                            /admin/students
                        </div>
                    </div>
                </a>

            </div>
        </section>

        {{-- FOOTER NOTE --}}
        <div data-anim class="mt-14 flex items-center justify-center gap-3 font-mono text-[9px] text-slate-600">
            <span class="text-teal-300">●</span>
            session.authenticated
            <span class="text-slate-700">/</span>
            <span class="text-sky-300/80">admin.panel</span>
        </div>

    </main>


    {{-- SCRIPT — ICONS + ANIMATIONS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        var root = document.documentElement;

        /* ICONS */
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
        }

        /* FALLBACK kalau GSAP tidak ada — tampilkan konten */
        if (!window.gsap) {
            root.classList.remove('gsap-init');
            return;
        }

        gsap.config({ force3D: true });
        gsap.ticker.lagSmoothing(500, 33);

        try {
            /* Buat timeline — .from() langsung set inline opacity 0
               jadi tidak ada flash saat class gsap-init dilepas. */
            var tl = gsap.timeline({
                defaults: { ease: 'power3.out', clearProps: 'transform,opacity' }
            });

            tl.from('[data-anim]', {
                y: 24,
                opacity: 0,
                duration: 0.65,
                stagger: { each: 0.045, from: 'start' }
            });

            /* Lepas CSS-hide — inline style dari GSAP sudah pegang kendali */
            root.classList.remove('gsap-init');

            /* AMBIENT — orb pakai transform only, tanpa filter */
            gsap.to('.orb-1', { x: 40,  y: 30,  duration: 14, repeat: -1, yoyo: true, ease: 'sine.inOut' });
            gsap.to('.orb-2', { x: -30, y: 40,  duration: 16, repeat: -1, yoyo: true, ease: 'sine.inOut' });
            gsap.to('.orb-3', { x: 20,  y: -30, duration: 18, repeat: -1, yoyo: true, ease: 'sine.inOut' });

            /* COUNTERS — rAF manual, tanpa ScrollTrigger */
            document.querySelectorAll('[data-counter]').forEach(function (el) {
                var target = parseInt(el.dataset.counter, 10) || 0;
                var start = null;
                var duration = 1200;

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

            /* LOGOUT BUTTON MAGNETIC */
            document.querySelectorAll('.btn-magnetic').forEach(function (btn) {
                btn.addEventListener('mousemove', function (e) {
                    var rect = btn.getBoundingClientRect();
                    var x = e.clientX - rect.left - rect.width / 2;
                    var y = e.clientY - rect.top - rect.height / 2;
                    gsap.to(btn, { x: x * 0.12, y: y * 0.2, duration: 0.4, ease: 'power2.out' });
                });
                btn.addEventListener('mouseleave', function () {
                    gsap.to(btn, { x: 0, y: 0, duration: 0.6, ease: 'elastic.out(1, 0.4)' });
                });
            });

        } catch (err) {
            console.warn('[gsap] animation error — showing content', err);
            root.classList.remove('gsap-init');
        }

        /* SAFETY NET — paksa visible kalau ada yang stuck */
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