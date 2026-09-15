<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Data Siswa PRAKERIN DISKOMINFO — Daftar siswa Praktik Kerja Lapangan.">

    <title>Data Siswa — PRAKERIN DISKOMINFO</title>

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
    x-data="{ mobileOpen: false }"
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


    <main class="relative mx-auto max-w-7xl px-4 pb-40 pt-16 sm:px-6 sm:pt-20 lg:px-8 lg:pt-24">

        {{-- HEADER --}}
        <header class="students-head mb-12 flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
            <div class="max-w-2xl">
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-3 py-1.5">
                    <i data-lucide="users" class="h-3.5 w-3.5 text-sky-300"></i>
                    <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                        students.index
                    </span>
                </div>

                <h1 class="text-5xl font-black leading-[0.95] tracking-[-0.05em] text-white sm:text-6xl lg:text-7xl">
                    Data
                    <span class="shimmer-text block bg-gradient-to-r from-sky-200 via-cyan-200 to-blue-300 bg-clip-text text-transparent">
                        Siswa PKL
                    </span>
                </h1>
            </div>

            <p class="max-w-md text-sm leading-7 text-slate-400">
                Daftar siswa yang sedang melaksanakan
                Praktik Kerja Lapangan di DISKOMINFO.
            </p>
        </header>


        {{-- STATS MINI --}}
        <div class="stats-strip mb-10 grid overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/70 backdrop-blur-xl sm:grid-cols-2">
            <div class="flex items-center gap-4 border-b border-sky-200/[0.07] p-5 sm:border-b-0 sm:border-r">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-sky-300/15 bg-sky-300/[0.08]">
                    <i data-lucide="database" class="h-5 w-5 text-sky-300"></i>
                </div>
                <div>
                    <div class="text-2xl font-black tracking-tight text-white">
                        {{ $students->total() }}
                    </div>
                    <div class="mt-0.5 font-mono text-[9px] uppercase tracking-wider text-slate-500">
                        Total Records
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4 p-5">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-teal-300/15 bg-teal-300/[0.08]">
                    <i data-lucide="layers" class="h-5 w-5 text-teal-300"></i>
                </div>
                <div>
                    <div class="text-2xl font-black tracking-tight text-white">
                        {{ $students->currentPage() }}
                        <span class="text-slate-600">/</span>
                        {{ $students->lastPage() }}
                    </div>
                    <div class="mt-0.5 font-mono text-[9px] uppercase tracking-wider text-slate-500">
                        Halaman
                    </div>
                </div>
            </div>
        </div>


        {{-- STUDENT GRID --}}
        @if ($students->count())

            <section class="students grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($students as $student)
                    <article class="student-card group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-sky-100/[0.025] p-6 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1.5 hover:border-sky-200/[0.22] hover:bg-sky-100/[0.05]">

                        <div class="pointer-events-none absolute -top-20 -right-20 h-40 w-40 rounded-full bg-sky-400/[0.06] blur-3xl transition duration-500 group-hover:bg-sky-300/[0.14]"></div>

                        <div class="relative mb-5 flex items-start justify-between">
                            <div class="avatar flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-400 via-cyan-300 to-blue-400 text-lg font-black text-white shadow-lg shadow-sky-500/25 transition duration-300 group-hover:scale-110 group-hover:rotate-6">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>

                            <span class="shrink-0 rounded-full border px-2.5 py-1 font-mono text-[8px] font-bold uppercase tracking-wider
                                {{ strtolower($student->status) === 'active'
                                    ? 'border-teal-300/25 bg-teal-300/[0.1] text-teal-200'
                                    : 'border-sky-300/25 bg-sky-300/[0.1] text-sky-200' }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </div>

                        <h2 class="relative truncate text-lg font-black tracking-tight text-white">
                            {{ $student->name }}
                        </h2>

                        <p class="relative mt-1 truncate font-mono text-[10px] uppercase tracking-wider text-sky-300/80">
                            {{ $student->major }}
                        </p>

                        <div class="relative mt-5 space-y-0">
                            <div class="flex items-center justify-between border-b border-sky-200/[0.06] py-2.5">
                                <span class="flex items-center gap-1.5 font-mono text-[9px] uppercase tracking-wider text-slate-500">
                                    <i data-lucide="graduation-cap" class="h-3 w-3 text-sky-300/70"></i>
                                    Kelas
                                </span>
                                <strong class="text-xs font-bold text-slate-200">
                                    {{ $student->class }}
                                </strong>
                            </div>

                            <div class="flex items-center justify-between border-b border-sky-200/[0.06] py-2.5">
                                <span class="flex items-center gap-1.5 font-mono text-[9px] uppercase tracking-wider text-slate-500">
                                    <i data-lucide="calendar-days" class="h-3 w-3 text-cyan-300/70"></i>
                                    Mulai
                                </span>
                                <strong class="text-xs font-bold text-slate-200">
                                    {{ $student->start_date?->format('d M Y') }}
                                </strong>
                            </div>
                        </div>

                        <a href="{{ route('students.show', $student) }}"
                           class="relative mt-5 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-sky-300/15 bg-gradient-to-r from-sky-500/[0.14] via-cyan-400/[0.12] to-blue-500/[0.14] px-4 py-2.5 text-[11px] font-bold text-sky-100 transition duration-300 hover:border-sky-300/30 hover:from-sky-500/25 hover:via-cyan-400/20 hover:to-blue-500/25 hover:text-white">
                            Lihat Detail
                            <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5"></i>
                        </a>

                    </article>
                @endforeach
            </section>

        @else

            <div class="empty flex min-h-[320px] flex-col items-center justify-center rounded-3xl border border-sky-200/[0.1] bg-[#0f1b2c]/70 p-12 text-center backdrop-blur-xl">
                <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-2xl border border-sky-300/15 bg-sky-300/[0.08]">
                    <i data-lucide="database-zap" class="h-7 w-7 text-sky-300"></i>
                </div>

                <h2 class="text-xl font-black tracking-tight text-white">
                    Belum ada data siswa
                </h2>

                <p class="mt-2 max-w-md text-sm leading-7 text-slate-500">
                    Data siswa belum tersedia.
                </p>
            </div>

        @endif


        {{-- PAGINATION --}}
        <div class="pagination mt-12 flex justify-center">
            {{ $students->links() }}
        </div>

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

        /* HEADER ENTRANCE */
        gsap.from('.students-head', { y: -20, opacity: 0, duration: 0.9, ease: 'power3.out' });
        gsap.from('.students-head > *', { y: 24, opacity: 0, duration: 0.8, stagger: 0.12, ease: 'power3.out', delay: 0.15 });

        /* STATS STRIP */
        gsap.from('.stats-strip', { y: 30, opacity: 0, duration: 0.9, ease: 'power3.out', delay: 0.35 });

        /* STUDENT CARDS — batch stagger */
        ScrollTrigger.batch('.student-card', {
            start: 'top 92%',
            once: true,
            onEnter: function (els) {
                gsap.from(els, {
                    y: 40, opacity: 0, scale: 0.96,
                    duration: 0.7, stagger: 0.08, ease: 'power3.out'
                });
            }
        });

        /* EMPTY STATE */
        gsap.from('.empty', { y: 30, opacity: 0, duration: 0.9, ease: 'power3.out' });

        /* PAGINATION */
        gsap.from('.pagination', { y: 20, opacity: 0, duration: 0.7, ease: 'power2.out', delay: 0.5 });

        /* AMBIENT ORB DRIFT */
        gsap.to('.orb-1', { x: 40, y: 30, duration: 14, repeat: -1, yoyo: true, ease: 'sine.inOut' });
        gsap.to('.orb-2', { x: -30, y: 40, duration: 16, repeat: -1, yoyo: true, ease: 'sine.inOut' });
        gsap.to('.orb-3', { x: 20, y: -30, duration: 18, repeat: -1, yoyo: true, ease: 'sine.inOut' });

        /* CARD 3D TILT */
        document.querySelectorAll('.student-card').forEach(function (card) {
            card.addEventListener('mousemove', function (e) {
                const rect = card.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;

                gsap.to(card, {
                    rotateY: x * 6,
                    rotateX: -y * 6,
                    duration: 0.5,
                    ease: 'power2.out',
                    transformPerspective: 900,
                    overwrite: 'auto'
                });
            });

            card.addEventListener('mouseleave', function () {
                gsap.to(card, {
                    rotateY: 0, rotateX: 0,
                    duration: 0.7, ease: 'elastic.out(1, 0.5)'
                });
            });
        });

    });
    </script>

</body>

</html>