@props(['title' => 'Dashboard', 'subtitle' => 'Panel Pengelolaan Data'])

@php
    $admin = Auth::guard('admin')->user()?->fresh() ?? Auth::guard('admin')->user();
@endphp

{{-- Topbar tidak perlu sticky sendiri — layout parent sudah menangani sticky --}}
<header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shadow-sm">
    <div class="flex items-center gap-4">
        {{-- Mobile Hamburger --}}
        <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>

        <div>
            <h2 class="text-base font-bold text-slate-900 leading-tight">{{ $title }}</h2>
            <p class="text-xs text-slate-500">{{ $subtitle }}</p>
        </div>
    </div>

    {{-- Right side: user badge --}}
    <div class="flex items-center gap-3">
        <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-semibold text-slate-800">{{ $admin->name }}</p>
                <p class="text-[11px] text-slate-500 font-medium">
                    {{ $admin->isAdministrator() ? 'Administrator' : 'Operator Data' }}
                </p>
            </div>
            <div class="w-9 h-9 rounded-xl overflow-hidden flex items-center justify-center text-white font-bold text-sm shrink-0">
                <img src="{{ $admin->photo_url }}"
                     alt="{{ $admin->name }}"
                     class="w-full h-full object-cover"
                     onerror="this.style.display='none'; this.parentElement.textContent='{{ strtoupper(substr($admin->name ?? 'A', 0, 1)) }}';">
            </div>
        </div>
    </div>
</header>
