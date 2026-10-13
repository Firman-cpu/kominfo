@php
    // Pastikan $errors tersedia meski di context non-web
    if (!isset($errors)) {
        $errors = new \Illuminate\Support\ViewErrorBag;
    }
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Profil Admin — PRAKERIN DISKOMINFO.">

    <title>Profile Admin — PRAKERIN</title>

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Pre-hide SEBELUM paint --}}
    <script>
        document.documentElement.classList.add('gsap-init');
    </script>

    <style>
        [x-cloak] { display: none !important; }

        html.gsap-init [data-anim] { opacity: 0; }

        @keyframes shimmer {
            0%   { background-position: 0% center; }
            100% { background-position: 200% center; }
        }
        .shimmer-text {
            background-size: 200% auto;
            animation: shimmer 6s linear infinite;
        }

        /* Orb pakai radial-gradient */
        .orb {
            will-change: transform;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
        }
        .orb-1 {
            background: radial-gradient(circle,
                rgba(14, 165, 233, 0.28) 0%,
                rgba(14, 165, 233, 0.14) 35%,
                rgba(14, 165, 233, 0.04) 60%,
                transparent 75%);
        }
        .orb-2 {
            background: radial-gradient(circle,
                rgba(34, 211, 238, 0.22) 0%,
                rgba(34, 211, 238, 0.1) 38%,
                rgba(34, 211, 238, 0.03) 62%,
                transparent 78%);
        }
        .orb-3 {
            background: radial-gradient(circle,
                rgba(139, 92, 246, 0.24) 0%,
                rgba(139, 92, 246, 0.1) 38%,
                rgba(139, 92, 246, 0.03) 62%,
                transparent 78%);
        }

        .stat-item,
        .profile-card,
        .form-card {
            will-change: transform;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
        }

        /* Avatar ring animation */
        @keyframes rotate-ring {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
        .avatar-ring {
            animation: rotate-ring 8s linear infinite;
        }

        /* Input field custom style */
        .field-input {
            background: rgba(15, 27, 44, 0.6);
            border: 1px solid rgba(186, 230, 253, 0.1);
            color: #e2e8f0;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .field-input:focus {
            outline: none;
            border-color: rgba(56, 189, 248, 0.4);
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.08);
        }
        .field-input::placeholder {
            color: rgba(148, 163, 184, 0.45);
        }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
</head>

