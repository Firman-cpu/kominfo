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
             STUDENT TABLE
        =================================================== --}}
        @if ($students->count())

            <section
                class="students-table overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white
                       shadow-[0_4px_20px_rgba(35,57,84,0.04)]"
                aria-label="Daftar siswa PRAKERIN"
            >
                <div class="overflow-x-auto">

                    <table class="w-full min-w-[760px] border-collapse text-left">

                        <caption class="sr-only">Daftar siswa Praktik Kerja Lapangan DISKOMINFO Kabupaten Pacitan</caption>

                        <thead>
                            <tr class="border-b border-[#e0e7f0] bg-[#f6f9fc]">
                                <th scope="col" class="w-16 px-5 py-4 font-mono text-[10px] font-bold uppercase tracking-wider text-[#6b7a8f]">
                                    No
                                </th>
                                <th scope="col" class="px-5 py-4 font-mono text-[10px] font-bold uppercase tracking-wider text-[#6b7a8f]">
                                    Siswa
                                </th>
                                <th scope="col" class="px-5 py-4 font-mono text-[10px] font-bold uppercase tracking-wider text-[#6b7a8f]">
                                    Jurusan
                                </th>
                                <th scope="col" class="px-5 py-4 font-mono text-[10px] font-bold uppercase tracking-wider text-[#6b7a8f]">
                                    Kelas
                                </th>
                                <th scope="col" class="px-5 py-4 font-mono text-[10px] font-bold uppercase tracking-wider text-[#6b7a8f]">
                                    Mulai
                                </th>
                                <th scope="col" class="px-5 py-4 font-mono text-[10px] font-bold uppercase tracking-wider text-[#6b7a8f]">
                                    Status
                                </th>
                                <th scope="col" class="px-5 py-4 text-right font-mono text-[10px] font-bold uppercase tracking-wider text-[#6b7a8f]">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#edf1f6]">

                            @foreach ($students as $student)

                                @php
                                    $isActive = in_array(Str::lower((string) $student->status), $activeStatuses, true);
                                @endphp

                                <tr class="student-row group transition-colors duration-200 hover:bg-[#f6f9fc]">

                                    {{-- No (lanjut antar halaman pagination) --}}
                                    <td class="px-5 py-4 font-mono text-xs font-bold text-[#8a98ab]">
                                        {{ str_pad((string) ($students->firstItem() + $loop->index), 2, '0', STR_PAD_LEFT) }}
                                    </td>

                                    {{-- Siswa --}}
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                                                       bg-gradient-to-br from-[#243f63] via-[#365b88] to-[#7197c1]
                                                       text-sm font-black text-white shadow-md shadow-[#365b88]/15"
                                                aria-hidden="true"
                                            >
                                                {{ Str::upper(Str::substr($student->name, 0, 1)) }}
                                            </div>

                                            <span
                                                class="max-w-[220px] truncate text-sm font-black tracking-tight text-[#263449]"
                                                title="{{ $student->name }}"
                                            >
                                                {{ $student->name }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Jurusan --}}
                                    <td class="px-5 py-4">
                                        <span
                                            class="block max-w-[220px] truncate font-mono text-[11px] uppercase tracking-wider text-[#416b9e]"
                                            title="{{ $student->major }}"
                                        >
                                            {{ $student->major }}
                                        </span>
                                    </td>

                                    {{-- Kelas --}}
                                    <td class="whitespace-nowrap px-5 py-4 text-xs font-bold text-[#43546a]">
                                        {{ $student->class ?? '—' }}
                                    </td>

                                    {{-- Mulai --}}
                                    <td class="whitespace-nowrap px-5 py-4 text-xs font-bold text-[#43546a]">
                                        {{ $student->start_date?->format('d M Y') ?? '—' }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-5 py-4">
                                        <span
                                            class="inline-block rounded-full border px-2.5 py-1 font-mono text-[10px]
                                                   font-bold uppercase tracking-wider
                                                   {{ $isActive
                                                        ? 'border-[#cde9df] bg-[#edf8f3] text-[#347c68]'
                                                        : 'border-[#dce5f0] bg-[#f1f5fa] text-[#58708e]' }}"
                                        >
                                            {{ Str::ucfirst((string) $student->status) }}
                                        </span>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-5 py-4 text-right">
                                        <a
                                            href="{{ route('students.show', $student) }}"
                                            class="inline-flex items-center justify-center gap-1.5 whitespace-nowrap
                                                   rounded-xl border border-[#dce5f0]
                                                   bg-gradient-to-r from-[#f3f7fc] to-[#eaf1fa]
                                                   px-3.5 py-2 text-[11px] font-bold text-[#365b88]
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
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>
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

            // Header + stats + wrapper tabel dalam satu timeline
            const tl = gsap.timeline({ defaults: { ease: 'power3.out' } })
                .from('.students-head > *', {
                    y: 24, opacity: 0, duration: 0.8, stagger: 0.12
                })
                .from('.stats-strip', {
                    y: 30, opacity: 0, duration: 0.8
                }, '-=0.45');

            if (document.querySelector('.students-table')) {
                tl.from('.students-table', {
                    y: 30, opacity: 0, duration: 0.8, clearProps: 'opacity,transform'
                }, '-=0.5');
            }

            // Baris tabel — sembunyikan dulu, lalu reveal saat masuk viewport
            const rows = gsap.utils.toArray('.student-row');

            if (rows.length) {
                gsap.set(rows, { opacity: 0, y: 16 });

                const reveal = function (els) {
                    gsap.to(els, {
                        opacity: 1,
                        y: 0,
                        duration: 0.5,
                        stagger: 0.05,
                        ease: 'power2.out',
                        clearProps: 'opacity,transform'
                    });
                };

                if (window.ScrollTrigger) {
                    ScrollTrigger.batch(rows, {
                        start: 'top 95%',
                        once: true,
                        onEnter: reveal
                    });
                } else {
                    reveal(rows);
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

    });
    </script>

</body>

</html>