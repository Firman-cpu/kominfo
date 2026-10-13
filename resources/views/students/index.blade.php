@php
    use Illuminate\Support\Str;

    // Nilai status yang dianggap "aktif" (sesuaikan dengan isi kolom status di DB)
    $activeStatuses = ['active', 'aktif'];
@endphp
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

        /* Pan bolak-balik 0% → 100% supaya gradient tidak pernah keluar dari area teks */
        @keyframes shimmer {
            from { background-position: 0% center; }
            to   { background-position: 100% center; }
        }

        .shimmer-text {
            background-size: 200% auto;
            animation: shimmer 5s ease-in-out infinite alternate;
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
         (radial-gradient, tanpa filter blur → ringan di GPU)
    ======================================================= --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden" aria-hidden="true">

        <div
            class="orb-1 absolute -left-40 -top-40 h-[560px] w-[560px] rounded-full will-change-transform
                   bg-[radial-gradient(closest-side,rgba(65,107,158,0.14),transparent)]">
        </div>

        <div
            class="orb-2 absolute -right-40 top-[18%] h-[560px] w-[560px] rounded-full will-change-transform
                   bg-[radial-gradient(closest-side,rgba(141,181,220,0.18),transparent)]">
        </div>

        <div
            class="orb-3 absolute bottom-[-280px] left-[35%] h-[560px] w-[560px] rounded-full will-change-transform
                   bg-[radial-gradient(closest-side,rgba(54,91,136,0.10),transparent)]">
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
    <main class="relative mx-auto max-w-7xl px-4 pb-40 pt-16 sm:px-6 sm:pt-20 lg:px-8 lg:pt-24">

        {{-- ==================================================
             HEADER
        =================================================== --}}
        <header class="students-head mb-12 flex flex-col justify-between gap-6 lg:flex-row lg:items-end">

            <div class="max-w-2xl">

                <div
                    class="mb-4 inline-flex items-center gap-2 rounded-full
                           border border-[#dce5f0] bg-white px-3 py-1.5 shadow-sm"
                >
                    <i data-lucide="users" class="h-3.5 w-3.5 text-[#416b9e]"></i>

                    <span class="font-mono text-[10px] font-bold uppercase tracking-[0.18em] text-[#416b9e]">
                        students.index
                    </span>
                </div>

                <h1 class="text-5xl font-black leading-[0.95] tracking-[-0.05em] text-[#263449] sm:text-6xl lg:text-7xl">
                    Data

                    <span
                        class="shimmer-text block bg-gradient-to-r pb-1
                               from-[#243f63] via-[#416b9e] to-[#8aaed3]
                               bg-clip-text text-transparent"
                    >
                        Siswa PKL
                    </span>
                </h1>

            </div>

            <p class="max-w-md text-sm leading-7 text-[#64748b]">
                Daftar siswa yang sedang melaksanakan Praktik Kerja Lapangan
                di Dinas Komunikasi dan Informatika Kabupaten Pacitan.
            </p>

        </header>


        {{-- ==================================================
             STATISTICS
        =================================================== --}}
        <section
            class="stats-strip mb-10 grid overflow-hidden rounded-2xl border border-[#e0e7f0]
                   bg-white shadow-[0_4px_20px_rgba(35,57,84,0.04)] sm:grid-cols-2"
            aria-label="Statistik data siswa"
        >

            <div class="flex items-center gap-4 border-b border-[#edf1f6] p-5 sm:border-b-0 sm:border-r">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#dce5f0] bg-[#f0f5fb]">
                    <i data-lucide="database" class="h-5 w-5 text-[#365b88]"></i>
                </div>

                <div>
                    <div class="text-2xl font-black tracking-tight text-[#263449]">
                        {{ $students->total() }}
                    </div>
                    <div class="mt-0.5 font-mono text-[10px] uppercase tracking-wider text-[#6b7a8f]">
                        Total Records
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4 p-5">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#d9ece7] bg-[#edf7f5]">
                    <i data-lucide="layers" class="h-5 w-5 text-[#438b7c]"></i>
                </div>

                <div>
                    <div class="text-2xl font-black tracking-tight text-[#263449]">
                        {{ $students->currentPage() }}
                        <span class="text-[#c4ceda]">/</span>
                        {{ $students->lastPage() }}
                    </div>
                    <div class="mt-0.5 font-mono text-[10px] uppercase tracking-wider text-[#6b7a8f]">
                        Halaman
                    </div>
                </div>
            </div>

        </section>


        {{-- ==================================================
             STUDENT GRID
        =================================================== --}}
        @if ($students->count())

            <section class="students grid gap-5 sm:grid-cols-2 lg:grid-cols-3" aria-label="Daftar siswa PRAKERIN">

                @foreach ($students as $student)

                    @php
                        $isActive = in_array(Str::lower((string) $student->status), $activeStatuses, true);
                    @endphp

                    <article
                        class="student-card group relative overflow-hidden rounded-2xl
                               border border-[#e0e7f0] bg-white p-6
                               shadow-[0_4px_20px_rgba(35,57,84,0.035)]
                               transition-[border-color,box-shadow] duration-300
                               hover:border-[#c7d7e9] hover:shadow-[0_12px_32px_rgba(35,57,84,0.09)]"
                    >

                        {{-- Ambient decoration (radial-gradient, bukan blur) --}}
                        <div
                            class="pointer-events-none absolute -right-16 -top-16 h-44 w-44 rounded-full
                                   bg-[radial-gradient(closest-side,rgba(65,107,158,0.12),transparent)]
                                   opacity-60 transition-opacity duration-500 group-hover:opacity-100"
                            aria-hidden="true"
                        ></div>

                        {{-- Avatar + status --}}
                        <div class="relative mb-5 flex items-start justify-between gap-3">

                            <div
                                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl
                                       bg-gradient-to-br from-[#243f63] via-[#365b88] to-[#7197c1]
                                       text-lg font-black text-white shadow-lg shadow-[#365b88]/15
                                       transition-transform duration-300 group-hover:scale-105"
                                aria-hidden="true"
                            >
                                {{ Str::upper(Str::substr($student->name, 0, 1)) }}
                            </div>

                            <span
                                class="shrink-0 rounded-full border px-2.5 py-1 font-mono text-[10px]
                                       font-bold uppercase tracking-wider
                                       {{ $isActive
                                            ? 'border-[#cde9df] bg-[#edf8f3] text-[#347c68]'
                                            : 'border-[#dce5f0] bg-[#f1f5fa] text-[#58708e]' }}"
                            >
                                {{ Str::ucfirst((string) $student->status) }}
                            </span>

                        </div>

                        {{-- Identity --}}
                        <h2
                            class="relative truncate text-lg font-black tracking-tight text-[#263449]"
                            title="{{ $student->name }}"
                        >
                            {{ $student->name }}
                        </h2>

                        <p
                            class="relative mt-1 truncate font-mono text-[11px] uppercase tracking-wider text-[#416b9e]"
                            title="{{ $student->major }}"
                        >
                            {{ $student->major }}
                        </p>

                        {{-- Info --}}
                        <dl class="relative mt-5">

                            <div class="flex items-center justify-between gap-3 border-b border-[#edf1f6] py-3">
                                <dt class="flex items-center gap-1.5 font-mono text-[10px] uppercase tracking-wider text-[#6b7a8f]">
                                    <i data-lucide="graduation-cap" class="h-3.5 w-3.5 text-[#7193bb]"></i>
                                    Kelas
                                </dt>
                                <dd class="text-right text-xs font-bold text-[#43546a]">
                                    {{ $student->class ?? '—' }}
                                </dd>
                            </div>

                            <div class="flex items-center justify-between gap-3 border-b border-[#edf1f6] py-3">
                                <dt class="flex items-center gap-1.5 font-mono text-[10px] uppercase tracking-wider text-[#6b7a8f]">
                                    <i data-lucide="calendar-days" class="h-3.5 w-3.5 text-[#7193bb]"></i>
                                    Mulai
                                </dt>
                                <dd class="text-right text-xs font-bold text-[#43546a]">
                                    {{ $student->start_date?->format('d M Y') ?? '—' }}
                                </dd>
                            </div>

                        </dl>

                        {{-- Detail action --}}
                        <a
                            href="{{ route('students.show', $student) }}"
                            class="relative mt-5 inline-flex w-full items-center justify-center gap-2
                                   rounded-xl border border-[#dce5f0]
                                   bg-gradient-to-r from-[#f3f7fc] to-[#eaf1fa]
                                   px-4 py-3 text-[11px] font-bold text-[#365b88]
                                   transition duration-300
                                   hover:border-[#b8cbe1] hover:from-[#eaf1fa] hover:to-[#dfeaf7] hover:text-[#243f63]
                                   focus-visible:outline-none focus-visible:ring-2
                                   focus-visible:ring-[#416b9e] focus-visible:ring-offset-2"
                            aria-label="Lihat detail {{ $student->name }}"
                        >
                            Lihat Detail
                            <i
                                data-lucide="arrow-up-right"
                                class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
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
                class="empty flex min-h-[320px] flex-col items-center justify-center rounded-3xl
                       border border-[#e0e7f0] bg-white p-8 text-center
                       shadow-[0_4px_20px_rgba(35,57,84,0.035)] sm:p-12"
            >
                <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-2xl border border-[#dce5f0] bg-[#f0f5fb]">
                    <i data-lucide="database-zap" class="h-7 w-7 text-[#416b9e]"></i>
                </div>

                <h2 class="text-xl font-black tracking-tight text-[#263449]">
                    Belum ada data siswa
                </h2>

                <p class="mt-2 max-w-md text-sm leading-7 text-[#64748b]">
                    Data siswa belum tersedia.
                </p>
            </section>

        @endif


        {{-- ==================================================
             PAGINATION
        =================================================== --}}
        @if ($students->hasPages())
            <nav class="pagination mt-12 flex justify-center" aria-label="Navigasi halaman">
                {{ $students->links() }}
            </nav>
        @endif

    </main>


    {{-- Floating navigation --}}
    @include('partials.navbar')

    {{-- Page transition --}}
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

        /* ---------- Lucide ---------- */
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
        }

        /* ---------- GSAP guard ---------- */
        if (!window.gsap) {
            console.warn('[gsap] not loaded — animations skipped');
            return;
        }

        // ScrollToPlugin tetap diregistrasi karena dipakai partial navbar
        gsap.registerPlugin.apply(
            gsap,
            [window.ScrollTrigger, window.ScrollToPlugin].filter(Boolean)
        );

        const mm = gsap.matchMedia();

        /* =================================================
           ENTRANCE + AMBIENT (hanya jika motion diizinkan)
           Konten tetap terlihat penuh kalau reduced-motion.
        ================================================= */
        mm.add('(prefers-reduced-motion: no-preference)', function () {

            // Header + stats dalam satu timeline
            gsap.timeline({ defaults: { ease: 'power3.out' } })
                .from('.students-head > *', {
                    y: 24, opacity: 0, duration: 0.8, stagger: 0.12
                })
                .from('.stats-strip', {
                    y: 30, opacity: 0, duration: 0.8
                }, '-=0.45');

            // Student cards — sembunyikan dulu, lalu reveal saat masuk viewport
            const cards = gsap.utils.toArray('.student-card');

            if (cards.length) {
                gsap.set(cards, { opacity: 0, y: 40, scale: 0.96 });

                const reveal = function (els) {
                    gsap.to(els, {
                        opacity: 1,
                        y: 0,
                        scale: 1,
                        duration: 0.7,
                        stagger: 0.08,
                        ease: 'power3.out',
                        clearProps: 'opacity,transform'
                    });
                };

                if (window.ScrollTrigger) {
                    ScrollTrigger.batch(cards, {
                        start: 'top 92%',
                        once: true,
                        onEnter: reveal
                    });
                } else {
                    reveal(cards);
                }
            }

            // Empty state
            if (document.querySelector('.empty')) {
                gsap.from('.empty', { y: 30, opacity: 0, duration: 0.9, ease: 'power3.out' });
            }

            // Pagination
            if (document.querySelector('.pagination')) {
                gsap.from('.pagination', {
                    y: 20, opacity: 0, duration: 0.7, ease: 'power2.out', delay: 0.5
                });
            }

            // Ambient orb drift
            [
                ['.orb-1', 40, 30, 14],
                ['.orb-2', -30, 40, 16],
                ['.orb-3', 20, -30, 18]
            ].forEach(function (o) {
                gsap.to(o[0], {
                    x: o[1], y: o[2], duration: o[3],
                    repeat: -1, yoyo: true, ease: 'sine.inOut', force3D: true
                });
            });
        });

        /* =================================================
           CARD 3D TILT (hanya mouse + motion diizinkan)
        ================================================= */
        mm.add(
            '(hover: hover) and (pointer: fine) and (prefers-reduced-motion: no-preference)',
            function () {

                const controller = new AbortController();
                const opts = { signal: controller.signal };

                document.querySelectorAll('.student-card').forEach(function (card) {

                    gsap.set(card, { transformPerspective: 900 });

                    card.addEventListener('mousemove', function (e) {
                        const rect = card.getBoundingClientRect();
                        const x = (e.clientX - rect.left) / rect.width - 0.5;
                        const y = (e.clientY - rect.top) / rect.height - 0.5;

                        gsap.to(card, {
                            rotateY: x * 4,
                            rotateX: -y * 4,
                            y: -4,
                            duration: 0.5,
                            ease: 'power2.out',
                            overwrite: 'auto'
                        });
                    }, opts);

                    card.addEventListener('mouseleave', function () {
                        gsap.to(card, {
                            rotateY: 0,
                            rotateX: 0,
                            y: 0,
                            duration: 0.7,
                            ease: 'elastic.out(1, 0.5)',
                            overwrite: 'auto'
                        });
                    }, opts);
                });

                // Cleanup otomatis saat media query tidak match lagi
                return function () {
                    controller.abort();
                };
            }
        );

    });
    </script>

</body>

</html>