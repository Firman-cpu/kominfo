<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — PRAKERIN DISKOMINFO Pacitan</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex" x-data="{ mobileMenuOpen: false }">

    {{-- Desktop Sidebar (Kiri) --}}
    <div class="hidden md:flex">
        @include('components.admin.sidebar')
    </div>

    {{-- Mobile Sidebar Drawer --}}
    <div x-cloak x-show="mobileMenuOpen" class="fixed inset-0 z-50 md:hidden flex" role="dialog" aria-modal="true">
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"
             class="fixed inset-0 bg-slate-950/80"></div>

        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative flex-1 flex flex-col max-w-xs w-full bg-slate-900">
            @include('components.admin.sidebar')
        </div>
    </div>

    {{-- Main Area (Kanan) --}}
    <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-x-hidden">
        {{-- Topbar Header --}}
        @include('components.admin.topbar', [
            'title' => $title ?? $__env->yieldContent('page-title', 'Dashboard'),
            'subtitle' => $subtitle ?? $__env->yieldContent('page-subtitle', 'Panel Pengelolaan Data'),
        ])

        {{-- Main Content Container --}}
        <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto">
            @include('components.admin.flash')
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="py-4 px-8 border-t border-slate-200 text-center text-xs text-slate-500 bg-white">
            <p>&copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kabupaten Pacitan. Seluruh Hak Cipta Dilindungi.</p>
        </footer>
    </div>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.initLucide) {
                window.initLucide();
            }
        });
    </script>
</body>
</html>
