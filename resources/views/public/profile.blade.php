<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman Profil DISKOMINFO Kabupaten Pacitan sedang dalam pengerjaan.">

    <title>Dalam Pengerjaan — PRAKERIN Pacitan</title>

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

        /* Progress bar indeterminate */
        @keyframes indeterminate {
            0%   { transform: translateX(-100%); }
            100% { transform: translateX(350%); }
        }
        .progress-runner {
            width: 30%;
            animation: indeterminate 1.8s cubic-bezier(.4, 0, .2, 1) infinite;
        }

        /* Gear spin */
        @keyframes spin-slow {
            to { transform: rotate(360deg); }
        }
        .gear-spin {
            animation: spin-slow 12s linear infinite;
        }

        /* Strip garis konstruksi (halus) */
        .caution-strip {
            background-image: repeating-linear-gradient(
                -45deg,
                #365b88 0 10px,
                #dce7f5 10px 20px
            );
        }

        .orb { will-change: transform; }

        @media (prefers-reduced-motion: reduce) {
            .shimmer-text,
            .progress-runner,
            .gear-spin { animation: none; }
            .progress-runner { width: 45%; }
        }
    </style>
</head>

@php
    /* Ganti path ini kalau nama / format file logo berbeda */
    $logoPath = 'images/logo-kominfo.png';
    $hasLogo  = file_exists(public_path($logoPath));
@endphp

<body
    x-data="{ mobileOpen: false, scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 20"
    class="min-h-screen overflow-x-hidden bg-[#f5f7fa] text-[#263449] antialiased selection:bg-[#dbe6f5]"