<body class="min-h-screen overflow-x-hidden bg-[#0a1520] text-slate-100 antialiased selection:bg-sky-400/30">

    {{-- BACKGROUND — ICE + PURPLE ATMOSPHERE --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="orb orb-1 absolute -left-40 -top-40 h-[500px] w-[500px] rounded-full"></div>
        <div class="orb orb-2 absolute -right-40 top-[18%] h-[500px] w-[500px] rounded-full"></div>
        <div class="orb orb-3 absolute bottom-[-250px] left-[35%] h-[500px] w-[500px] rounded-full"></div>

        <div class="absolute inset-0 opacity-[0.05] [background-image:linear-gradient(rgba(186,230,253,1)_1px,transparent_1px),linear-gradient(90deg,rgba(186,230,253,1)_1px,transparent_1px)] [background-size:56px_56px] [mask-image:linear-gradient(to_bottom,black,transparent_70%)]"></div>

        <div class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2 bg-gradient-to-r from-transparent via-sky-400/60 to-transparent"></div>
    </div>


    <main class="relative mx-auto max-w-6xl px-4 pb-20 pt-12 sm:px-6 sm:pt-16 lg:px-8 lg:pb-28">

        {{-- BACK --}}
        <a
            data-anim
            href="{{ route('admin.dashboard.page') }}"
            class="group inline-flex items-center gap-2.5 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-4 py-2 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/40 hover:bg-sky-400/[0.14]"
        >
            <i data-lucide="arrow-left" class="h-3.5 w-3.5 text-sky-300 transition group-hover:-translate-x-0.5"></i>
            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                Kembali ke Dashboard
            </span>
        </a>


        {{-- HERO --}}
        <section class="mt-6">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div data-anim class="mb-6 inline-flex items-center gap-2 rounded-full border border-violet-400/20 bg-violet-400/[0.07] px-3 py-1.5">
                        <i data-lucide="user-cog" class="h-3.5 w-3.5 text-violet-300"></i>
                        <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-violet-200">
                            admin.profile
                        </span>
                    </div>

                    <h1 data-anim class="max-w-3xl text-5xl font-black leading-[0.9] tracking-[-0.055em] text-white sm:text-6xl lg:text-7xl">
                        PROFIL
                        <span class="shimmer-text mt-1 block bg-gradient-to-r from-violet-200 via-sky-200 to-cyan-300 bg-clip-text text-transparent">
                            ADMIN
                        </span>
                    </h1>

                    <p data-anim class="mt-6 max-w-xl text-sm leading-7 text-slate-400 sm:text-base">
                        Kelola informasi akun dan keamanan akses admin panel
                        PRAKERIN DISKOMINFO.
                    </p>
                </div>

                {{-- LOGOUT --}}
                <form data-anim action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="group inline-flex items-center gap-3 rounded-xl border border-red-400/25 bg-red-500/[0.08] px-4 py-3 text-xs font-bold uppercase tracking-[0.14em] text-red-200 transition duration-300 hover:-translate-y-0.5 hover:border-red-300/50 hover:bg-red-500/[0.15] hover:text-red-100"
                    >
                        <i data-lucide="log-out" class="h-4 w-4"></i>
                        Logout
                    </button>
                </form>
            </div>

            <div data-anim class="mt-8 h-px w-full bg-gradient-to-r from-violet-400/30 via-sky-300/10 to-transparent"></div>
        </section>


        {{-- SUCCESS ALERT --}}
        @if (session('success'))
            <div data-anim class="mt-6 flex items-center gap-3 rounded-xl border border-teal-400/25 bg-teal-500/[0.08] px-4 py-3.5 text-sm text-teal-200">
                <i data-lucide="check-circle-2" class="h-4 w-4 shrink-0 text-teal-300"></i>
                {{ session('success') }}
            </div>
        @endif


        <div class="mt-12 grid gap-8 lg:grid-cols-[360px_1fr]">

            {{-- LEFT — AVATAR CARD --}}
            <div class="flex flex-col gap-6">

                {{-- PROFILE CARD --}}
                <div data-anim class="profile-card relative overflow-hidden rounded-3xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-8 backdrop-blur-xl">

                    {{-- Decorative top line --}}
                    <div class="absolute left-0 right-0 top-0 h-px bg-gradient-to-r from-transparent via-violet-400/40 to-transparent"></div>

                    {{-- Avatar --}}
                    <div class="flex flex-col items-center gap-5">
                        <div class="relative">
                            {{-- Rotating gradient ring --}}
                            <div class="avatar-ring absolute inset-[-4px] rounded-full bg-gradient-to-br from-sky-400 via-violet-400 to-cyan-400 opacity-50"></div>
                            {{-- Mask inner circle --}}
                            <div class="absolute inset-[-1px] rounded-full bg-[#0a1520]"></div>
                            {{-- Avatar content --}}
                            <div class="relative flex h-28 w-28 items-center justify-center rounded-full border border-violet-300/20 bg-gradient-to-br from-violet-500/20 to-sky-500/20">
                                <span class="text-5xl font-black text-white/90 uppercase select-none">
                                    {{ strtoupper(substr($admin->username, 0, 1)) }}
                                </span>
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="text-xl font-bold text-white">{{ $admin->username }}</div>
                            <div class="mt-1 font-mono text-[10px] uppercase tracking-[0.18em] text-violet-300">Administrator</div>
                            <div class="mt-3 inline-flex items-center gap-1.5 rounded-full border border-teal-400/20 bg-teal-400/[0.08] px-3 py-1">
                                <span class="h-1.5 w-1.5 rounded-full bg-teal-300 animate-pulse"></span>
                                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.14em] text-teal-200">Session Active</span>
                            </div>
                        </div>
                    </div>

                    {{-- Admin Meta --}}
                    <div class="mt-8 space-y-3">
                        <div class="flex items-center gap-3 rounded-xl border border-sky-200/[0.08] bg-sky-400/[0.04] px-4 py-3">
                            <i data-lucide="shield" class="h-4 w-4 shrink-0 text-sky-300"></i>
                            <div>
                                <div class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500">Role</div>
                                <div class="text-xs font-semibold text-slate-200">Super Admin</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 rounded-xl border border-sky-200/[0.08] bg-sky-400/[0.04] px-4 py-3">
                            <i data-lucide="calendar" class="h-4 w-4 shrink-0 text-sky-300"></i>
                            <div>
                                <div class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500">Member Since</div>
                                <div class="text-xs font-semibold text-slate-200">{{ $admin->created_at ? $admin->created_at->format('d M Y') : '-' }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 rounded-xl border border-sky-200/[0.08] bg-sky-400/[0.04] px-4 py-3">
                            <i data-lucide="database" class="h-4 w-4 shrink-0 text-sky-300"></i>
                            <div>
                                <div class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500">Admin ID</div>
                                <div class="font-mono text-xs font-semibold text-slate-200">#{{ str_pad($admin->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- STATS CARD --}}
                <div data-anim class="profile-card overflow-hidden rounded-3xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 backdrop-blur-xl">
                    <div class="border-b border-sky-200/[0.06] px-6 py-4">
                        <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                            system.stats
                        </span>
                    </div>
                    <div class="space-y-0 divide-y divide-sky-200/[0.05]">

                        <div class="stat-item flex items-center justify-between px-6 py-4 transition duration-200 hover:bg-sky-400/[0.03]">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg border border-sky-300/15 bg-sky-300/[0.08]">
                                    <i data-lucide="users-round" class="h-4 w-4 text-sky-300"></i>
                                </div>
                                <span class="text-xs text-slate-400">Total Siswa</span>
                            </div>
                            <span class="font-mono text-sm font-bold text-white" data-counter="{{ $totalStudents }}">{{ $totalStudents }}</span>
                        </div>

                        <div class="stat-item flex items-center justify-between px-6 py-4 transition duration-200 hover:bg-sky-400/[0.03]">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg border border-teal-300/15 bg-teal-300/[0.08]">
                                    <i data-lucide="activity" class="h-4 w-4 text-teal-300"></i>
                                </div>
                                <span class="text-xs text-slate-400">Siswa Aktif</span>
                            </div>
                            <span class="font-mono text-sm font-bold text-white" data-counter="{{ $activeStudents }}">{{ $activeStudents }}</span>
                        </div>

                        <div class="stat-item flex items-center justify-between px-6 py-4 transition duration-200 hover:bg-sky-400/[0.03]">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg border border-emerald-300/15 bg-emerald-300/[0.08]">
                                    <i data-lucide="check-check" class="h-4 w-4 text-emerald-300"></i>
                                </div>
                                <span class="text-xs text-slate-400">Selesai PKL</span>
                            </div>
                            <span class="font-mono text-sm font-bold text-white" data-counter="{{ $completedStudents }}">{{ $completedStudents }}</span>
                        </div>

                        <div class="stat-item flex items-center justify-between px-6 py-4 transition duration-200 hover:bg-sky-400/[0.03]">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg border border-cyan-300/15 bg-cyan-300/[0.08]">
                                    <i data-lucide="clipboard-check" class="h-4 w-4 text-cyan-300"></i>
                                </div>
                                <span class="text-xs text-slate-400">Total Penilaian</span>
                            </div>
                            <span class="font-mono text-sm font-bold text-white" data-counter="{{ $totalAssessments }}">{{ $totalAssessments }}</span>
                        </div>

                    </div>
                </div>

            </div>


            {{-- RIGHT — EDIT FORM --}}
            <div class="flex flex-col gap-6">

                {{-- EDIT PROFILE --}}
                <div data-anim class="form-card relative overflow-hidden rounded-3xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 backdrop-blur-xl">
                    <div class="absolute left-0 right-0 top-0 h-px bg-gradient-to-r from-transparent via-sky-400/30 to-transparent"></div>

                    <div class="border-b border-sky-200/[0.06] px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-sky-300/15 bg-sky-300/[0.08]">
                                <i data-lucide="user-pen" class="h-4 w-4 text-sky-300"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-white text-sm">Edit Profil</div>
                                <div class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500">account.settings</div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.profile.update') }}" method="POST" class="px-6 py-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-5">

                            {{-- Username --}}
                            <div>
                                <label for="username" class="mb-2 block font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-400">
                                    Username
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                        <i data-lucide="at-sign" class="h-4 w-4 text-slate-500"></i>
                                    </div>
                                    <input
                                        id="username"
                                        type="text"
                                        name="username"
                                        value="{{ old('username', $admin->username) }}"
                                        class="field-input w-full rounded-xl py-3 pl-10 pr-4 text-sm"
                                        placeholder="username admin"
                                        autocomplete="username"
                                    >
                                </div>
                                @error('username')
                                    <p class="mt-1.5 font-mono text-[10px] text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Divider --}}
                            <div class="flex items-center gap-3">
                                <div class="h-px flex-1 bg-sky-200/[0.07]"></div>
                                <span class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-600">Ubah Password</span>
                                <div class="h-px flex-1 bg-sky-200/[0.07]"></div>
                            </div>

                            {{-- Current Password --}}
                            <div>
                                <label for="current_password" class="mb-2 block font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-400">
                                    Password Saat Ini
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                        <i data-lucide="lock-keyhole" class="h-4 w-4 text-slate-500"></i>
                                    </div>
                                    <input
                                        id="current_password"
                                        type="password"
                                        name="current_password"
                                        class="field-input w-full rounded-xl py-3 pl-10 pr-4 text-sm"
                                        placeholder="kosongkan jika tidak ingin ubah password"
                                        autocomplete="current-password"
                                    >
                                </div>
                                @error('current_password')
                                    <p class="mt-1.5 font-mono text-[10px] text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div>
                                <label for="new_password" class="mb-2 block font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-400">
                                    Password Baru
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                        <i data-lucide="lock-keyhole-open" class="h-4 w-4 text-slate-500"></i>
                                    </div>
                                    <input
                                        id="new_password"
                                        type="password"
                                        name="new_password"
                                        class="field-input w-full rounded-xl py-3 pl-10 pr-4 text-sm"
                                        placeholder="min. 6 karakter"
                                        autocomplete="new-password"
                                    >
                                </div>
                                @error('new_password')
                                    <p class="mt-1.5 font-mono text-[10px] text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Confirm New Password --}}
                            <div>
                                <label for="new_password_confirmation" class="mb-2 block font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-400">
                                    Konfirmasi Password Baru
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                        <i data-lucide="shield-check" class="h-4 w-4 text-slate-500"></i>
                                    </div>
                                    <input
                                        id="new_password_confirmation"
                                        type="password"
                                        name="new_password_confirmation"
                                        class="field-input w-full rounded-xl py-3 pl-10 pr-4 text-sm"
                                        placeholder="ulangi password baru"
                                        autocomplete="new-password"
                                    >
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="pt-2">
                                <button
                                    type="submit"
                                    id="btn-save-profile"
                                    class="group inline-flex w-full items-center justify-center gap-3 rounded-xl border border-sky-400/25 bg-sky-500/[0.12] py-3.5 text-xs font-bold uppercase tracking-[0.14em] text-sky-200 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/50 hover:bg-sky-500/[0.2] hover:text-sky-100"
                                >
                                    <i data-lucide="save" class="h-4 w-4 transition group-hover:scale-110"></i>
                                    Simpan Perubahan
                                </button>
                            </div>

                        </div>
                    </form>
                </div>


                {{-- QUICK LINKS --}}
                <div data-anim class="form-card overflow-hidden rounded-3xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 backdrop-blur-xl">
                    <div class="border-b border-sky-200/[0.06] px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-violet-300/15 bg-violet-300/[0.08]">
                                <i data-lucide="layout-grid" class="h-4 w-4 text-violet-300"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-white text-sm">Panel Navigasi</div>
                                <div class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500">admin.controls</div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3 p-6 sm:grid-cols-3">

                        <a href="{{ route('admin.dashboard.page') }}"
                           class="group flex flex-col items-center gap-3 rounded-2xl border border-sky-200/[0.1] bg-sky-400/[0.04] p-4 text-center transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/25 hover:bg-sky-400/[0.1]">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-sky-300/15 bg-sky-300/[0.08] transition group-hover:scale-110">
                                <i data-lucide="layout-dashboard" class="h-5 w-5 text-sky-300"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-white">Dashboard</div>
                                <div class="mt-0.5 font-mono text-[8px] uppercase tracking-[0.12em] text-slate-500">/admin/dashboard</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.analytics.index') }}"
                           class="group flex flex-col items-center gap-3 rounded-2xl border border-sky-200/[0.1] bg-sky-400/[0.04] p-4 text-center transition duration-300 hover:-translate-y-0.5 hover:border-cyan-300/25 hover:bg-cyan-400/[0.1]">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-cyan-300/15 bg-cyan-300/[0.08] transition group-hover:scale-110">
                                <i data-lucide="chart-no-axes-combined" class="h-5 w-5 text-cyan-300"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-white">Analytics</div>
                                <div class="mt-0.5 font-mono text-[8px] uppercase tracking-[0.12em] text-slate-500">/admin/analytics</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.students.index') }}"
                           class="group flex flex-col items-center gap-3 rounded-2xl border border-sky-200/[0.1] bg-sky-400/[0.04] p-4 text-center transition duration-300 hover:-translate-y-0.5 hover:border-teal-300/25 hover:bg-teal-400/[0.1]">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-teal-300/15 bg-teal-300/[0.08] transition group-hover:scale-110">
                                <i data-lucide="database" class="h-5 w-5 text-teal-300"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-white">Siswa</div>
                                <div class="mt-0.5 font-mono text-[8px] uppercase tracking-[0.12em] text-slate-500">/admin/students</div>
                            </div>
                        </a>

                    </div>
                </div>

            </div>

        </div>


        {{-- FOOTER --}}
        <div data-anim class="mt-14 flex items-center justify-center gap-3 font-mono text-[9px] text-slate-600">
            <span class="text-violet-300">●</span>
            admin.profile
            <span class="text-slate-700">/</span>
            <span class="text-sky-300/80">{{ $admin->username }}</span>
        </div>

    </main>


    {{-- SCRIPT —— ICONS + ANIMATIONS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        var root = document.documentElement;

        /* ICONS */
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
        }

        /* FALLBACK kalau GSAP tidak ada */
        if (!window.gsap) {
            root.classList.remove('gsap-init');
            return;
        }

        gsap.config({ force3D: true });
        gsap.ticker.lagSmoothing(500, 33);

        try {
            var tl = gsap.timeline({
                defaults: { ease: 'power3.out', clearProps: 'transform,opacity' }
            });

            tl.from('[data-anim]', {
                y: 24,
                opacity: 0,
                duration: 0.65,
                stagger: { each: 0.05, from: 'start' }
            });

            root.classList.remove('gsap-init');

            /* AMBIENT ORB */
            gsap.to('.orb-1', { x: 40,  y: 30,  duration: 14, repeat: -1, yoyo: true, ease: 'sine.inOut' });
            gsap.to('.orb-2', { x: -30, y: 40,  duration: 16, repeat: -1, yoyo: true, ease: 'sine.inOut' });
            gsap.to('.orb-3', { x: 20,  y: -30, duration: 18, repeat: -1, yoyo: true, ease: 'sine.inOut' });

            /* COUNTERS */
            document.querySelectorAll('[data-counter]').forEach(function (el) {
                var target   = parseInt(el.dataset.counter, 10) || 0;
                var start    = null;
                var duration = 1200;

                function step(ts) {
                    if (!start) start = ts;
                    var p      = Math.min((ts - start) / duration, 1);
                    var eased  = 1 - Math.pow(1 - p, 3);
                    el.textContent = Math.round(target * eased);
                    if (p < 1) requestAnimationFrame(step);
                    else el.textContent = target;
                }
                requestAnimationFrame(step);
            });

        } catch (err) {
            console.warn('[gsap] animation error', err);
            root.classList.remove('gsap-init');
        }

        /* SAFETY NET */
        window.setTimeout(function () {
            root.classList.remove('gsap-init');
            document.querySelectorAll('[data-anim]').forEach(function (el) {
                if (getComputedStyle(el).opacity === '0') {
                    el.style.opacity = '';
                    el.style.transform = '';
                }
            });
        }, 1500);

    });
    </script>

</body>

</html>
