@php
    // =====================================================
    // DATA INSTANSI — edit di sini saja
    // =====================================================
    $org = [
        'name'    => 'Dinas Komunikasi dan Informatika',
        'region'  => 'Kabupaten Pacitan',
        'address' => 'Jl. Jaksa Agung Suprapto, Pacitan, Kec. Pacitan, Kabupaten Pacitan, Jawa Timur 63511',
        'phone'   => '(0357) 882114',
        'website' => 'https://kominfo.pacitankab.go.id',
        'days'    => 'Senin – Jumat',
    ];

    $mapQuery = $org['name'] . ' ' . $org['region'] . ', Jl. Jaksa Agung Suprapto, Pacitan';

    $mapEmbed = 'https://www.google.com/maps?q=' . urlencode($mapQuery) . '&hl=id&z=16&output=embed';
    $mapOpen  = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($mapQuery);
    $mapRoute = 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($mapQuery);

    // Foto galeri — taruh file di public/images/profile/
    $photos = [
        ['src' => 'images/profile/gedung.jpg',    'caption' => 'Gedung Diskominfo Pacitan', 'tag' => 'Kantor'],
        ['src' => 'images/profile/ruang-kerja.jpg', 'caption' => 'Ruang kerja',             'tag' => 'Workspace'],
        ['src' => 'images/profile/kegiatan-1.jpg', 'caption' => 'Kegiatan siswa PKL',       'tag' => 'Kegiatan'],
        ['src' => 'images/profile/kegiatan-2.jpg', 'caption' => 'Bimbingan & diskusi',      'tag' => 'Kegiatan'],
        ['src' => 'images/profile/tim.jpg',        'caption' => 'Bersama tim',              'tag' => 'Tim'],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lokasi dan profil tempat PRAKERIN — Dinas Komunikasi dan Informatika Kabupaten Pacitan.">
    <meta name="theme-color" content="#f5f7fa">

    <title>Profile</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

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

        <div
            class="absolute inset-0 opacity-[0.035]
                   [background-image:linear-gradient(#365b88_1px,transparent_1px),linear-gradient(90deg,#365b88_1px,transparent_1px)]
                   [background-size:56px_56px]
                   [mask-image:linear-gradient(to_bottom,black,transparent_70%)]">
        </div>

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
        <header class="loc-head mb-12 flex flex-col justify-between gap-6 lg:flex-row lg:items-end">

            <div class="max-w-2xl">
                <h1 class="text-5xl font-black leading-[0.95] tracking-[-0.05em] text-[#263449] sm:text-6xl lg:text-7xl">
                    PROFILE
                </h1>
            </div>
        </header>


        {{-- ==================================================
             PROFILE + MAP
        =================================================== --}}
        <section class="grid gap-5 lg:grid-cols-5" aria-label="Profil dan peta lokasi">

            {{-- ---------- Profile card ---------- --}}
            <article
                class="loc-card relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-6
                       shadow-[0_4px_20px_rgba(35,57,84,0.04)] lg:col-span-2"
            >
                <div
                    class="pointer-events-none absolute -right-16 -top-16 h-44 w-44 rounded-full
                           bg-[radial-gradient(closest-side,rgba(65,107,158,0.12),transparent)]"
                    aria-hidden="true"
                ></div>

                <div class="relative mb-5 flex items-start justify-between gap-3">
                <img
                    src="{{ asset('image/logo.png') }}"
                    alt="Logo DISKOMINFO Kabupaten Pacitan"
                    class="h-12 w-auto object-contain"
                >

                    <span
                        class="shrink-0 rounded-full border border-[#cde9df] bg-[#edf8f3] px-2.5 py-1
                               font-mono text-[10px] font-bold uppercase tracking-wider text-[#347c68]"
                    >
                        Tempat PKL
                    </span>
                </div>

                <h2 class="relative text-xl font-black leading-tight tracking-tight text-[#263449]">
                    {{ $org['name'] }}
                </h2>

                <p class="relative mt-1 font-mono text-[11px] uppercase tracking-wider text-[#416b9e]">
                    {{ $org['region'] }}
                </p>

                <dl class="relative mt-5">

                    <div class="flex items-start gap-3 border-b border-[#edf1f6] py-3.5">
                        <dt class="flex w-24 shrink-0 items-center gap-1.5 font-mono text-[10px] uppercase tracking-wider text-[#6b7a8f]">
                            <i data-lucide="map-pin" class="h-3.5 w-3.5 text-[#7193bb]"></i>
                            Alamat
                        </dt>
                        <dd class="text-xs font-bold leading-6 text-[#43546a]">
                            {{ $org['address'] }}
                        </dd>
                    </div>

                    <div class="flex items-start gap-3 border-b border-[#edf1f6] py-3.5">
                        <dt class="flex w-24 shrink-0 items-center gap-1.5 font-mono text-[10px] uppercase tracking-wider text-[#6b7a8f]">
                            <i data-lucide="phone" class="h-3.5 w-3.5 text-[#7193bb]"></i>
                            Telepon
                        </dt>
                        <dd class="text-xs font-bold leading-6 text-[#43546a]">
                            <a
                                href="tel:{{ preg_replace('/[^0-9+]/', '', $org['phone']) }}"
                                class="transition-colors hover:text-[#243f63]"
                            >
                                {{ $org['phone'] }}
                            </a>
                        </dd>
                    </div>

                    <div class="flex items-start gap-3 border-b border-[#edf1f6] py-3.5">
                        <dt class="flex w-24 shrink-0 items-center gap-1.5 font-mono text-[10px] uppercase tracking-wider text-[#6b7a8f]">
                            <i data-lucide="globe" class="h-3.5 w-3.5 text-[#7193bb]"></i>
                            Website
                        </dt>
                        <dd class="min-w-0 break-words text-xs font-bold leading-6 text-[#43546a]">
                            <a
                                href="{{ $org['website'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="transition-colors hover:text-[#243f63]"
                            >
                                {{ preg_replace('#^https?://#', '', $org['website']) }}
                            </a>
                        </dd>
                    </div>

                    <div class="flex items-start gap-3 py-3.5">
                        <dt class="flex w-24 shrink-0 items-center gap-1.5 font-mono text-[10px] uppercase tracking-wider text-[#6b7a8f]">
                            <i data-lucide="calendar-days" class="h-3.5 w-3.5 text-[#7193bb]"></i>
                            Hari Kerja
                        </dt>
                        <dd class="text-xs font-bold leading-6 text-[#43546a]">
                            {{ $org['days'] }}
                        </dd>
                    </div>

                </dl>

                <div class="relative mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">

                    <a
                        href="{{ $mapOpen }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="group inline-flex items-center justify-center gap-2 rounded-xl border border-[#dce5f0]
                               bg-gradient-to-r from-[#f3f7fc] to-[#eaf1fa] px-4 py-3 text-[11px] font-bold text-[#365b88]
                               transition duration-300
                               hover:border-[#b8cbe1] hover:from-[#eaf1fa] hover:to-[#dfeaf7] hover:text-[#243f63]
                               focus-visible:outline-none focus-visible:ring-2
                               focus-visible:ring-[#416b9e] focus-visible:ring-offset-2"
                    >
                        Buka di Maps
                        <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"></i>
                    </a>

                    <a
                        href="{{ $mapRoute }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="group inline-flex items-center justify-center gap-2 rounded-xl
                               bg-gradient-to-r from-[#243f63] to-[#416b9e] px-4 py-3 text-[11px] font-bold text-white
                               shadow-lg shadow-[#365b88]/20 transition duration-300
                               hover:from-[#1d3556] hover:to-[#365b88]
                               focus-visible:outline-none focus-visible:ring-2
                               focus-visible:ring-[#416b9e] focus-visible:ring-offset-2"
                    >
                        <i data-lucide="navigation" class="h-3.5 w-3.5"></i>
                        Rute ke Sini
                    </a>

                </div>
            </article>


            {{-- ---------- Map card ---------- --}}
            <article
                class="loc-card flex flex-col overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white
                       shadow-[0_4px_20px_rgba(35,57,84,0.04)] lg:col-span-3"
            >
                <div class="flex items-center justify-between gap-3 border-b border-[#edf1f6] bg-[#f6f9fc] px-5 py-3.5">
                    <div class="flex items-center gap-2">
                        <i data-lucide="map" class="h-4 w-4 text-[#416b9e]"></i>
                        <span class="font-mono text-[10px] font-bold uppercase tracking-wider text-[#6b7a8f]">
                            Peta Lokasi
                        </span>
                    </div>

                    <span class="hidden truncate font-mono text-[10px] uppercase tracking-wider text-[#8a98ab] sm:block">
                        Pacitan, Jawa Timur
                    </span>
                </div>

                <div class="relative min-h-[360px] flex-1 bg-[#eaf1fa] lg:min-h-[440px]">
                    <iframe
                        src="{{ $mapEmbed }}"
                        title="Peta lokasi {{ $org['name'] }} {{ $org['region'] }}"
                        class="absolute inset-0 h-full w-full border-0"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
            </article>

        </section>


        {{-- ==================================================
             GALLERY
        =================================================== --}}
        <section class="mt-16" aria-label="Galeri foto">

            <div class="loc-card mb-6 flex items-end justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-black tracking-[-0.04em] text-[#263449] sm:text-4xl">
                        Galeri Foto
                    </h2>
                </div>

                <p class="hidden max-w-xs text-right text-sm leading-7 text-[#64748b] sm:block">
                    Suasana kantor dan kegiatan selama PKL.
                </p>
            </div>

            <div class="grid auto-rows-[200px] gap-4 sm:grid-cols-2 sm:auto-rows-[220px] lg:grid-cols-4">

                @foreach ($photos as $photo)

                    <figure
                        class="gallery-item group relative overflow-hidden rounded-2xl border border-[#e0e7f0]
                               bg-gradient-to-br from-[#eaf1fa] to-[#dfeaf7]
                               shadow-[0_4px_20px_rgba(35,57,84,0.04)]
                               {{ $loop->first ? 'sm:col-span-2 sm:row-span-2' : '' }}"
                    >

                        {{-- Placeholder (tampil kalau foto belum ada) --}}
                        <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 text-[#7193bb]" aria-hidden="true">
                            <i data-lucide="image" class="h-8 w-8"></i>
                            <span class="font-mono text-[10px] uppercase tracking-wider">Foto belum ditambahkan</span>
                        </div>

                        <img
                            src="{{ asset($photo['src']) }}"
                            alt="{{ $photo['caption'] }}"
                            loading="lazy"
                            decoding="async"
                            onerror="this.remove()"
                            class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        >

                        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-[#16263d]/70 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                        <figcaption
                            class="absolute inset-x-3 bottom-3 flex translate-y-1 items-center justify-between gap-2
                                   opacity-0 transition duration-300 group-hover:translate-y-0 group-hover:opacity-100"
                        >
                            <span class="truncate rounded-lg bg-white/90 px-2.5 py-1.5 text-[11px] font-bold text-[#263449]">
                                {{ $photo['caption'] }}
                            </span>
                            <span class="shrink-0 rounded-full border border-white/40 bg-[#243f63]/80 px-2.5 py-1 font-mono text-[10px] font-bold uppercase tracking-wider text-white">
                                {{ $photo['tag'] }}
                            </span>
                        </figcaption>

                    </figure>

                @endforeach

            </div>
        </section>


        {{-- ==================================================
             BACK TO STUDENTS
        =================================================== --}}
        <div class="loc-card mt-14 flex justify-center">
            <a
                href="{{ route('students.index') }}"
                class="group inline-flex items-center gap-2 rounded-xl border border-[#dce5f0]
                       bg-gradient-to-r from-[#f3f7fc] to-[#eaf1fa] px-5 py-3 text-[11px] font-bold text-[#365b88]
                       transition duration-300
                       hover:border-[#b8cbe1] hover:from-[#eaf1fa] hover:to-[#dfeaf7] hover:text-[#243f63]
                       focus-visible:outline-none focus-visible:ring-2
                       focus-visible:ring-[#416b9e] focus-visible:ring-offset-2"
            >
                <i data-lucide="arrow-left" class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5"></i>
                Kembali ke Data Siswa
            </a>
        </div>

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

        mm.add('(prefers-reduced-motion: no-preference)', function () {

            // Header
            gsap.from('.loc-head > *', {
                y: 24, opacity: 0, duration: 0.8, stagger: 0.12, ease: 'power3.out'
            });

            // Card, galeri, tombol — reveal saat masuk viewport
            const targets = gsap.utils.toArray('.loc-card, .gallery-item');

            if (targets.length) {
                gsap.set(targets, { opacity: 0, y: 32 });

                const reveal = function (els) {
                    gsap.to(els, {
                        opacity: 1,
                        y: 0,
                        duration: 0.7,
                        stagger: 0.1,
                        ease: 'power3.out',
                        clearProps: 'opacity,transform'
                    });
                };

                if (window.ScrollTrigger) {
                    ScrollTrigger.batch(targets, {
                        start: 'top 92%',
                        once: true,
                        onEnter: reveal
                    });
                } else {
                    reveal(targets);
                }
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