<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — PRAKERIN DISKOMINFO Pacitan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        [x-cloak] { display: none !important; }

        /* Scrollbar halus untuk sidebar nav */
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(148,163,184,.25); border-radius: 999px; }
        .sidebar-nav::-webkit-scrollbar-thumb:hover { background: rgba(148,163,184,.45); }

        /* Scrollbar halus untuk main content */
        .main-scroll::-webkit-scrollbar { width: 6px; }
        .main-scroll::-webkit-scrollbar-track { background: transparent; }
        .main-scroll::-webkit-scrollbar-thumb { background: rgba(148,163,184,.35); border-radius: 999px; }
        .main-scroll::-webkit-scrollbar-thumb:hover { background: rgba(100,116,139,.55); }
    </style>

    @stack('styles')
</head>

{{--
    LAYOUT STRATEGY
    ───────────────
    • <body>          → h-screen, overflow-hidden  → tidak ada scroll di body
    • #sidebar        → fixed left-0 top-0, w-64, h-screen, flex-col  → sidebar tetap di tempat
    • #main-wrapper   → ml-64, h-screen, flex-col  → kolom kanan penuh tinggi layar
      ├── topbar      → shrink-0  → tinggi tetap, tidak ikut scroll
      ├── <main>      → flex-1, overflow-y-auto  → HANYA bagian ini yang scroll
      └── footer      → shrink-0  → selalu di bawah area konten
--}}
<body class="h-screen overflow-hidden bg-slate-50 text-slate-800 antialiased"
      x-data="{ mobileMenuOpen: false }">

    {{-- ══════════════ SIDEBAR DESKTOP — FIXED ══════════════ --}}
    <div class="hidden md:block">
        @include('components.admin.sidebar')
    </div>

    {{-- ══════════════ MOBILE SIDEBAR DRAWER ══════════════ --}}
    <div x-cloak
         x-show="mobileMenuOpen"
         class="fixed inset-0 z-50 md:hidden flex"
         role="dialog" aria-modal="true">

        {{-- Backdrop --}}
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"
             class="fixed inset-0 bg-slate-950/80"></div>

        {{-- Drawer panel --}}
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative z-10 flex flex-col max-w-xs w-full h-full bg-slate-900 overflow-hidden">
            @include('components.admin.sidebar')
        </div>
    </div>

    {{-- ══════════════ MAIN WRAPPER (kolom kanan) ══════════════ --}}
    {{-- ml-64 = beri ruang untuk sidebar fixed 256px --}}
    <div id="main-wrapper" class="md:ml-64 h-screen flex flex-col overflow-hidden">

        {{-- TOPBAR — sticky di atas, tidak ikut scroll --}}
        <div class="shrink-0 sticky top-0 z-30">
            @include('components.admin.topbar', [
                'title'    => $title ?? $__env->yieldContent('page-title', 'Dashboard'),
                'subtitle' => $subtitle ?? $__env->yieldContent('page-subtitle', 'Panel Pengelolaan Data'),
            ])
        </div>

        {{-- SCROLL AREA — hanya bagian ini yang scroll --}}
        <div class="main-scroll flex-1 overflow-y-auto overflow-x-hidden">

            {{-- Content --}}
            <main class="p-6 md:p-8 max-w-7xl w-full mx-auto min-h-[calc(100%-3.5rem)]">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="py-4 px-8 border-t border-slate-200 bg-white text-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kabupaten Pacitan. Seluruh Hak Cipta Dilindungi.</p>
            </footer>

        </div>{{-- /scroll area --}}

    </div>{{-- /main-wrapper --}}

    {{-- Toast Notifications --}}
    @include('components.admin.flash')

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.initLucide) window.initLucide();
        });
    </script>
</body>
</html>
