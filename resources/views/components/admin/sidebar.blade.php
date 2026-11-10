@php
    $admin = Auth::guard('admin')->user()?->fresh() ?? Auth::guard('admin')->user();
@endphp

<div class="flex h-full w-full flex-col justify-between bg-[#ebf0f7] select-none p-2">
    {{-- Top Section: Brand & Nav --}}
    <div class="flex flex-col flex-1 overflow-hidden">
        {{-- Brand Header (Neumorphic) --}}
        <div class="flex h-16 items-center px-4 gap-1 border-b border-[#d8e2ee] shrink-0">
            <div class="flex h-12 w-12 items-center justify-center p-2">
                <img
                    src="{{ asset('image/logo.svg') }}"
                    alt="Logo Diskominfo Kabupaten Pacitan"
                    class="h-full w-full object-contain"
                >
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-1.5">
                    <h1 class="text-sm font-extrabold tracking-tight text-slate-900 truncate">DISKOMINFO</h1>
                </div>
                <p class="text-[11px] font-semibold text-slate-400 truncate">Kabupaten Pacitan</p>
            </div>
        </div>

        {{-- Navigation Menu --}}
        <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-4" aria-label="Navigasi Utama">
            {{-- Menu Utama --}}
            <div>
                <p class="px-3 mb-2 text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                    Menu Utama
                </p>
                <div class="space-y-1.5">
                    {{-- Dashboard --}}
                    @php $isDashboard = request()->routeIs('admin.dashboard.*') || request()->is('admin/dashboard'); @endphp
                    <a href="{{ route('admin.dashboard.page') }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 {{ $isDashboard ? 'neu-primary font-bold' : 'text-slate-600 hover:text-slate-900 hover:neu-card-sm font-medium' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 shrink-0 transition-transform duration-200 group-hover:scale-105 {{ $isDashboard ? 'text-white' : 'text-slate-500' }}"></i>
                        <span>Dashboard</span>
                    </a>

                    {{-- Siswa & Mahasiswa --}}
                    @php $isStudents = request()->routeIs('admin.students.*'); @endphp
                    <a href="{{ route('admin.students.index') }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 {{ $isStudents ? 'neu-primary font-bold' : 'text-slate-600 hover:text-slate-900 hover:neu-card-sm font-medium' }}">
                        <i data-lucide="users" class="w-4 h-4 shrink-0 transition-transform duration-200 group-hover:scale-105 {{ $isStudents ? 'text-white' : 'text-slate-500' }}"></i>
                        <span>Siswa & Mahasiswa</span>
                    </a>

                    {{-- Penilaian Peserta --}}
                    @php $isAssessments = request()->routeIs('admin.assessments.*'); @endphp
                    <a href="{{ route('admin.assessments.index') }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 {{ $isAssessments ? 'neu-primary font-bold' : 'text-slate-600 hover:text-slate-900 hover:neu-card-sm font-medium' }}">
                        <i data-lucide="award" class="w-4 h-4 shrink-0 transition-transform duration-200 group-hover:scale-105 {{ $isAssessments ? 'text-white' : 'text-slate-500' }}"></i>
                        <span>Penilaian Peserta</span>
                    </a>

                    {{-- Aspek Penilaian --}}
                    @php $isAspects = request()->routeIs('admin.aspects.*'); @endphp
                    <a href="{{ route('admin.aspects.index') }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 {{ $isAspects ? 'neu-primary font-bold' : 'text-slate-600 hover:text-slate-900 hover:neu-card-sm font-medium' }}">
                        <i data-lucide="sliders" class="w-4 h-4 shrink-0 transition-transform duration-200 group-hover:scale-105 {{ $isAspects ? 'text-white' : 'text-slate-500' }}"></i>
                        <span>Aspek Penilaian</span>
                    </a>

                    {{-- Kategori Nilai --}}
                    @php $isCategories = request()->routeIs('admin.categories.*'); @endphp
                    <a href="{{ route('admin.categories.index') }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 {{ $isCategories ? 'neu-primary font-bold' : 'text-slate-600 hover:text-slate-900 hover:neu-card-sm font-medium' }}">
                        <i data-lucide="badge-percent" class="w-4 h-4 shrink-0 transition-transform duration-200 group-hover:scale-105 {{ $isCategories ? 'text-white' : 'text-slate-500' }}"></i>
                        <span>Kategori Nilai</span>
                    </a>

                    {{-- Analitik & Statistik --}}
                    @php $isAnalytics = request()->routeIs('admin.analytics.*'); @endphp
                    <a href="{{ route('admin.analytics.index') }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 {{ $isAnalytics ? 'neu-primary font-bold' : 'text-slate-600 hover:text-slate-900 hover:neu-card-sm font-medium' }}">
                        <i data-lucide="bar-chart-3" class="w-4 h-4 shrink-0 transition-transform duration-200 group-hover:scale-105 {{ $isAnalytics ? 'text-white' : 'text-slate-500' }}"></i>
                        <span>Analitik & Statistik</span>
                    </a>

                    {{-- Ekspor Excel --}}
                    @php $isExport = request()->routeIs('admin.export.*'); @endphp
                    <a href="{{ route('admin.export.index') }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 {{ $isExport ? 'neu-primary font-bold' : 'text-slate-600 hover:text-slate-900 hover:neu-card-sm font-medium' }}">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4 shrink-0 transition-transform duration-200 group-hover:scale-105 {{ $isExport ? 'text-white' : 'text-slate-500' }}"></i>
                        <span>Ekspor Excel</span>
                    </a>
                </div>
            </div>

            {{-- Administrator Khusus --}}
            @if ($admin?->isAdministrator())
                <div>
                    <p class="px-3 mb-2 text-[10px] font-bold tracking-wider text-amber-600 uppercase flex items-center gap-1.5">
                        <i data-lucide="shield" class="w-3 h-3 text-amber-500"></i>
                        <span>Administrator</span>
                    </p>
                    <div class="space-y-1.5">
                        @php $isOperators = request()->routeIs('admin.operators.*'); @endphp
                        <a href="{{ route('admin.operators.index') }}"
                           class="group flex items-center gap-3 px-3 py-2 rounded-xl text-xs sm:text-sm transition-all duration-200 {{ $isOperators ? 'bg-amber-600 text-gray-700 font-bold neu-card-sm' : 'text-slate-600 hover:text-slate-900 hover:neu-card-sm font-medium' }}">
                            <i data-lucide="user-cog" class="w-4 h-4 shrink-0 {{ $isOperators ? 'text-gray-700' : 'text-slate-500' }}"></i>
                            <span>Akun Operator</span>
                        </a>

                        @php $isLogs = request()->routeIs('admin.logs.*'); @endphp
                        <a href="{{ route('admin.logs.index') }}"
                           class="group flex items-center gap-3 px-3 py-2 rounded-xl text-xs sm:text-sm transition-all duration-200 {{ $isLogs ? 'bg-amber-600 text-gray-700 font-bold neu-card-sm' : 'text-slate-600 hover:text-slate-900 hover:neu-card-sm font-medium' }}">
                            <i data-lucide="history" class="w-4 h-4 shrink-0 {{ $isLogs ? 'text-gray-700' : 'text-slate-500' }}"></i>
                            <span>Log Aktivitas</span>
                        </a>
                    </div>
                </div>
            @endif

            {{-- Pengaturan & Web Publik --}}
            <div>
                <p class="px-3 mb-2 text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                    Pengaturan
                </p>
                <div class="space-y-1.5">
                    @php $isProfile = request()->routeIs('admin.profile.*'); @endphp
                    <a href="{{ route('admin.profile.index') }}"
                       class="group flex items-center gap-3 px-3 py-2 rounded-xl text-xs sm:text-sm transition-all duration-200 {{ $isProfile ? 'neu-primary font-bold' : 'text-slate-600 hover:text-slate-900 hover:neu-card-sm font-medium' }}">
                        <i data-lucide="user" class="w-4 h-4 shrink-0 {{ $isProfile ? 'text-white' : 'text-slate-500' }}"></i>
                        <span>Profil Saya</span>
                    </a>

                    <a href="{{ route('home') }}" target="_blank"
                       class="group flex items-center gap-3 px-3 py-2 rounded-xl text-xs sm:text-sm text-slate-500 hover:text-slate-900 hover:neu-card-sm transition-all duration-200 font-medium">
                        <i data-lucide="external-link" class="w-4 h-4 shrink-0 text-slate-400 group-hover:text-slate-600"></i>
                        <span>Lihat Web Publik</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

</div>
