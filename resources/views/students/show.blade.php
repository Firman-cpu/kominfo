<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detail siswa Praktik Kerja Lapangan — PRAKERIN DISKOMINFO.">
    <meta name="theme-color" content="#f5f7fa">

    <title>{{ $student->name }} — PRAKERIN DISKOMINFO</title>

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

<body class="min-h-screen overflow-x-hidden bg-[#f5f7fa] text-[#263449] antialiased selection:bg-[#416b9e]/20">

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

        {{-- Top accent --}}
        <div
            class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2
                   bg-gradient-to-r from-transparent via-[#416b9e]/30 to-transparent">
        </div>

    </div>


    {{-- ======================================================
         MAIN CONTENT
    ======================================================= --}}
    <main class="relative mx-auto max-w-5xl px-4 pb-32 pt-10 sm:px-6 sm:pt-16 lg:px-8 lg:pb-36">

        {{-- ==================================================
             BACK BUTTON
        =================================================== --}}
        <a
            class="back-link group inline-flex items-center gap-2.5 rounded-full
                   border border-[#dce5f0] bg-white px-4 py-2.5
                   shadow-[0_3px_12px_rgba(35,57,84,0.04)]
                   transition duration-300
                   hover:-translate-y-0.5 hover:border-[#b8cbe1]
                   hover:bg-[#f8fafd] hover:shadow-md
                   focus-visible:outline-none focus-visible:ring-2
                   focus-visible:ring-[#416b9e] focus-visible:ring-offset-2"
            href="{{ route('students.index') }}"
        >
            <i
                data-lucide="arrow-left"
                class="h-3.5 w-3.5 text-[#416b9e]
                       transition group-hover:-translate-x-0.5">
            </i>

            <span
                class="font-mono text-[9px] font-bold uppercase
                       tracking-[0.18em] text-[#365b88]"
            >
                Kembali ke Data Siswa
            </span>
        </a>


        {{-- ==================================================
             PROFILE CARD
        =================================================== --}}
        <section
            class="profile-card relative mt-6 overflow-hidden rounded-3xl
                   border border-[#e0e7f0] bg-white p-6
                   shadow-[0_8px_35px_rgba(35,57,84,0.055)]
                   sm:p-10"
            aria-label="Profil detail siswa"
        >

            {{-- Card top accent --}}
            <div
                class="pointer-events-none absolute inset-x-0 top-0 h-px
                       bg-gradient-to-r from-transparent
                       via-[#416b9e]/45 to-transparent">
            </div>

            {{-- Ambient decoration --}}
            <div
                class="pointer-events-none absolute -right-24 -top-24
                       h-64 w-64 rounded-full bg-[#416b9e]/[0.06]
                       blur-[100px]">
            </div>

            <div
                class="pointer-events-none absolute -bottom-32 -left-20
                       h-64 w-64 rounded-full bg-[#8db5dc]/[0.10]
                       blur-[110px]">
            </div>


            <div class="relative">

                {{-- ==========================================
                     PAGE BADGE
                =========================================== --}}
                <div
                    class="hero-badge mb-7 inline-flex items-center gap-2
                           rounded-full border border-[#dce5f0]
                           bg-[#f3f7fc] px-3 py-1.5"
                >
                    <i
                        data-lucide="id-card"
                        class="h-3.5 w-3.5 text-[#416b9e]">
                    </i>

                    <span
                        class="font-mono text-[9px] font-bold uppercase
                               tracking-[0.18em] text-[#416b9e]"
                    >
                        student.detail
                    </span>
                </div>


                {{-- ==========================================
                     STUDENT IDENTITY
                =========================================== --}}
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center">

                    {{-- Avatar --}}
                    <div
                        class="avatar flex h-20 w-20 shrink-0 items-center
                               justify-center rounded-2xl
                               bg-gradient-to-br from-[#243f63]
                               via-[#365b88] to-[#7197c1]
                               text-3xl font-black text-white
                               shadow-xl shadow-[#365b88]/15"
                        aria-hidden="true"
                    >
                        {{ strtoupper(substr($student->name, 0, 1)) }}
                    </div>


                    {{-- Name and major --}}
                    <div class="min-w-0 flex-1">

                        <h1
                            class="hero-title break-words text-4xl
                                   font-black leading-[0.98]
                                   tracking-[-0.045em] text-[#263449]
                                   sm:text-5xl"
                        >
                            {{ $student->name }}
                        </h1>

                        <p
                            class="hero-sub mt-3 flex items-center gap-2
                                   font-mono text-[10px] uppercase
                                   tracking-[0.18em] text-[#718096]"
                        >
                            <i
                                data-lucide="graduation-cap"
                                class="h-3.5 w-3.5 shrink-0 text-[#7193bb]">
                            </i>

                            <span>{{ $student->major }}</span>
                        </p>

                    </div>

                </div>


                {{-- ==========================================
                     DIVIDER
                =========================================== --}}
                <div
                    class="hero-footer mt-8 h-px w-full origin-left
                           bg-gradient-to-r from-[#416b9e]/35
                           via-[#dce5f0] to-transparent">
                </div>


                {{-- ==========================================
                     STUDENT DATA GRID
                =========================================== --}}
                <div class="mt-8 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">

                    {{-- NIS --}}
                    <div
                        class="stat-item rounded-2xl border border-[#e0e7f0]
                               bg-[#fbfcfe] p-4 transition duration-300
                               hover:-translate-y-0.5 hover:border-[#c7d7e9]
                               hover:shadow-[0_8px_20px_rgba(35,57,84,0.05)]"
                    >
                        <div class="flex items-center justify-between gap-3">

                            <span
                                class="font-mono text-[9px] uppercase
                                       tracking-[0.18em] text-[#8390a1]"
                            >
                                NIS
                            </span>

                            <span
                                class="flex h-8 w-8 items-center justify-center
                                       rounded-lg border border-[#dce5f0]
                                       bg-[#f0f5fb]"
                            >
                                <i
                                    data-lucide="hash"
                                    class="h-3.5 w-3.5 text-[#416b9e]">
                                </i>
                            </span>

                        </div>

                        <div class="mt-3 break-words text-base font-bold text-[#263449]">
                            {{ $student->nis }}
                        </div>

                        <p class="mt-1 text-[10px] text-[#9aa6b5]">
                            Nomor induk siswa
                        </p>
                    </div>


                    {{-- CLASS --}}
                    <div
                        class="stat-item rounded-2xl border border-[#e0e7f0]
                               bg-[#fbfcfe] p-4 transition duration-300
                               hover:-translate-y-0.5 hover:border-[#c7d7e9]
                               hover:shadow-[0_8px_20px_rgba(35,57,84,0.05)]"
                    >
                        <div class="flex items-center justify-between gap-3">

                            <span
                                class="font-mono text-[9px] uppercase
                                       tracking-[0.18em] text-[#8390a1]"
                            >
                                Kelas
                            </span>

                            <span
                                class="flex h-8 w-8 items-center justify-center
                                       rounded-lg border border-[#dce5f0]
                                       bg-[#f0f5fb]"
                            >
                                <i
                                    data-lucide="users-round"
                                    class="h-3.5 w-3.5 text-[#416b9e]">
                                </i>
                            </span>

                        </div>

                        <div class="mt-3 break-words text-base font-bold text-[#263449]">
                            {{ $student->class }}
                        </div>

                        <p class="mt-1 text-[10px] text-[#9aa6b5]">
                            Kelas siswa
                        </p>
                    </div>


                    {{-- START DATE --}}
                    <div
                        class="stat-item rounded-2xl border border-[#e0e7f0]
                               bg-[#fbfcfe] p-4 transition duration-300
                               hover:-translate-y-0.5 hover:border-[#c7d7e9]
                               hover:shadow-[0_8px_20px_rgba(35,57,84,0.05)]"
                    >
                        <div class="flex items-center justify-between gap-3">

                            <span
                                class="font-mono text-[9px] uppercase
                                       tracking-[0.18em] text-[#8390a1]"
                            >
                                Mulai PKL
                            </span>

                            <span
                                class="flex h-8 w-8 items-center justify-center
                                       rounded-lg border border-[#dce5f0]
                                       bg-[#f0f5fb]"
                            >
                                <i
                                    data-lucide="calendar-plus"
                                    class="h-3.5 w-3.5 text-[#416b9e]">
                                </i>
                            </span>

                        </div>

                        <div class="mt-3 text-base font-bold text-[#263449]">
                            {{ $student->start_date?->format('d M Y') ?? '—' }}
                        </div>

                        <p class="mt-1 text-[10px] text-[#9aa6b5]">
                            Tanggal mulai
                        </p>
                    </div>


                    {{-- END DATE --}}
                    <div
                        class="stat-item rounded-2xl border border-[#e0e7f0]
                               bg-[#fbfcfe] p-4 transition duration-300
                               hover:-translate-y-0.5 hover:border-[#c7d7e9]
                               hover:shadow-[0_8px_20px_rgba(35,57,84,0.05)]"
                    >
                        <div class="flex items-center justify-between gap-3">

                            <span
                                class="font-mono text-[9px] uppercase
                                       tracking-[0.18em] text-[#8390a1]"
                            >
                                Selesai PKL
                            </span>

                            <span
                                class="flex h-8 w-8 items-center justify-center
                                       rounded-lg border border-[#dce5f0]
                                       bg-[#f0f5fb]"
                            >
                                <i
                                    data-lucide="calendar-check"
                                    class="h-3.5 w-3.5 text-[#416b9e]">
                                </i>
                            </span>

                        </div>

                        <div class="mt-3 text-base font-bold text-[#263449]">
                            {{ $student->end_date?->format('d M Y') ?? '—' }}
                        </div>

                        <p class="mt-1 text-[10px] text-[#9aa6b5]">
                            Target selesai
                        </p>
                    </div>

                </div>


                {{-- ==========================================
                     STATUS
                =========================================== --}}
                <div class="mt-8 flex flex-wrap items-center gap-3">

                    <span
                        class="status inline-flex items-center gap-2
                               rounded-full border px-4 py-2
                               {{ strtolower($student->status) === 'active'
                                    ? 'border-[#cde9df] bg-[#edf8f3] text-[#347c68]'
                                    : 'border-[#dce5f0] bg-[#f1f5fa] text-[#58708e]' }}"
                    >
                        <span
                            class="h-1.5 w-1.5 rounded-full
                                   {{ strtolower($student->status) === 'active'
                                        ? 'bg-[#438b7c]'
                                        : 'bg-[#8194ad]' }}"
                        ></span>

                        <span
                            class="font-mono text-[9px] font-bold uppercase
                                   tracking-[0.18em]"
                        >
                            {{ ucfirst($student->status) }}
                        </span>
                    </span>

                    <span
                        class="font-mono text-[9px] uppercase
                               tracking-wider text-[#9aa6b5]"
                    >
                        Status praktik kerja lapangan
                    </span>

                </div>


                {{-- ==========================================
                     FOOTER NOTE
                =========================================== --}}
                <div
                    class="mt-8 flex flex-wrap items-center gap-x-3 gap-y-2
                           border-t border-[#edf1f6] pt-5
                           font-mono text-[9px] text-[#9aa6b5]"
                >
                    <span class="text-[#438b7c]">●</span>

                    <span>record.loaded</span>

                    <span class="text-[#d4dce6]">/</span>

                    <span class="text-[#416b9e]">
                        database.connected
                    </span>
                </div>

            </div>

        </section>

    </main>


    {{-- ======================================================
         FLOATING NAVIGATION
         Aktifkan jika navbar memang digunakan pada halaman detail.
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


        /* ================================================
           ENTRANCE ANIMATION
        ================================================ */
        try {

            const tl = gsap.timeline({
                defaults: {
                    ease: 'power3.out'
                }
            });

            tl.from('.back-link', {
                y: 14,
                opacity: 0,
                duration: 0.5,
                delay: 0.15
            })

            .from('.profile-card', {
                y: 30,
                opacity: 0,
                duration: 0.8
            }, '-=0.2')

            .from('.hero-badge', {
                y: 14,
                opacity: 0,
                duration: 0.45
            }, '-=0.45')

            .from('.avatar', {
                scale: 0.85,
                opacity: 0,
                duration: 0.55
            }, '-=0.3')

            .from('.hero-title', {
                y: 20,
                opacity: 0,
                duration: 0.6
            }, '-=0.4')

            .from('.hero-sub', {
                y: 12,
                opacity: 0,
                duration: 0.45
            }, '-=0.4')

            .from('.hero-footer', {
                scaleX: 0,
                opacity: 0,
                transformOrigin: 'left center',
                duration: 0.6
            }, '-=0.25')

            .from('.stat-item', {
                y: 18,
                opacity: 0,
                duration: 0.5,
                stagger: 0.08
            }, '-=0.3')

            .from('.status', {
                y: 10,
                opacity: 0,
                duration: 0.4
            }, '-=0.2');


            /* ============================================
               AMBIENT ORB DRIFT
            ============================================ */
            gsap.to('.orb-1', {
                x: 35,
                y: 25,
                duration: 14,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });

            gsap.to('.orb-2', {
                x: -25,
                y: 35,
                duration: 16,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });

            gsap.to('.orb-3', {
                x: 20,
                y: -25,
                duration: 18,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });

        } catch (err) {

            console.warn(
                '[gsap] animation error — showing content',
                err
            );

            /* Fallback jika animasi gagal */
            gsap.set(
                '.back-link, .profile-card, .hero-badge, .avatar, .hero-title, .hero-sub, .hero-footer, .stat-item, .status',
                {
                    clearProps: 'all'
                }
            );

        }


        /* ================================================
           SAFETY NET
           Jangan biarkan konten tersembunyi jika animasi
           terhenti atau gagal berjalan.
        ================================================ */
        window.setTimeout(function () {

            document.querySelectorAll(
                '.back-link, .profile-card, .hero-badge, .avatar, .hero-title, .hero-sub, .hero-footer, .stat-item, .status'
            ).forEach(function (el) {

                el.style.opacity = '';
                el.style.transform = '';
                el.style.visibility = '';

            });

        }, 3000);

    });
    </script>

</body>

</html>