>

    {{-- BACKGROUND --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden" aria-hidden="true">
        <div class="orb orb-1 absolute -left-40 -top-40 h-[400px] w-[400px] rounded-full bg-[#dce7f5]/70 blur-[120px]"></div>
        <div class="orb orb-2 absolute -right-40 top-[15%] h-[400px] w-[400px] rounded-full bg-[#d7e7f5]/70 blur-[120px]"></div>
        <div class="orb orb-3 absolute bottom-[-200px] left-[30%] h-[400px] w-[400px] rounded-full bg-[#e3e9f1]/60 blur-[120px]"></div>
        <div class="absolute inset-0 bg-white/10"></div>
    </div>


    <main class="relative mx-auto flex min-h-screen max-w-3xl flex-col items-center justify-center px-4 pb-40 pt-16 text-center sm:px-6">

        {{-- ═════════════ LOGO KOMINFO ═════════════ --}}
        <div class="uc-item relative mb-10">
            <div class="relative flex h-40 w-40 items-center justify-center rounded-[2rem] border border-[#dce4ef] bg-white shadow-[0_12px_40px_rgba(35,57,84,0.1)] sm:h-44 sm:w-44">

                {{-- Bracket sudut --}}
                <span class="absolute left-3 top-3 h-4 w-4 rounded-tl-lg border-l-2 border-t-2 border-[#8ba8ca]"></span>
                <span class="absolute right-3 top-3 h-4 w-4 rounded-tr-lg border-r-2 border-t-2 border-[#8ba8ca]"></span>
                <span class="absolute bottom-3 left-3 h-4 w-4 rounded-bl-lg border-b-2 border-l-2 border-[#8ba8ca]"></span>
                <span class="absolute bottom-3 right-3 h-4 w-4 rounded-br-lg border-b-2 border-r-2 border-[#8ba8ca]"></span>

                    <img
                        src="image/logo.png"
                        alt="Logo DISKOMINFO Kabupaten Pacitan"
                        class="h-24 w-24 object-contain sm:h-28 sm:w-28"
                    >

            </div>

            {{-- Gear badge --}}
            <div class="absolute -bottom-3 -right-3 flex h-11 w-11 items-center justify-center rounded-xl border border-[#dde7f5] bg-[#eef3fa] text-[#365b88] shadow-md">
                <i data-lucide="settings" class="gear-spin h-5 w-5"></i>
            </div>
        </div>


        {{-- ═════════════ BADGE ═════════════ --}}
        <div class="uc-item mb-5 inline-flex items-center gap-2.5 rounded-lg border border-[#dce4ef] bg-white/90 px-3.5 py-2 shadow-sm backdrop-blur">
            <span class="relative flex h-2 w-2">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#456b97] opacity-60"></span>
                <span class="relative inline-flex h-2 w-2 rounded-full bg-[#365b88]"></span>
            </span>
            <span class="font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-[#526a87]">
                Dalam Pengerjaan
            </span>
        </div>


        {{-- ═════════════ JUDUL ═════════════ --}}
        <h1 class="uc-item text-5xl font-bold leading-[0.98] tracking-[-0.065em] text-[#263449] sm:text-6xl lg:text-7xl">
            SEGERA
            <span class="shimmer-text mt-2 block bg-gradient-to-r from-[#1e3a5f] via-[#416b9e] to-[#294d78] bg-clip-text text-transparent">
                HADIR
            </span>
        </h1>

        <p class="uc-item mt-6 max-w-xl text-sm leading-7 text-[#718096] sm:text-base">
            Halaman profil DISKOMINFO Kabupaten Pacitan sedang kami siapkan.
            Terima kasih sudah mampir, silakan kembali lagi sebentar lagi.
        </p>


        {{-- ═════════════ PROGRESS ═════════════ --}}
        <div class="uc-item mt-10 w-full max-w-md">
            <div class="mb-2 flex items-center justify-between">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.16em] text-[#8394a7]">Progress</span>
                <span class="flex items-center gap-1.5 font-mono text-[9px] font-semibold uppercase tracking-wider text-[#8394a7]">
                    <i data-lucide="hammer" class="h-3 w-3"></i>
                    Sedang dibangun
                </span>
            </div>

            <div class="h-2 overflow-hidden rounded-full bg-[#e8edf3]">
                <div class="progress-runner h-full rounded-full bg-gradient-to-r from-[#365b88] to-[#8ba8ca]"></div>
            </div>

            <div class="caution-strip mt-4 h-1.5 w-full rounded-full opacity-30"></div>
        </div>


        {{-- ═════════════ STATUS STEPS ═════════════ --}}
        <div class="uc-item mt-8 grid w-full max-w-xl gap-3 text-left sm:grid-cols-3">

            <div class="rounded-2xl border border-[#d0eddb] bg-white p-4 shadow-[0_4px_20px_rgba(35,57,84,0.045)]">
                <div class="mb-3 flex h-8 w-8 items-center justify-center rounded-lg border border-[#d0eddb] bg-[#e9f7ee] text-[#2d7a4f]">
                    <i data-lucide="check-check" class="h-4 w-4"></i>
                </div>
                <p class="text-xs font-bold text-[#30425a]">Kerangka</p>
                <p class="mt-0.5 font-mono text-[9px] uppercase tracking-wider text-[#2d7a4f]">Selesai</p>
            </div>

            <div class="rounded-2xl border border-[#dde7f5] bg-white p-4 shadow-[0_4px_20px_rgba(35,57,84,0.045)]">
                <div class="mb-3 flex h-8 w-8 items-center justify-center rounded-lg border border-[#dde7f5] bg-[#eef3fa] text-[#365b88]">
                    <i data-lucide="pen-line" class="h-4 w-4"></i>
                </div>
                <p class="text-xs font-bold text-[#30425a]">Konten</p>
                <p class="mt-0.5 font-mono text-[9px] uppercase tracking-wider text-[#365b88]">Dalam proses</p>
            </div>

            <div class="rounded-2xl border border-[#e0e7f0] bg-white/70 p-4 shadow-[0_4px_20px_rgba(35,57,84,0.03)]">
                <div class="mb-3 flex h-8 w-8 items-center justify-center rounded-lg border border-[#e0e7f0] bg-[#f5f7fa] text-[#8394a7]">
                    <i data-lucide="rocket" class="h-4 w-4"></i>
                </div>
                <p class="text-xs font-bold text-[#30425a]">Peluncuran</p>
                <p class="mt-0.5 font-mono text-[9px] uppercase tracking-wider text-[#8394a7]">Segera</p>
            </div>

        </div>


        {{-- ═════════════ ACTIONS ═════════════ --}}
        <div class="uc-item mt-10 flex flex-col items-center gap-3 sm:flex-row">
            <a href="{{ url('/') }}"
               class="group inline-flex items-center gap-2.5 rounded-xl bg-gradient-to-br from-[#1e3a5f] to-[#365b88] px-5 py-3 text-sm font-semibold text-white shadow-[0_8px_24px_rgba(35,57,84,0.2)] transition hover:-translate-y-0.5">
                <i data-lucide="arrow-left" class="h-4 w-4 transition-transform group-hover:-translate-x-1"></i>
                Kembali ke Beranda
            </a>

            <a href="{{ route('students.index') }}"
               class="inline-flex items-center gap-2.5 rounded-xl border border-[#dce4ef] bg-white px-5 py-3 text-sm font-semibold text-[#365b88] shadow-sm transition hover:-translate-y-0.5 hover:border-[#c3d3e6]">
                <i data-lucide="users" class="h-4 w-4"></i>
                Lihat Data Siswa
            </a>
        </div>

    </main>


    {{-- FLOATING NAVIGATION --}}
    @include('partials.navbar')

    {{-- PAGE TRANSITION --}}
    @include('partials.page-transition')


    {{-- CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
        }

        if (!window.gsap) return;

        // Hormati preferensi reduced motion
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        const ctx = gsap.context(function () {

            /* ENTRANCE */
            gsap.from('.uc-item', {
                y: 28,
                opacity: 0,
                duration: 0.75,
                stagger: 0.11,
                delay: 0.1,
                ease: 'power3.out',
                clearProps: 'transform,opacity'
            });

            /* AMBIENT ORBS */
            gsap.to('.orb-1', { x: 30,  y: 20,  duration: 14, repeat: -1, yoyo: true, ease: 'sine.inOut' });
            gsap.to('.orb-2', { x: -25, y: 25,  duration: 16, repeat: -1, yoyo: true, ease: 'sine.inOut' });
            gsap.to('.orb-3', { x: 15,  y: -20, duration: 18, repeat: -1, yoyo: true, ease: 'sine.inOut' });

        });

        // Cleanup saat pindah halaman
        window.addEventListener('pagehide', function () { ctx.revert(); });
    });
    </script>

</body>
</html>