<!DOCTYPE html>
<html lang="id" class="h-full bg-[#ebf0f7]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') — PRAKERIN DISKOMINFO</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Anti-FOUC for Alpine x-cloak --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    {{-- Application Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body
    class="h-full overflow-hidden antialiased select-none font-sans bg-[#ebf0f7] text-slate-800"
    x-data="adminGlobalSearch()"
    x-init="init()"
    @keydown.window="if (($event.metaKey || $event.ctrlKey) && ($event.key === 'k' || $event.key === 'K')) { $event.preventDefault(); openSearchModal(); }"
    @keydown.escape.window="mobileMenuOpen = false; closeSearchModal()"
>
    <div class="flex h-screen w-full overflow-hidden bg-[#ebf0f7]">

        {{-- =====================================================
             DESKTOP SIDEBAR (NEUMORPHIC DOCKED)
        ====================================================== --}}
        <aside class="hidden md:flex fixed inset-y-0 left-0 z-40 w-64 flex-col bg-[#ebf0f7] shadow-[4px_0_16px_#c5d0de]">
            @include('components.admin.sidebar')
        </aside>


        {{-- =====================================================
             MOBILE SIDEBAR DRAWER
        ====================================================== --}}
        <div
            x-cloak
            x-show="mobileMenuOpen"
            style="display: none;"
            class="fixed inset-0 z-50 md:hidden"
            role="dialog"
            aria-modal="true"
            aria-label="Navigasi Utama"
        >
            {{-- Backdrop --}}
            <div
                class="fixed inset-0 bg-slate-900/30 backdrop-blur-xs transition-opacity"
                x-show="mobileMenuOpen"
                style="display: none;"
                x-transition:enter="ease-out duration-250"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="mobileMenuOpen = false"
            ></div>

            {{-- Drawer Panel --}}
            <div
                class="fixed inset-y-0 left-0 flex w-72 max-w-[85vw] flex-col bg-[#ebf0f7] shadow-[8px_0_24px_#c5d0de]"
                x-show="mobileMenuOpen"
                style="display: none;"
                x-transition:enter="transform ease-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform ease-in duration-200"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
            >
                @include('components.admin.sidebar')
            </div>
        </div>


        {{-- =====================================================
             MAIN CONTENT LAYOUT (OFFSET BY FIXED SIDEBAR)
        ====================================================== --}}
        <div class="flex flex-1 flex-col overflow-hidden md:pl-64">

            {{-- Global Neumorphic Topbar --}}
            <header class="sticky top-0 z-30 shrink-0">
                @include('components.admin.topbar', [
                    'title' => trim($__env->yieldContent('page-title', 'Dashboard')),
                    'subtitle' => trim($__env->yieldContent('page-subtitle', 'Panel Pengelolaan Data PRAKERIN & Magang'))
                ])
            </header>


            {{-- =================================================
                 MAIN SCROLLABLE WORKSPACE
            ================================================== --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#ebf0f7]">
                <div class="mx-auto w-full max-w-[1560px] p-4 sm:p-6 lg:p-8">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>


    {{-- =========================================================
         GLOBAL INTERACTIVE SEARCH MODAL (⌘K / Ctrl+K)
    ========================================================== --}}
    <div
        x-cloak
        x-show="searchModalOpen"
        style="display: none;"
        class="fixed inset-0 z-50 overflow-y-auto p-4 sm:p-6 md:p-12 lg:p-20"
        role="dialog"
        aria-modal="true"
        aria-label="Pencarian Cepat"
    >
        {{-- Backdrop --}}
        <div
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs transition-opacity"
            x-show="searchModalOpen"
            style="display: none;"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="closeSearchModal()"
        ></div>

        {{-- Neumorphic Dialog Panel --}}
        <div
            class="relative mx-auto max-w-2xl transform overflow-hidden rounded-3xl bg-[#ebf0f7] shadow-[14px_14px_32px_#c5d0de,-14px_-14px_32px_#ffffff] p-5 sm:p-6 transition-all border border-white/80"
            x-show="searchModalOpen"
            style="display: none;"
            x-transition:enter="ease-out duration-250"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            {{-- Recessed Search Input Box --}}
            <div class="flex items-center rounded-2xl neu-inset px-4 py-3">
                <div class="w-5 h-5 flex items-center justify-center shrink-0 mr-1.5">
                    {{-- Spinner saat loading --}}
                    <svg x-show="searchLoading" class="w-5 h-5 text-blue-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{-- Search Icon SVG tetap (tidak akan bertambah / terduplikasi) --}}
                    <svg x-show="!searchLoading" class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                </div>

                <input
                    x-ref="searchInput"
                    x-model="searchKeyword"
                    @input.debounce.250ms="onSearchInput()"
                    type="text"
                    placeholder="Ketik nama sekolah, nama siswa, NIS/NIM, atau fitur dashboard..."
                    class="w-full border-0 bg-transparent px-2.5 text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0"
                >

                <button
                    type="button"
                    x-show="searchKeyword.length > 0"
                    style="display: none;"
                    @click="searchKeyword = ''; onSearchInput(); $refs.searchInput?.focus()"
                    class="p-1 rounded-lg text-slate-400 hover:text-slate-600 transition-colors mr-1 cursor-pointer"
                    title="Hapus pencarian"
                >
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>

                <button
                    type="button"
                    @click="closeSearchModal()"
                    class="rounded-lg p-1 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer"
                    aria-label="Tutup pencarian"
                >
                    <kbd class="text-[10px] font-bold neu-card-sm text-slate-500 rounded px-2 py-0.5">ESC</kbd>
                </button>
            </div>

            {{-- Search Results Body --}}
            <div class="mt-4 max-h-[60vh] overflow-y-auto px-1 py-1 space-y-4">

                {{-- 1. KATEGORI ASAL SEKOLAH / KAMPUS --}}
                <template x-if="searchResults.institutions && searchResults.institutions.length > 0">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21.42 10.922a1 1 0 0 0-.019-.838L12.83 2.18a2 2 0 0 0-1.66 0L2.6 10.08a1 1 0 0 0 0 1.832l8.57 7.908a2 2 0 0 0 1.66 0l8.57-7.9a1 1 0 0 0 .02-.998z"></path>
                                    <path d="M22 10v6"></path>
                                    <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
                                </svg>
                                <span>Asal Sekolah / Lembaga Pendidikan</span>
                            </span>
                            <span class="text-[10px] text-blue-600 lowercase font-bold" x-text="searchResults.institutions.length + ' sekolah terdaftar'"></span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <template x-for="inst in searchResults.institutions" :key="inst.name">
                                <a :href="inst.url"
                                   @click="closeSearchModal()"
                                   class="neu-card-sm p-3 rounded-2xl flex items-center justify-between hover:bg-[#e4e9f2] transition-all cursor-pointer group border border-white/70">
                                    <div class="flex items-center gap-2.5 min-w-0 pr-2">
                                        <div class="neu-card-sm w-7 h-7 rounded-xl flex items-center justify-center text-blue-600 shrink-0 group-hover:scale-105 transition-transform">
                                            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect>
                                                <path d="M9 22v-4h6v4"></path>
                                                <path d="M8 6h.01"></path>
                                                <path d="M16 6h.01"></path>
                                                <path d="M12 6h.01"></path>
                                                <path d="M12 10h.01"></path>
                                                <path d="M12 14h.01"></path>
                                                <path d="M16 10h.01"></path>
                                                <path d="M16 14h.01"></path>
                                                <path d="M8 10h.01"></path>
                                                <path d="M8 14h.01"></path>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-bold text-slate-800 truncate group-hover:text-blue-600 transition-colors" x-text="inst.name"></span>
                                    </div>
                                    <span class="neu-inset-sm px-2 py-0.5 rounded-lg text-[10px] font-extrabold text-blue-700 font-mono shrink-0" x-text="inst.count + ' Peserta'"></span>
                                </a>
                            </template>
                        </div>
                    </div>
                </template>

                {{-- 2. KATEGORI FITUR & MODUL DASHBOARD --}}
                <template x-if="searchResults.features && searchResults.features.length > 0">
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="7" height="7" x="3" y="3" rx="1"></rect>
                                    <rect width="7" height="7" x="14" y="3" rx="1"></rect>
                                    <rect width="7" height="7" x="14" y="14" rx="1"></rect>
                                    <rect width="7" height="7" x="3" y="14" rx="1"></rect>
                                </svg>
                                <span>Fitur & Modul Dashboard</span>
                            </span>
                            <span class="text-[10px] text-indigo-600 font-bold" x-text="searchResults.features.length + ' fitur'"></span>
                        </div>

                        <div class="space-y-1.5">
                            <template x-for="feat in searchResults.features" :key="feat.url + feat.title">
                                <a :href="feat.url"
                                   @click="closeSearchModal()"
                                   class="neu-card-sm p-3 rounded-2xl flex items-center justify-between hover:bg-[#e4e9f2] transition-all cursor-pointer group border border-white/60">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="neu-card-sm w-8 h-8 rounded-xl flex items-center justify-center text-blue-600 shrink-0 group-hover:scale-105 transition-transform" x-html="feat.svg"></div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition-colors" x-text="feat.title"></span>
                                                <span class="text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md neu-inset-sm text-slate-500" x-text="feat.category"></span>
                                            </div>
                                            <p class="text-[11px] text-slate-500 truncate mt-0.5" x-text="feat.description"></p>
                                        </div>
                                    </div>
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-0.5 transition-all shrink-0 ml-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </a>
                            </template>
                        </div>
                    </div>
                </template>

                {{-- 3. KATEGORI DATA SISWA / MAHASISWA --}}
                <template x-if="searchResults.students && searchResults.students.length > 0">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <span>Peserta Prakerin & Magang</span>
                            </span>
                            <span class="text-[10px] text-emerald-600 lowercase font-bold" x-text="searchResults.students.length + ' peserta'"></span>
                        </div>

                        <div class="space-y-1.5">
                            <template x-for="st in searchResults.students" :key="st.id">
                                <a :href="st.url"
                                   @click="closeSearchModal()"
                                   class="neu-card-sm p-3 rounded-2xl flex items-center justify-between hover:bg-[#e4e9f2] transition-all cursor-pointer group border border-white/60">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="neu-card-sm w-9 h-9 rounded-xl overflow-hidden p-0.5 shrink-0">
                                            <img :src="st.photo_url" :alt="st.name" class="w-full h-full object-cover rounded-[10px]">
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition-colors" x-text="st.name"></span>
                                                <span class="text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md neu-inset-sm"
                                                      :class="st.type === 'magang' ? 'text-indigo-700' : 'text-blue-700'"
                                                      x-text="st.type_label"></span>
                                            </div>
                                            <p class="text-[11px] text-slate-500 font-mono truncate mt-0.5">
                                                <span class="font-bold text-slate-700" x-text="st.institution"></span> &bull;
                                                <span x-text="st.major"></span> &bull;
                                                <span>Bidang: <span x-text="st.department_name"></span></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0 ml-2">
                                        <span class="neu-btn px-2.5 py-1 rounded-xl text-[10px] font-bold text-blue-600">
                                            Profil
                                        </span>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>
                </template>

                {{-- EMPTY STATE --}}
                <template x-if="!searchLoading && searchKeyword.trim().length > 0 && (!searchResults.features || searchResults.features.length === 0) && (!searchResults.institutions || searchResults.institutions.length === 0) && (!searchResults.students || searchResults.students.length === 0)">
                    <div class="neu-card-sm p-8 rounded-3xl text-center space-y-2 border border-white/80">
                        <div class="neu-inset-sm w-12 h-12 rounded-2xl flex items-center justify-center text-slate-400 mx-auto mb-2">
                            <svg class="w-6 h-6 text-slate-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                                <line x1="8" x2="14" y1="8" y2="14"></line>
                                <line x1="14" x2="8" y1="8" y2="14"></line>
                            </svg>
                        </div>
                        <h4 class="text-xs font-bold text-slate-800">Tidak ada hasil ditemukan</h4>
                        <p class="text-[11px] text-slate-500 max-w-sm mx-auto">
                            Tidak ditemukan kecocokan untuk kata kunci "<span class="font-bold text-slate-700" x-text="searchKeyword"></span>".
                            Coba ketikkan nama sekolah (contoh: <span class="font-mono text-blue-600">SMKN 1</span>, <span class="font-mono text-blue-600">Universitas</span>) atau modul (contoh: <span class="font-mono text-blue-600">nilai</span>, <span class="font-mono text-blue-600">ekspor</span>).
                        </p>
                    </div>
                </template>

            </div>

            {{-- Footer Helper Keys --}}
            <div class="mt-4 pt-3 border-t border-slate-200/70 flex items-center justify-between text-[11px] text-slate-400">
                <div class="flex items-center gap-3">
                    <span class="flex items-center gap-1">
                        <kbd class="neu-card-sm px-1.5 py-0.5 rounded text-[9px] font-bold text-slate-500">↵</kbd>
                        <span>buka hasil</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <kbd class="neu-card-sm px-1.5 py-0.5 rounded text-[9px] font-bold text-slate-500">ESC</kbd>
                        <span>tutup</span>
                    </span>
                </div>
                <span class="text-[10px] font-semibold text-slate-400">Cari Sekolah, Siswa & Fitur</span>
            </div>
        </div>
    </div>


    {{-- Flash Notifications --}}
    @include('components.admin.flash')

    {{-- Page Scripts --}}
    @stack('scripts')

    <script>
        function adminGlobalSearch() {
            return {
                mobileMenuOpen: false,
                searchModalOpen: false,
                searchKeyword: '',
                searchLoading: false,
                searchResults: {
                    features: [],
                    institutions: [],
                    students: []
                },
                init() {
                    // Pre-fetch default shortcuts so they are immediately available
                    this.fetchResults('');
                },
                openSearchModal() {
                    this.searchModalOpen = true;
                    this.$nextTick(() => {
                        this.$refs.searchInput?.focus();
                        this.$refs.searchInput?.select();
                    });
                },
                closeSearchModal() {
                    this.searchModalOpen = false;
                },
                onSearchInput() {
                    this.fetchResults(this.searchKeyword);
                },
                fetchResults(query) {
                    this.searchLoading = true;
                    const url = `{{ route('admin.quick-search') }}?q=${encodeURIComponent(query || '')}`;

                    fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.searchResults = data;
                        this.searchLoading = false;
                    })
                    .catch(err => {
                        console.error('Pencarian cepat gagal:', err);
                        this.searchLoading = false;
                    });
                }
            };
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof window.initLucide === 'function') {
                window.initLucide();
            }
        });
    </script>
</body>
</html>
