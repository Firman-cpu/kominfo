<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detail siswa Praktik Kerja Lapangan — PRAKERIN DISKOMINFO.">

    <title>
        {{ $student->name }} — PRAKERIN
    </title>

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

<body class="min-h-screen overflow-x-hidden bg-[#0a1520] text-slate-100 antialiased selection:bg-sky-400/30">

    {{-- BACKGROUND — ICE ATMOSPHERE --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="orb-1 absolute -left-40 -top-40 h-[500px] w-[500px] rounded-full bg-sky-500/20 blur-[130px]"></div>
        <div class="orb-2 absolute -right-40 top-[18%] h-[500px] w-[500px] rounded-full bg-cyan-400/15 blur-[140px]"></div>
        <div class="orb-3 absolute bottom-[-250px] left-[35%] h-[500px] w-[500px] rounded-full bg-blue-500/15 blur-[140px]"></div>

        <div class="absolute inset-0 opacity-[0.05] [background-image:linear-gradient(rgba(186,230,253,1)_1px,transparent_1px),linear-gradient(90deg,rgba(186,230,253,1)_1px,transparent_1px)] [background-size:56px_56px] [mask-image:linear-gradient(to_bottom,black,transparent_70%)]"></div>

        <div class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2 bg-gradient-to-r from-transparent via-sky-400/60 to-transparent"></div>
    </div>


    {{-- CONTENT --}}
    <main class="relative mx-auto max-w-5xl px-4 pb-20 pt-12 sm:px-6 sm:pt-16 lg:px-8 lg:pb-28">

        {{-- BACK --}}
        <a
            class="back-link group inline-flex items-center gap-2.5 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-4 py-2 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/40 hover:bg-sky-400/[0.14]"
            href="{{ route('students.index') }}"
        >
            <i data-lucide="arrow-left" class="h-3.5 w-3.5 text-sky-300 transition group-hover:-translate-x-0.5"></i>
            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                Kembali ke Data Siswa
            </span>
        </a>


        {{-- PROFILE CARD --}}
        <section
            class="profile-card relative mt-6 overflow-hidden rounded-3xl border border-sky-200/[0.12] bg-[#0f1b2c]/80 p-6 shadow-2xl shadow-black/50 backdrop-blur-2xl sm:p-10"
        >
            <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-sky-400/50 to-transparent"></div>
            <div class="pointer-events-none absolute -right-24 -top-24 h-64 w-64 rounded-full bg-sky-500/10 blur-[100px]"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-20 h-64 w-64 rounded-full bg-cyan-400/10 blur-[110px]"></div>

            <div class="relative">

                {{-- BADGE --}}
                <div class="hero-badge mb-7 inline-flex items-center gap-2 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-3 py-1.5">
                    <i data-lucide="id-card" class="h-3.5 w-3.5 text-sky-300"></i>
                    <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                        student.detail
                    </span>
                </div>

                {{-- IDENTITY --}}
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center">

                    <div class="avatar flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 via-cyan-400 to-blue-500 text-3xl font-black text-white shadow-xl shadow-sky-500/30">
                        {{ strtoupper(
                            substr($student->name, 0, 1)
                        ) }}
                    </div>

                    <div class="min-w-0">
                        <h1 class="hero-title text-4xl font-black leading-[0.95] tracking-[-0.045em] text-white sm:text-5xl">
                            {{ $student->name }}
                        </h1>

                        <p class="hero-sub mt-3 font-mono text-[10px] uppercase tracking-[0.18em] text-slate-500">
                            {{ $student->major }}
                        </p>
                    </div>
                </div>

                {{-- DIVIDER --}}
                <div class="hero-footer mt-8 h-px w-full bg-gradient-to-r from-sky-400/30 via-cyan-300/10 to-transparent"></div>

                {{-- DATA GRID --}}
                <div class="grid mt-8 grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">

                    <div class="stat-item rounded-2xl border border-sky-200/[0.08] bg-sky-100/[0.03] p-4 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/25 hover:bg-sky-100/[0.06]">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">NIS</span>
                            <i data-lucide="hash" class="h-3.5 w-3.5 text-sky-300"></i>
                        </div>
                        <div class="mt-3 text-base font-bold text-white">
                            {{ $student->nis }}
                        </div>
                    </div>

                    <div class="stat-item rounded-2xl border border-sky-200/[0.08] bg-sky-100/[0.03] p-4 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/25 hover:bg-sky-100/[0.06]">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">Kelas</span>
                            <i data-lucide="users-round" class="h-3.5 w-3.5 text-cyan-300"></i>
                        </div>
                        <div class="mt-3 text-base font-bold text-white">
                            {{ $student->class }}
                        </div>
                    </div>

                    <div class="stat-item rounded-2xl border border-sky-200/[0.08] bg-sky-100/[0.03] p-4 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/25 hover:bg-sky-100/[0.06]">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">Mulai PKL</span>
                            <i data-lucide="calendar-plus" class="h-3.5 w-3.5 text-blue-300"></i>
                        </div>
                        <div class="mt-3 text-base font-bold text-white">
                            {{ $student->start_date?->format('d M Y') }}
                        </div>
                    </div>

                    <div class="stat-item rounded-2xl border border-sky-200/[0.08] bg-sky-100/[0.03] p-4 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/25 hover:bg-sky-100/[0.06]">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">Selesai PKL</span>
                            <i data-lucide="calendar-check" class="h-3.5 w-3.5 text-teal-300"></i>
                        </div>
                        <div class="mt-3 text-base font-bold text-white">
                            {{ $student->end_date?->format('d M Y') }}
                        </div>
                    </div>

                </div>

                {{-- STATUS --}}
                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <span class="status inline-flex items-center gap-2 rounded-full border border-teal-300/20 bg-teal-300/[0.1] px-4 py-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-teal-300 animate-pulse"></span>
                        <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-teal-200">
                            {{ ucfirst($student->status) }}
                        </span>
                    </span>
                </div>

                {{-- FOOTER NOTE --}}
                <div class="mt-8 flex items-center gap-3 font-mono text-[9px] text-slate-600">
                    <span class="text-teal-300">●</span>
                    record.loaded
                    <span class="text-slate-700">/</span>
                    <span class="text-sky-300/80">database.connected</span>
                </div>

            </div>
        </section>

    </main>


    {{-- CDN LIBRARIES --}}
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>


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

        try {
            const tl = gsap.timeline({
                defaults: { ease: 'power3.out', clearProps: 'transform,opacity' }
            });

            tl.from('.back-link',    { y: 14, opacity: 0, duration: 0.5, delay: 0.15 })
              .from('.profile-card', { y: 40, opacity: 0, scale: 0.98, duration: 0.9 }, '-=0.2')
              .from('.hero-badge',   { y: 18, opacity: 0, duration: 0.5 }, '-=0.55')
              .from('.avatar',       { scale: 0.8, opacity: 0, duration: 0.6 }, '-=0.35')
              .from('.hero-title',   { y: 26, opacity: 0, duration: 0.7 }, '-=0.45')
              .from('.hero-sub',     { y: 16, opacity: 0, duration: 0.5 }, '-=0.5')
              .from('.hero-footer',  { scaleX: 0, opacity: 0, transformOrigin: 'left center', duration: 0.7 }, '-=0.4')
              .from('.stat-item',    { y: 22, opacity: 0, duration: 0.6, stagger: 0.09 }, '-=0.45')
              .from('.status',       { y: 14, opacity: 0, duration: 0.5 }, '-=0.3');

            /* AMBIENT */
            gsap.to('.orb-1', { x: 40,  y: 30,  duration: 14, repeat: -1, yoyo: true, ease: 'sine.inOut' });
            gsap.to('.orb-2', { x: -30, y: 40,  duration: 16, repeat: -1, yoyo: true, ease: 'sine.inOut' });
            gsap.to('.orb-3', { x: 20,  y: -30, duration: 18, repeat: -1, yoyo: true, ease: 'sine.inOut' });

        } catch (err) {
            console.warn('[gsap] animation error — showing content', err);
        }

        /* SAFETY NET — pastikan konten selalu terlihat */
        window.setTimeout(function () {
            document
                .querySelectorAll('.profile-card, .hero-badge, .hero-title, .hero-sub, .hero-footer, .stat-item, .avatar, .status, .back-link')
                .forEach(function (el) {
                    el.style.opacity = '';
                    el.style.transform = '';
                    el.style.visibility = '';
                });
        }, 2500);

    });
    </script>

</body>

</html>