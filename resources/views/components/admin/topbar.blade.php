@props(['title' => 'Dashboard', 'subtitle' => 'Panel Pengelolaan Data'])

@php
    $admin = Auth::guard('admin')->user();
@endphp

<header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between sticky top-0 z-20">
    <div class="flex items-center gap-4">
        {{-- Mobile Hamburger Toggle --}}
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>

        <div>
            <h2 class="text-base font-bold text-slate-900 leading-tight">{{ $title }}</h2>
            <p class="text-xs text-slate-500">{{ $subtitle }}</p>
        </div>
    </div>

    <div class="flex items-center gap-3">
        {{-- Status Sync Badge indicator --}}
        <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            Sistem Aktif
        </span>

        {{-- User Avatar Dropdown/Badge --}}
        <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-semibold text-slate-800">{{ $admin->name }}</p>
                <p class="text-[11px] text-slate-500 font-medium">
                    {{ $admin->isAdministrator() ? 'Administrator' : 'Operator Data' }}
                </p>
            </div>
            <a href="{{ route('admin.profile.index') }}"
               class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs ring-2 ring-blue-500/30 hover:ring-blue-500 transition-all">
                {{ strtoupper(substr($admin->name ?? 'A', 0, 1)) }}
            </a>
        </div>
    </div>
</header>
