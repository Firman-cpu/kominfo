@props([
    'title' => 'Dashboard',
    'subtitle' => 'Panel Pengelolaan Data PRAKERIN & Magang'
])

@php
    $admin = Auth::guard('admin')->user()?->fresh() ?? Auth::guard('admin')->user();
@endphp

<div class="h-16 bg-[#ebf0f7] border-b border-[#d8e2ee] px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4 transition-all">
    {{-- Left: Mobile Hamburger & Search Bar --}}
    <div class="flex items-center gap-3 sm:gap-4 flex-1 max-w-xl">
        {{-- Mobile Hamburger (Neumorphic Button) --}}
        <button
            type="button"
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="md:hidden flex h-9 w-9 items-center justify-center rounded-xl neu-btn text-slate-600 transition-colors"
            aria-label="Buka menu navigasi"
        >
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>

        {{-- Interactive Search Bar (Neumorphic Inset) --}}
        <div class="relative w-full">
            <button
                type="button"
                @click="openSearchModal()"
                class="flex w-full items-center justify-between rounded-2xl neu-inset px-4 py-2.5 text-xs text-slate-500 hover:text-slate-800 transition-all text-left cursor-pointer"
                aria-label="Pencarian cepat"
            >
                <div class="flex items-center gap-2.5 truncate">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 shrink-0"></i>
                    <span class="truncate">Cari nama sekolah, siswa, atau fitur dashboard...</span>
                </div>
                <div class="flex items-center gap-1 shrink-0 ml-2">
                    <kbd class="hidden sm:inline-flex items-center justify-center rounded-lg neu-card-sm px-2 py-0.5 text-[10px] font-bold text-slate-600">
                        ⌘K
                    </kbd>
                </div>
            </button>
        </div>
    </div>

    {{-- Right: Profile Menu (Notifikasi Ditiadakan Sesuai Permintaan) --}}
    <div class="flex items-center gap-3 shrink-0" x-data="{ profileOpen: false }">
        {{-- Profile Button (Neumorphic Card Button) --}}
        <div class="relative">
            <button
                type="button"
                @click="profileOpen = !profileOpen"
                @click.outside="profileOpen = false"
                class="flex items-center gap-2.5 rounded-2xl neu-btn p-1.5 sm:pr-3 text-left cursor-pointer"
            >
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl neu-dark-cta text-white font-bold text-xs overflow-hidden">
                    @if ($admin?->photo_url)
                        <img src="{{ $admin->photo_url }}" alt="{{ $admin->name }}" class="h-full w-full object-cover">
                    @else
                        {{ strtoupper(substr($admin?->name ?? 'A', 0, 1)) }}
                    @endif
                </div>
                <div class="hidden sm:block text-left leading-tight">
                    <p class="text-xs font-bold text-slate-900 truncate max-w-[140px]">
                        {{ $admin?->name ?? 'Administrator' }}
                    </p>
                    <p class="text-[10px] font-semibold text-slate-500">
                        {{ $admin?->isAdministrator() ? 'Administrator' : 'Operator Data' }}
                    </p>
                </div>
                <i data-lucide="chevron-down" class="hidden sm:block w-3.5 h-3.5 text-slate-400"></i>
            </button>

            {{-- Profile Dropdown (Neumorphic Card) --}}
            <div
                x-cloak
                x-show="profileOpen"
                style="display: none;"
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-0"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-0"
                class="absolute right-0 mt-3 w-52 rounded-3xl bg-[#ebf0f7] shadow-[10px_10px_24px_#c5d0de,-10px_-10px_24px_#ffffff] p-3 z-50 text-xs text-slate-700"
            >
                <a href="{{ route('admin.profile.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:neu-card-sm transition-all text-slate-700 font-semibold">
                    <i data-lucide="user" class="w-4 h-4 text-slate-500"></i>
                    <span>Pengaturan Profil</span>
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-2 pt-2 border-t border-[#d8e2ee]">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-rose-600 hover:neu-card-sm transition-all text-left font-bold cursor-pointer">
                        <i data-lucide="log-out" class="w-4 h-4 text-rose-500"></i>
                        <span>Keluar (Logout)</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
