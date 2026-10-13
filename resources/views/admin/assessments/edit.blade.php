<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f5f7fa">

    <title>Edit Penilaian — PRAKERIN DISKOMINFO PACITAN</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
</head>

<body class="min-h-screen bg-[#f5f7fa] text-[#263449] antialiased selection:bg-[#dce8f7] selection:text-[#243f63]">

    {{-- Ambient background --}}
    <div class="pointer-events-none fixed inset-0 -z-0 overflow-hidden" aria-hidden="true">
        <div class="absolute -right-40 -top-40 h-[420px] w-[420px] rounded-full bg-blue-200/25 blur-3xl"></div>
        <div class="absolute -bottom-48 -left-40 h-[420px] w-[420px] rounded-full bg-slate-300/25 blur-3xl"></div>
        <div class="absolute inset-0 bg-[linear-gradient(rgba(54,91,136,0.025)_1px,transparent_1px),linear-gradient(90deg,rgba(54,91,136,0.025)_1px,transparent_1px)] bg-[size:32px_32px]"></div>
    </div>

    <div class="relative z-10 min-h-screen">

        {{-- Navbar --}}
        <header class="sticky top-0 z-40 border-b border-[#e0e7f0]/90 bg-white/85 backdrop-blur-xl">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4 sm:px-8 lg:px-10">

                <a href="{{ route('admin.dashboard.page') }}"
                   class="group flex min-w-0 items-center gap-3"
                   aria-label="Kembali ke dashboard">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#243f63] text-white shadow-lg shadow-[#243f63]/15 transition duration-300 group-hover:-rotate-3 group-hover:scale-105">
                        <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="truncate text-sm font-extrabold tracking-tight text-[#243f63] sm:text-base">
                            PRAKERIN
                        </p>
                        <p class="truncate text-[10px] font-semibold uppercase tracking-[0.16em] text-[#718096] sm:text-xs">
                            DISKOMINFO PACITAN
                        </p>
                    </div>
                </a>

                <a href="{{ route('admin.assessments.index') }}"
                   class="inline-flex shrink-0 items-center gap-2 rounded-xl border border-[#e0e7f0] bg-white px-3.5 py-2.5 text-sm font-semibold text-[#53657d] shadow-sm transition duration-200 hover:border-[#c7d6e8] hover:bg-[#f7f9fc] hover:text-[#243f63] sm:px-4">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    <span class="hidden sm:inline">Kembali ke Penilaian</span>
                    <span class="sm:hidden">Kembali</span>
                </a>

            </div>
        </header>

        <main class="mx-auto max-w-7xl px-5 py-8 sm:px-8 sm:py-10 lg:px-10">

            {{-- Breadcrumb --}}
            <nav data-anim aria-label="Breadcrumb" class="mb-7 flex flex-wrap items-center gap-2 text-xs font-medium text-[#718096] sm:text-sm">
                <a href="{{ route('admin.dashboard.page') }}" class="transition hover:text-[#243f63]">
                    Dashboard
                </a>
                <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
                <a href="{{ route('admin.assessments.index') }}" class="transition hover:text-[#243f63]">
                    Penilaian Siswa
                </a>
                <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
                <span class="font-semibold text-[#365b88]">Edit Penilaian</span>
            </nav>

            {{-- Page heading --}}
            <section data-anim class="mb-8 flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                <div class="max-w-2xl">
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-[#dce6f2] bg-white/80 px-3 py-1.5 text-xs font-bold text-[#365b88] shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#416b9e]"></span>
                        MANAJEMEN AKADEMIK
                    </div>

                    <h1 class="text-3xl font-black tracking-tight text-[#243f63] sm:text-4xl lg:text-[42px]">
                        Edit Penilaian
                    </h1>

                    <p class="mt-3 max-w-xl text-sm leading-6 text-[#718096] sm:text-base">
                        Perbarui data siswa, nilai kompetensi, dan catatan evaluasi selama pelaksanaan Praktik Kerja Lapangan.
                    </p>
                </div>

                <div class="flex items-center gap-3 rounded-2xl border border-[#e0e7f0] bg-white/80 p-4 shadow-sm">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf3fa] text-[#365b88]">
                        <i data-lucide="clipboard-check" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-[#718096]">Formulir</p>
                        <p class="mt-0.5 text-sm font-bold text-[#243f63]">Perubahan Penilaian</p>
                    </div>
                </div>
            </section>

            {{-- Validation errors --}}
            @if ($errors->any())
                <section data-anim role="alert" class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                            <i data-lucide="alert-circle" class="h-5 w-5"></i>
                        </div>

                        <div class="min-w-0">
                            <h2 class="font-bold text-red-800">Ada kesalahan pada formulir</h2>
                            <p class="mt-1 text-sm text-red-700">
                                Periksa kembali data berikut sebelum menyimpan perubahan.
                            </p>

                            <ul class="mt-3 space-y-1.5 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start gap-2">
                                        <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-red-500"></span>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </section>
            @endif

            {{-- Form layout --}}
            <form
                id="assessment-form"
                action="{{ route('admin.assessments.update', $assessment) }}"
                method="POST"
                class="space-y-6"
            >
                @csrf
                @method('PUT')

                {{-- Student information --}}
                <section data-anim class="overflow-hidden rounded-3xl border border-[#e0e7f0] bg-white shadow-[0_8px_32px_rgba(36,63,99,0.045)]">

                    <div class="flex items-center gap-4 border-b border-[#e9eef5] px-5 py-5 sm:px-7">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#edf3fa] text-[#365b88]">
                            <i data-lucide="user-round" class="h-5 w-5"></i>
                        </div>

                        <div>
                            <h2 class="font-bold text-[#243f63] sm:text-lg">Informasi Siswa</h2>
                            <p class="mt-1 text-xs text-[#718096] sm:text-sm">
                                Pilih siswa dan tentukan tanggal penilaian.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-6 p-5 sm:grid-cols-2 sm:p-7">

                        {{-- Student --}}
                        <div class="sm:col-span-2">
                            <label for="student_id" class="mb-2 block text-sm font-bold text-[#344761]">
                                Siswa
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <i data-lucide="users" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8b9bb0]"></i>

                                <select
                                    name="student_id"
                                    id="student_id"
                                    required
                                    class="w-full appearance-none rounded-xl border border-[#dce4ee] bg-[#fbfcfe] py-3.5 pl-11 pr-11 text-sm font-medium text-[#344761] outline-none transition duration-200 hover:border-[#bdcde0] focus:border-[#416b9e] focus:bg-white focus:ring-4 focus:ring-[#416b9e]/10"
                                >
                                    @foreach ($students as $student)
                                        <option
                                            value="{{ $student->id }}"
                                            {{ old('student_id', $assessment->student_id) == $student->id ? 'selected' : '' }}
                                        >
                                            {{ $student->name }} — {{ $student->nis }}
                                        </option>
                                    @endforeach
                                </select>

                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8b9bb0]"></i>
                            </div>

                            @error('student_id')
                                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Date --}}
                        <div>
                            <label for="assessment_date" class="mb-2 block text-sm font-bold text-[#344761]">
                                Tanggal Penilaian
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <i data-lucide="calendar-days" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8b9bb0]"></i>

                                <input
                                    type="date"
                                    name="assessment_date"
                                    id="assessment_date"
                                    value="{{ old('assessment_date', $assessment->assessment_date->format('Y-m-d')) }}"
                                    required
                                    class="w-full rounded-xl border border-[#dce4ee] bg-[#fbfcfe] py-3.5 pl-11 pr-4 text-sm font-medium text-[#344761] outline-none transition duration-200 hover:border-[#bdcde0] focus:border-[#416b9e] focus:bg-white focus:ring-4 focus:ring-[#416b9e]/10"
                                >
                            </div>

                            @error('assessment_date')
                                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Information --}}
                        <div class="flex items-start gap-3 rounded-xl border border-[#e3ebf5] bg-[#f7f9fc] p-4">
                            <i data-lucide="info" class="mt-0.5 h-4 w-4 shrink-0 text-[#416b9e]"></i>
                            <p class="text-xs leading-5 text-[#718096]">
                                Pastikan siswa yang dipilih sudah sesuai dengan data peserta PRAKERIN yang akan dinilai.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Assessment scores --}}
                <section data-anim class="overflow-hidden rounded-3xl border border-[#e0e7f0] bg-white shadow-[0_8px_32px_rgba(36,63,99,0.045)]">

                    <div class="flex items-center gap-4 border-b border-[#e9eef5] px-5 py-5 sm:px-7">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#edf3fa] text-[#365b88]">
                            <i data-lucide="chart-no-axes-column-increasing" class="h-5 w-5"></i>
                        </div>

                        <div>
                            <h2 class="font-bold text-[#243f63] sm:text-lg">Nilai Kompetensi</h2>
                            <p class="mt-1 text-xs text-[#718096] sm:text-sm">
                                Masukkan skor untuk setiap aspek penilaian.
                            </p>
                        </div>

                        <div class="ml-auto hidden rounded-lg bg-[#f0f4f9] px-3 py-2 text-xs font-bold text-[#536d8d] sm:block">
                            Skala 0–100
                        </div>
                    </div>

                    <div class="p-5 sm:p-7">
                        <div class="mb-6 flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50/70 p-4">
                            <i data-lucide="lightbulb" class="mt-0.5 h-4 w-4 shrink-0 text-[#416b9e]"></i>
                            <p class="text-xs leading-5 text-[#536d8d] sm:text-sm">
                                Gunakan nilai antara <strong>0 sampai 100</strong> berdasarkan hasil pengamatan dan evaluasi siswa selama PRAKERIN.
                            </p>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                            {{-- Discipline --}}
                            <div class="score-field rounded-2xl border border-[#e6ecf3] bg-[#fbfcfe] p-4 transition duration-200 hover:border-[#c8d7e8] hover:bg-white">
                                <label for="discipline" class="mb-3 flex items-center gap-2.5 text-sm font-bold text-[#344761]">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                                        <i data-lucide="clock-3" class="h-4 w-4"></i>
                                    </span>
                                    Kedisiplinan
                                </label>

                                <div class="relative">
                                    <input
                                        type="number"
                                        name="discipline"
                                        id="discipline"
                                        min="0"
                                        max="100"
                                        step="1"
                                        value="{{ old('discipline', $assessment->discipline) }}"
                                        required
                                        inputmode="numeric"
                                        class="score-input w-full rounded-xl border border-[#dce4ee] bg-white px-4 py-3 pr-14 text-lg font-extrabold tabular-nums text-[#243f63] outline-none transition focus:border-[#416b9e] focus:ring-4 focus:ring-[#416b9e]/10"
                                    >
                                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-[#8b9bb0]">/ 100</span>
                                </div>

                                @error('discipline')
                                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Responsibility --}}
                            <div class="score-field rounded-2xl border border-[#e6ecf3] bg-[#fbfcfe] p-4 transition duration-200 hover:border-[#c8d7e8] hover:bg-white">
                                <label for="responsibility" class="mb-3 flex items-center gap-2.5 text-sm font-bold text-[#344761]">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                                        <i data-lucide="shield-check" class="h-4 w-4"></i>
                                    </span>
                                    Tanggung Jawab
                                </label>

                                <div class="relative">
                                    <input
                                        type="number"
                                        name="responsibility"
                                        id="responsibility"
                                        min="0"
                                        max="100"
                                        step="1"
                                        value="{{ old('responsibility', $assessment->responsibility) }}"
                                        required
                                        inputmode="numeric"
                                        class="score-input w-full rounded-xl border border-[#dce4ee] bg-white px-4 py-3 pr-14 text-lg font-extrabold tabular-nums text-[#243f63] outline-none transition focus:border-[#416b9e] focus:ring-4 focus:ring-[#416b9e]/10"
                                    >
                                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-[#8b9bb0]">/ 100</span>
                                </div>

                                @error('responsibility')
                                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Teamwork --}}
                            <div class="score-field rounded-2xl border border-[#e6ecf3] bg-[#fbfcfe] p-4 transition duration-200 hover:border-[#c8d7e8] hover:bg-white">
                                <label for="teamwork" class="mb-3 flex items-center gap-2.5 text-sm font-bold text-[#344761]">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-50 text-violet-700">
                                        <i data-lucide="users-round" class="h-4 w-4"></i>
                                    </span>
                                    Kerja Sama
                                </label>

                                <div class="relative">
                                    <input
                                        type="number"
                                        name="teamwork"
                                        id="teamwork"
                                        min="0"
                                        max="100"
                                        step="1"
                                        value="{{ old('teamwork', $assessment->teamwork) }}"
                                        required
                                        inputmode="numeric"
                                        class="score-input w-full rounded-xl border border-[#dce4ee] bg-white px-4 py-3 pr-14 text-lg font-extrabold tabular-nums text-[#243f63] outline-none transition focus:border-[#416b9e] focus:ring-4 focus:ring-[#416b9e]/10"
                                    >
                                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-[#8b9bb0]">/ 100</span>
                                </div>

                                @error('teamwork')
                                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Communication --}}
                            <div class="score-field rounded-2xl border border-[#e6ecf3] bg-[#fbfcfe] p-4 transition duration-200 hover:border-[#c8d7e8] hover:bg-white">
                                <label for="communication" class="mb-3 flex items-center gap-2.5 text-sm font-bold text-[#344761]">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-cyan-50 text-cyan-700">
                                        <i data-lucide="messages-square" class="h-4 w-4"></i>
                                    </span>
                                    Komunikasi
                                </label>

                                <div class="relative">
                                    <input
                                        type="number"
                                        name="communication"
                                        id="communication"
                                        min="0"
                                        max="100"
                                        step="1"
                                        value="{{ old('communication', $assessment->communication) }}"
                                        required
                                        inputmode="numeric"
                                        class="score-input w-full rounded-xl border border-[#dce4ee] bg-white px-4 py-3 pr-14 text-lg font-extrabold tabular-nums text-[#243f63] outline-none transition focus:border-[#416b9e] focus:ring-4 focus:ring-[#416b9e]/10"
                                    >
                                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-[#8b9bb0]">/ 100</span>
                                </div>

                                @error('communication')
                                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Initiative --}}
                            <div class="score-field rounded-2xl border border-[#e6ecf3] bg-[#fbfcfe] p-4 transition duration-200 hover:border-[#c8d7e8] hover:bg-white">
                                <label for="initiative" class="mb-3 flex items-center gap-2.5 text-sm font-bold text-[#344761]">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                                        <i data-lucide="zap" class="h-4 w-4"></i>
                                    </span>
                                    Inisiatif
                                </label>

                                <div class="relative">
                                    <input
                                        type="number"
                                        name="initiative"
                                        id="initiative"
                                        min="0"
                                        max="100"
                                        step="1"
                                        value="{{ old('initiative', $assessment->initiative) }}"
                                        required
                                        inputmode="numeric"
                                        class="score-input w-full rounded-xl border border-[#dce4ee] bg-white px-4 py-3 pr-14 text-lg font-extrabold tabular-nums text-[#243f63] outline-none transition focus:border-[#416b9e] focus:ring-4 focus:ring-[#416b9e]/10"
                                    >
                                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-[#8b9bb0]">/ 100</span>
                                </div>

                                @error('initiative')
                                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Work quality --}}
                            <div class="score-field rounded-2xl border border-[#e6ecf3] bg-[#fbfcfe] p-4 transition duration-200 hover:border-[#c8d7e8] hover:bg-white">
                                <label for="work_quality" class="mb-3 flex items-center gap-2.5 text-sm font-bold text-[#344761]">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-rose-50 text-rose-700">
                                        <i data-lucide="badge-check" class="h-4 w-4"></i>
                                    </span>
                                    Kualitas Kerja
                                </label>

                                <div class="relative">
                                    <input
                                        type="number"
                                        name="work_quality"
                                        id="work_quality"
                                        min="0"
                                        max="100"
                                        step="1"
                                        value="{{ old('work_quality', $assessment->work_quality) }}"
                                        required
                                        inputmode="numeric"
                                        class="score-input w-full rounded-xl border border-[#dce4ee] bg-white px-4 py-3 pr-14 text-lg font-extrabold tabular-nums text-[#243f63] outline-none transition focus:border-[#416b9e] focus:ring-4 focus:ring-[#416b9e]/10"
                                    >
                                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-[#8b9bb0]">/ 100</span>
                                </div>

                                @error('work_quality')
                                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- Score summary --}}
                        <div class="mt-6 rounded-2xl border border-[#dce6f2] bg-gradient-to-r from-[#f5f8fc] to-[#edf3fa] p-5 sm:p-6">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#365b88] shadow-sm">
                                        <i data-lucide="calculator" class="h-5 w-5"></i>
                                    </div>

                                    <div>
                                        <p class="text-sm font-bold text-[#243f63]">Rata-rata Nilai</p>
                                        <p class="mt-1 text-xs text-[#718096]">Dihitung otomatis dari enam aspek penilaian.</p>
                                    </div>
                                </div>

                                <div class="flex items-baseline gap-2">
                                    <span id="average-score" class="text-4xl font-black tracking-tight text-[#243f63]">0</span>
                                    <span class="text-sm font-semibold text-[#718096]">/ 100</span>
                                </div>
                            </div>

                            <div class="mt-5 h-2 overflow-hidden rounded-full bg-white">
                                <div id="average-progress" class="h-full w-0 rounded-full bg-[#416b9e] transition-all duration-300"></div>
                            </div>

                            <p id="average-hint" class="mt-3 text-xs font-medium text-[#718096]">
                                Masukkan nilai untuk melihat rata-rata penilaian.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Notes --}}
                <section data-anim class="overflow-hidden rounded-3xl border border-[#e0e7f0] bg-white shadow-[0_8px_32px_rgba(36,63,99,0.045)]">

                    <div class="flex items-center gap-4 border-b border-[#e9eef5] px-5 py-5 sm:px-7">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#edf3fa] text-[#365b88]">
                            <i data-lucide="notebook-pen" class="h-5 w-5"></i>
                        </div>

                        <div>
                            <h2 class="font-bold text-[#243f63] sm:text-lg">Catatan Evaluasi</h2>
                            <p class="mt-1 text-xs text-[#718096] sm:text-sm">
                                Tambahkan masukan atau evaluasi untuk siswa.
                            </p>
                        </div>

                        <span class="ml-auto rounded-lg border border-[#e0e7f0] bg-[#fbfcfe] px-2.5 py-1.5 text-[10px] font-bold uppercase tracking-wider text-[#718096]">
                            Opsional
                        </span>
                    </div>

                    <div class="p-5 sm:p-7">
                        <label for="notes" class="mb-2 block text-sm font-bold text-[#344761]">
                            Catatan
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            rows="5"
                            placeholder="Tuliskan evaluasi, pencapaian, hal yang perlu ditingkatkan, atau saran untuk siswa..."
                            class="w-full resize-y rounded-2xl border border-[#dce4ee] bg-[#fbfcfe] px-4 py-4 text-sm leading-6 text-[#344761] outline-none transition duration-200 placeholder:text-[#a0acbb] hover:border-[#bdcde0] focus:border-[#416b9e] focus:bg-white focus:ring-4 focus:ring-[#416b9e]/10"
                        >{{ old('notes', $assessment->notes) }}</textarea>

                        @error('notes')
                            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror

                        <div class="mt-3 flex items-start gap-2 text-xs leading-5 text-[#8b9bb0]">
                            <i data-lucide="info" class="mt-0.5 h-3.5 w-3.5 shrink-0"></i>
                            <p>Catatan ini dapat digunakan sebagai bahan evaluasi perkembangan siswa selama PRAKERIN.</p>
                        </div>
                    </div>
                </section>

                {{-- Form actions --}}
                <section data-anim class="rounded-3xl border border-[#e0e7f0] bg-white p-5 shadow-[0_8px_32px_rgba(36,63,99,0.045)] sm:p-7">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-start gap-3">
                            <i data-lucide="shield-check" class="mt-0.5 h-5 w-5 shrink-0 text-[#416b9e]"></i>
                            <div>
                                <p class="text-sm font-bold text-[#344761]">Periksa kembali data</p>
                                <p class="mt-1 text-xs leading-5 text-[#718096]">
                                    Pastikan semua nilai sudah benar sebelum menyimpan perubahan.
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col-reverse gap-3 sm:flex-row">
                            <a
                                href="{{ route('admin.assessments.index') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#dce4ee] bg-white px-5 py-3 text-sm font-bold text-[#53657d] transition duration-200 hover:border-[#bdcde0] hover:bg-[#f7f9fc] hover:text-[#243f63]"
                            >
                                <i data-lucide="x" class="h-4 w-4"></i>
                                Batal
                            </a>

                            <button
                                type="submit"
                                id="submit-button"
                                class="group inline-flex items-center justify-center gap-2 rounded-xl bg-[#294d78] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-[#294d78]/15 transition duration-200 hover:-translate-y-0.5 hover:bg-[#243f63] hover:shadow-xl hover:shadow-[#294d78]/20 focus:outline-none focus:ring-4 focus:ring-[#416b9e]/20 active:translate-y-0"
                            >
                                <i data-lucide="save" class="h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </div>
                </section>

            </form>

            {{-- Footer --}}
            <footer data-anim class="mt-10 border-t border-[#e0e7f0] py-6">
                <div class="flex flex-col items-center justify-between gap-3 text-center sm:flex-row sm:text-left">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#243f63] text-white">
                            <i data-lucide="graduation-cap" class="h-4 w-4"></i>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold tracking-wide text-[#365b88]">PRAKERIN</p>
                            <p class="text-[10px] text-[#8b9bb0]">DISKOMINFO PACITAN</p>
                        </div>
                    </div>

                    <p class="text-xs text-[#8b9bb0]">
                        Sistem Informasi Praktik Kerja Lapangan
                    </p>
                </div>
            </footer>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Lucide icons
            if (window.lucide) {
                window.lucide.createIcons();
            }

            // Entrance animations
            if (window.gsap) {
                gsap.from('[data-anim]', {
                    opacity: 0,
                    y: 16,
                    duration: 0.65,
                    stagger: 0.07,
                    ease: 'power2.out',
                    clearProps: 'opacity,transform'
                });

                gsap.from('.score-field', {
                    opacity: 0,
                    y: 10,
                    duration: 0.45,
                    stagger: 0.045,
                    delay: 0.2,
                    ease: 'power2.out',
                    clearProps: 'opacity,transform'
                });
            }

            // Automatic average score preview
            const scoreInputs = Array.from(document.querySelectorAll('.score-input'));
            const averageScore = document.getElementById('average-score');
            const averageProgress = document.getElementById('average-progress');
            const averageHint = document.getElementById('average-hint');

            function updateAverage() {
                const values = scoreInputs
                    .map((input) => input.value.trim())
                    .filter((value) => value !== '')
                    .map(Number)
                    .filter((value) => Number.isFinite(value));

                if (values.length === 0) {
                    averageScore.textContent = '0';
                    averageProgress.style.width = '0%';
                    averageHint.textContent = 'Masukkan nilai untuk melihat rata-rata penilaian.';
                    return;
                }

                const average = values.reduce((total, value) => total + value, 0) / values.length;
                const roundedAverage = Math.round(average * 100) / 100;

                averageScore.textContent = roundedAverage.toLocaleString('id-ID', {
                    maximumFractionDigits: 2
                });

                averageProgress.style.width = `${Math.min(100, Math.max(0, average))}%`;

                if (values.length < scoreInputs.length) {
                    averageHint.textContent = `${values.length} dari ${scoreInputs.length} aspek sudah diisi. Rata-rata sementara.`;
                } else {
                    averageHint.textContent = 'Semua aspek sudah diisi. Rata-rata dihitung dari keenam nilai.';
                }
            }

            scoreInputs.forEach((input) => {
                input.addEventListener('input', updateAverage);

                input.addEventListener('change', () => {
                    if (input.value === '') {
                        updateAverage();
                        return;
                    }

                    const value = Number(input.value);

                    if (value < 0) input.value = '0';
                    if (value > 100) input.value = '100';

                    updateAverage();
                });
            });

            updateAverage();

            // Prevent accidental double submission
            const form = document.getElementById('assessment-form');
            const submitButton = document.getElementById('submit-button');

            form.addEventListener('submit', () => {
                if (!form.checkValidity()) {
                    return;
                }

                submitButton.disabled = true;
                submitButton.classList.add('cursor-wait', 'opacity-70');

                const label = submitButton.querySelector('span');

                if (label) {
                    label.textContent = 'Menyimpan...';
                }
            });
        });
    </script>

</body>
</html>