<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Data Siswa PRAKERIN DISKOMINFO — Daftar siswa Praktik Kerja Lapangan.">

    <meta name="theme-color" content="#f5f7fa">

    <title>Data Siswa — PRAKERIN DISKOMINFO</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
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

        @media (prefers-reduced-motion: reduce) {
            .shimmer-text {
                animation: none;
            }
        }
    </style>
</head>

<body
    x-data="{ mobileOpen: false }"
    class="min-h-screen overflow-x-hidden bg-[#f5f7fa] text-[#263449] antialiased selection:bg-[#416b9e]/20"
>

    {{-- ======================================================
         BACKGROUND — DISKOMINFO BLUE ATMOSPHERE
    ======================================================= --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">

        <div
            class="orb-1 absolute -left-40 -top-40 h-[450px] w-[450px]
                   rounded-full bg-[#416b9e]/[0.09] blur-[130px]">
        </div>

        <div
            class="orb-2 absolute -right-40 top-[18%] h-[450px] w-[450px]
                   rounded-full bg-[#8db5dc]/[0.12] blur-[140px]">
        </div>

        <div
            class="orb-3 absolute bottom-[-250px] left-[35%] h-[450px] w-[450px]
                   rounded-full bg-[#365b88]/[0.07] blur-[140px]">
        </div>

        {{-- Subtle code grid --}}
        <div
            class="absolute inset-0 opacity-[0.035]
                   [background-image:linear-gradient(#365b88_1px,transparent_1px),linear-gradient(90deg,#365b88_1px,transparent_1px)]
                   [background-size:56px_56px]
                   [mask-image:linear-gradient(to_bottom,black,transparent_70%)]">
        </div>

        {{-- Top light --}}
        <div
            class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2
                   bg-gradient-to-r from-transparent via-[#416b9e]/30 to-transparent">
        </div>
    </div>


    {{-- ======================================================
         MAIN CONTENT
    ======================================================= --}}
    <main
        class="relative mx-auto max-w-7xl px-4 pb-40 pt-16
               sm:px-6 sm:pt-20 lg:px-8 lg:pt-24"
    >

        {{-- ==================================================
             HEADER
        =================================================== --}}
        <header
            class="students-head mb-12 flex flex-col justify-between gap-6
                   lg:flex-row lg:items-end"
        >

            <div class="max-w-2xl">

                {{-- Page identifier --}}
                <div
                    class="mb-4 inline-flex items-center gap-2 rounded-full
                           border border-[#dce5f0] bg-white px-3 py-1.5 shadow-sm"
                >
                    <i
                        data-lucide="users"
                        class="h-3.5 w-3.5 text-[#416b9e]">
                    </i>

                    <span
                        class="font-mono text-[9px] font-bold uppercase
                               tracking-[0.18em] text-[#416b9e]"
                    >
                        students.index
                    </span>
                </div>

                {{-- Heading --}}
                <h1
                    class="text-5xl font-black leading-[0.95]
                           tracking-[-0.05em] text-[#263449]
                           sm:text-6xl lg:text-7xl"
                >
                    Data

                    <span
                        class="shimmer-text block bg-gradient-to-r
                               from-[#243f63] via-[#416b9e] to-[#8aaed3]
                               bg-clip-text text-transparent"
                    >
                        Siswa PKL
                    </span>
                </h1>

            </div>

            <p class="max-w-md text-sm leading-7 text-[#718096]">
                Daftar siswa yang sedang melaksanakan Praktik Kerja
                Lapangan di Dinas Komunikasi dan Informatika
                Kabupaten Pacitan.
            </p>

        </header>


        {{-- ==================================================
             STATISTICS
        =================================================== --}}
        <section
            class="stats-strip mb-10 grid overflow-hidden rounded-2xl
                   border border-[#e0e7f0] bg-white
                   shadow-[0_4px_20px_rgba(35,57,84,0.04)]
                   sm:grid-cols-2"
            aria-label="Statistik data siswa"
        >

            {{-- Total students --}}
            <div
                class="flex items-center gap-4 border-b border-[#edf1f6]
                       p-5 sm:border-b-0 sm:border-r sm:border-[#edf1f6]"
            >

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center
                           rounded-xl border border-[#dce5f0] bg-[#f0f5fb]"
                >
                    <i
                        data-lucide="database"
                        class="h-5 w-5 text-[#365b88]">
                    </i>
                </div>

                <div>
                    <div class="text-2xl font-black tracking-tight text-[#263449]">
                        {{ $students->total() }}
                    </div>

                    <div
                        class="mt-0.5 font-mono text-[9px] uppercase
                               tracking-wider text-[#8390a1]"
                    >
                        Total Records
                    </div>
                </div>

            </div>


            {{-- Current pagination --}}
            <div class="flex items-center gap-4 p-5">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center
                           rounded-xl border border-[#d9ece7] bg-[#edf7f5]"
                >
                    <i
                        data-lucide="layers"
                        class="h-5 w-5 text-[#438b7c]">
                    </i>
                </div>

                <div>
                    <div class="text-2xl font-black tracking-tight text-[#263449]">
                        {{ $students->currentPage() }}

                        <span class="text-[#c4ceda]">/</span>

                        {{ $students->lastPage() }}
                    </div>

                    <div
                        class="mt-0.5 font-mono text-[9px] uppercase
                               tracking-wider text-[#8390a1]"
                    >
                        Halaman
                    </div>
                </div>

            </div>

        </section>


        {{-- ==================================================
             STUDENT GRID
        =================================================== --}}
        @if ($students->count())

            <section
                class="students grid gap-5 sm:grid-cols-2 lg:grid-cols-3"
                aria-label="Daftar siswa PRAKERIN"
            >

                @foreach ($students as $student)

                    <article
                        class="student-card group relative overflow-hidden
                               rounded-2xl border border-[#e0e7f0] bg-white p-6
                               shadow-[0_4px_20px_rgba(35,57,84,0.035)]
                               transition-all duration-300
                               hover:-translate-y-1 hover:border-[#c7d7e9]
                               hover:shadow-[0_12px_32px_rgba(35,57,84,0.09)]"
                    >

                        {{-- Card ambient decoration --}}
                        <div
                            class="pointer-events-none absolute -right-20 -top-20
                                   h-40 w-40 rounded-full bg-[#416b9e]/[0.05]
                                   blur-3xl transition duration-500
                                   group-hover:bg-[#416b9e]/[0.10]"
                        ></div>


                        {{-- Avatar + status --}}
                        <div
                            class="relative mb-5 flex items-start justify-between gap-3"
                        >

                            <div
                                class="avatar flex h-14 w-14 shrink-0 items-center
                                       justify-center rounded-2xl
                                       bg-gradient-to-br from-[#243f63]
                                       via-[#365b88] to-[#7197c1]
                                       text-lg font-black text-white
                                       shadow-lg shadow-[#365b88]/15
                                       transition duration-300
                                       group-hover:scale-105"
                                aria-hidden="true"
                            >
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>


                            {{-- Student status --}}
                            <span
                                class="shrink-0 rounded-full border px-2.5 py-1
                                       font-mono text-[8px] font-bold uppercase
                                       tracking-wider
                                       {{ strtolower($student->status) === 'active'
                                            ? 'border-[#cde9df] bg-[#edf8f3] text-[#347c68]'
                                            : 'border-[#dce5f0] bg-[#f1f5fa] text-[#58708e]' }}"
                            >
                                {{ ucfirst($student->status) }}
                            </span>

                        </div>


                        {{-- Student identity --}}
                        <h2
                            class="relative truncate text-lg font-black
                                   tracking-tight text-[#263449]"
                            title="{{ $student->name }}"
                        >
                            {{ $student->name }}
                        </h2>

                        <p
                            class="relative mt-1 truncate font-mono text-[10px]
                                   uppercase tracking-wider text-[#416b9e]"
                            title="{{ $student->major }}"
                        >
                            {{ $student->major }}
                        </p>


                        {{-- Student information --}}
                        <div class="relative mt-5 space-y-0">

                            {{-- Class --}}
                            <div
                                class="flex items-center justify-between gap-3
                                       border-b border-[#edf1f6] py-3"
                            >
                                <span
                                    class="flex items-center gap-1.5
                                           font-mono text-[9px] uppercase
                                           tracking-wider text-[#8390a1]"
                                >
                                    <i
                                        data-lucide="graduation-cap"
                                        class="h-3.5 w-3.5 text-[#7193bb]">
                                    </i>

                                    Kelas
                                </span>

                                <strong
                                    class="text-right text-xs font-bold text-[#43546a]"
                                >
                                    {{ $student->class }}
                                </strong>
                            </div>


                            {{-- Start date --}}
                            <div
                                class="flex items-center justify-between gap-3
                                       border-b border-[#edf1f6] py-3"
                            >
                                <span
                                    class="flex items-center gap-1.5
                                           font-mono text-[9px] uppercase
                                           tracking-wider text-[#8390a1]"
                                >
                                    <i
                                        data-lucide="calendar-days"
                                        class="h-3.5 w-3.5 text-[#7193bb]">
                                    </i>

                                    Mulai
                                </span>

                                <strong
                                    class="text-right text-xs font-bold text-[#43546a]"
                                >
                                    {{ $student->start_date?->format('d M Y') }}
                                </strong>
                            </div>

                        </div>


                        {{-- Detail action --}}
                        <a
                            href="{{ route('students.show', $student) }}"
                            class="relative mt-5 inline-flex w-full items-center
                                   justify-center gap-2 rounded-xl
                                   border border-[#dce5f0]
                                   bg-gradient-to-r from-[#f3f7fc] to-[#eaf1fa]
                                   px-4 py-3 text-[11px] font-bold text-[#365b88]
                                   transition duration-300
                                   hover:border-[#b8cbe1]
                                   hover:from-[#eaf1fa] hover:to-[#dfeaf7]
                                   hover:text-[#243f63]
                                   focus-visible:outline-none
                                   focus-visible:ring-2
                                   focus-visible:ring-[#416b9e]
                                   focus-visible:ring-offset-2"
                        >
                            Lihat Detail

                            <i
                                data-lucide="arrow-up-right"
                                class="h-3.5 w-3.5 transition
                                       group-hover:translate-x-0.5
                                       group-hover:-translate-y-0.5"
                            ></i>
                        </a>

                    </article>

                @endforeach

            </section>

        @else

            {{-- ==================================================
                 EMPTY STATE
            =================================================== --}}
            <section
                class="empty flex min-h-[320px] flex-col items-center
                       justify-center rounded-3xl border border-[#e0e7f0]
                       bg-white p-8 text-center
                       shadow-[0_4px_20px_rgba(35,57,84,0.035)]
                       sm:p-12"
            >

                <div
                    class="mb-5 flex h-16 w-16 items-center justify-center
                           rounded-2xl border border-[#dce5f0] bg-[#f0f5fb]"
                >
                    <i
                        data-lucide="database-zap"
                        class="h-7 w-7 text-[#416b9e]">
                    </i>
                </div>

                <h2 class="text-xl font-black tracking-tight text-[#263449]">
                    Belum ada data siswa
                </h2>

                <p class="mt-2 max-w-md text-sm leading-7 text-[#8390a1]">
                    Data siswa belum tersedia.
                </p>

            </section>

        @endif


        {{-- ==================================================
             PAGINATION
        =================================================== --}}
        <div class="pagination mt-12 flex justify-center">
            {{ $students->links() }}
        </div>

    </main>


    {{-- ======================================================
         FLOATING NAVIGATION
    ======================================================= --}}
    @include('partials.navbar')


    {{-- ======================================================
         PAGE TRANSITION
    ======================================================= --}}
    @include('partials.page-transition')


    {{-- ======================================================
         CDN LIBRARIES
    ======================================================= --}}
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollToPlugin.min.js"></script>


    {{-- ======================================================
         ICONS + ANIMATIONS
    ======================================================= --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ================================================
           LUCIDE ICONS
        ================================================ */
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


        /* ================================================
           GSAP AVAILABILITY
        ================================================ */
        if (!window.gsap) {
            console.warn('[gsap] not loaded — animations skipped');
            return;
        }

        if (window.ScrollTrigger) {
            gsap.registerPlugin(ScrollTrigger);
        }

        if (window.ScrollToPlugin) {
            gsap.registerPlugin(ScrollToPlugin);
        }


        /* ================================================
           HEADER ENTRANCE
        ================================================ */
        gsap.from('.students-head', {
            y: -20,
            opacity: 0,
            duration: 0.9,
            ease: 'power3.out'
        });

        gsap.from('.students-head > *', {
            y: 24,
            opacity: 0,
            duration: 0.8,
            stagger: 0.12,
            ease: 'power3.out',
            delay: 0.15
        });


        /* ================================================
           STATISTICS ENTRANCE
        ================================================ */
        gsap.from('.stats-strip', {
            y: 30,
            opacity: 0,
            duration: 0.9,
            ease: 'power3.out',
            delay: 0.35
        });


        /* ================================================
           STUDENT CARDS — STAGGER REVEAL
        ================================================ */
        if (window.ScrollTrigger) {

            ScrollTrigger.batch('.student-card', {
                start: 'top 92%',
                once: true,

                onEnter: function (els) {
                    gsap.from(els, {
                        y: 40,
                        opacity: 0,
                        scale: 0.96,
                        duration: 0.7,
                        stagger: 0.08,
                        ease: 'power3.out',
                        clearProps: 'transform'
                    });
                }
            });

        } else {

            gsap.from('.student-card', {
                y: 25,
                opacity: 0,
                duration: 0.7,
                stagger: 0.08,
                ease: 'power3.out',
                clearProps: 'transform'
            });

        }


        /* ================================================
           EMPTY STATE
        ================================================ */
        if (document.querySelector('.empty')) {
            gsap.from('.empty', {
                y: 30,
                opacity: 0,
                duration: 0.9,
                ease: 'power3.out'
            });
        }


        /* ================================================
           PAGINATION
        ================================================ */
        if (document.querySelector('.pagination')) {
            gsap.from('.pagination', {
                y: 20,
                opacity: 0,
                duration: 0.7,
                ease: 'power2.out',
                delay: 0.5
            });
        }


        /* ================================================
           AMBIENT ORB DRIFT
        ================================================ */
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


        /* ================================================
           CARD 3D TILT
        ================================================ */
        if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {

            document.querySelectorAll('.student-card').forEach(function (card) {

                card.addEventListener('mousemove', function (e) {

                    const rect = card.getBoundingClientRect();

                    const x = (e.clientX - rect.left) / rect.width - 0.5;
                    const y = (e.clientY - rect.top) / rect.height - 0.5;

                    gsap.to(card, {
                        rotateY: x * 4,
                        rotateX: -y * 4,
                        duration: 0.5,
                        ease: 'power2.out',
                        transformPerspective: 900,
                        overwrite: 'auto'
                    });

                });


                card.addEventListener('mouseleave', function () {

                    gsap.to(card, {
                        rotateY: 0,
                        rotateX: 0,
                        duration: 0.7,
                        ease: 'elastic.out(1, 0.5)',
                        overwrite: 'auto'
                    });

                });

            });

        }

    });
    </script>

</body>

</html>