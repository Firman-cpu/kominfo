@php
    $admin = Auth::guard('admin')->user();
@endphp

<aside class="w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 border-r border-slate-800 select-none min-h-screen">
    {{-- Brand Header --}}
    <div class="h-16 flex items-center px-6 gap-3 border-b border-slate-800 bg-slate-950/40">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-md shadow-blue-500/20 shrink-0">
            <i data-lucide="shield-check" class="w-5 h-5"></i>
        </div>
        <div class="overflow-hidden">
            <h1 class="text-sm font-bold text-white tracking-wide truncate">DISKOMINFO</h1>
            <p class="text-[11px] text-blue-400 font-medium truncate">Portal Data Prakerin</p>
        </div>
    </div>

    {{-- User Profile Card --}}
    <div class="p-4 mx-3 my-3 rounded-xl bg-slate-800/60 border border-slate-700/50 flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
            {{ strtoupper(substr($admin->name ?? 'A', 0, 1)) }}
        </div>
        <div class="overflow-hidden flex-1">
            <p class="text-xs font-semibold text-white truncate">{{ $admin->name }}</p>
            <div class="flex items-center gap-1.5 mt-0.5">
                @if ($admin->isAdministrator())
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-blue-500/20 text-blue-300 border border-blue-500/30">
                        Administrator
                    </span>
                @else
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        Operator
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Navigation Menu --}}
    <nav class="flex-1 px-3 py-2 space-y-6 overflow-y-auto">
        {{-- Section Menu Utama --}}
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                Menu Utama
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard.page') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard.page') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 shrink-0"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.students.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.students.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i data-lucide="users" class="w-4 h-4 shrink-0"></i>
                        <span>Siswa & Mahasiswa</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.assessments.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.assessments.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i data-lucide="award" class="w-4 h-4 shrink-0"></i>
                        <span>Penilaian Peserta</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.aspects.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.aspects.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i data-lucide="sliders" class="w-4 h-4 shrink-0"></i>
                        <span>Aspek Penilaian</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i data-lucide="badge-percent" class="w-4 h-4 shrink-0"></i>
                        <span>Kategori Nilai</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.analytics.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.analytics.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i data-lucide="bar-chart-3" class="w-4 h-4 shrink-0"></i>
                        <span>Analitik & Statistik</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.export.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.export.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4 shrink-0"></i>
                        <span>Ekspor Excel</span>
                    </a>
                </li>
            </ul>
        </div>

        {{-- Section Khusus Administrator (Kasta Tertinggi) --}}
        @if ($admin->isAdministrator())
            <div>
                <div class="px-3 mb-2 text-[10px] font-bold tracking-wider text-amber-400/90 uppercase flex items-center gap-1.5">
                    <i data-lucide="shield" class="w-3 h-3 text-amber-400"></i>
                    <span>Administrator</span>
                </div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.operators.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.operators.*') ? 'bg-amber-600 text-white shadow-sm shadow-amber-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                            <i data-lucide="user-cog" class="w-4 h-4 shrink-0"></i>
                            <span>Akun Operator</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.logs.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.logs.*') ? 'bg-amber-600 text-white shadow-sm shadow-amber-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                            <i data-lucide="history" class="w-4 h-4 shrink-0"></i>
                            <span>Log Aktivitas</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endif

        {{-- Section Akun Saya --}}
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                Pengaturan
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.profile.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.profile.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i data-lucide="user" class="w-4 h-4 shrink-0"></i>
                        <span>Profil Saya</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}" target="_blank"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-white hover:bg-slate-800/60 transition-colors">
                        <i data-lucide="external-link" class="w-4 h-4 shrink-0"></i>
                        <span>Lihat Web Publik</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Logout Button Bottom --}}
    <div class="p-4 border-t border-slate-800">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-rose-400 hover:text-white hover:bg-rose-500/20 border border-rose-500/30 transition-colors">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span>Keluar (Logout)</span>
            </button>
        </form>
    </div>
</aside>
