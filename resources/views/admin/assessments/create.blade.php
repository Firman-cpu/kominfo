
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Tambah Penilaian Siswa — PRAKERIN DISKOMINFO PACITAN.">

    <title>Tambah Penilaian — PRAKERIN</title>

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
</head>

<body class="min-h-screen overflow-x-hidden bg-[#f8fafc] text-slate-800 antialiased selection:bg-sky-100 selection:text-sky-900">

    {{-- BACKGROUND --}}
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden" aria-hidden="true">
        <div class="absolute -left-40 -top-40 h-[420px] w-[420px] rounded-full bg-sky-100/70 blur-3xl"></div>
        <div class="absolute -right-40 top-[15%] h-[420px] w-[420px] rounded-full bg-blue-100/60 blur-3xl"></div>
        <div class="absolute bottom-[-220px] left-[35%] h-[400px] w-[400px] rounded-full bg-cyan-100/50 blur-3xl"></div>
        <div class="absolute inset-0 bg-[linear-gradient(rgba(148,163,184,0.07)_1px,transparent_1px),linear-gradient(90deg,rgba(148,163,184,0.07)_1px,transparent_1px)] bg-[size:48px_48px] [mask-image:linear-gradient(to_bottom,black,transparent_65%)]"></div>
    </div>

    <main class="relative z-10 mx-auto max-w-5xl px-4 pb-14 pt-6 sm:px-6 sm:pt-9 lg:px-8 lg:pb-20">

        {{-- NAVIGATION --}}
        <nav data-anim class="mb-10 flex items-center justify-between gap-4">
            <a href="{{ route('admin.dashboard.page') }}" class="group flex min-w-0 items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl border border-sky-100 bg-white text-sky-600 shadow-sm transition duration-300 group-hover:-translate-y-0.5 group-hover:border-sky-200 group-hover:shadow-md">
                    <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-black tracking-[0.06em] text-slate-900">PRAKERIN</p>
                    <p class="mt-0.5 truncate text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                        DISKOMINFO PACITAN
                    </p>
                </div>
            </a>

            <a
                href="{{ route('admin.assessments.index') }}"
                class="group inline-flex shrink-0 items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition duration-200 hover:border-sky-200 hover:bg-sky-50 hover:text-sky-700"
            >
                <i data-lucide="arrow-left" class="h-4 w-4 transition-transform group-hover:-translate-x-1"></i>
                <span>Kembali</span>
            </a>
        </nav>

        {{-- PAGE HEADER --}}
        <header class="mb-8">
            <div data-anim class="mb-4 inline-flex items-center gap-2 rounded-full border border-sky-100 bg-white px-3.5 py-2 shadow-sm">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-sky-400 opacity-40"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-sky-500"></span>
                </span>
                <span class="text-[10px] font-bold uppercase tracking-[0.16em] text-sky-700">
                    Formulir Penilaian
                </span>
            </div>

            <h1 data-anim class="text-3xl font-black leading-tight tracking-tight text-slate-900 sm:text-5xl">
                Tambah Penilaian
                <span class="mt-1 block text-sky-600">Siswa PRAKERIN.</span>
            </h1>

            <p data-anim class="mt-4 max-w-2xl text-sm leading-7 text-slate-500 sm:text-base">
                Catat hasil evaluasi siswa selama Praktik Kerja Lapangan. Lengkapi identitas, nilai kompetensi, dan catatan evaluasi dengan teliti.
            </p>

            <div data-anim class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-3">
                <div class="flex items-center gap-3 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                        <i data-lucide="list-checks" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">6 Aspek</p>
                        <p class="mt-0.5 text-xs text-slate-400">Kompetensi siswa</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600">
                        <i data-lucide="chart-no-axes-column-increasing" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">Skala 0–100</p>
                        <p class="mt-0.5 text-xs text-slate-400">Rentang penilaian</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i data-lucide="shield-check" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">Terlindungi</p>
                        <p class="mt-0.5 text-xs text-slate-400">Validasi dan CSRF</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())
            <section data-anim role="alert" class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                        <i data-lucide="alert-triangle" class="h-5 w-5"></i>
                    </div>

                    <div class="min-w-0">
                        <h2 class="text-sm font-bold text-red-800">Periksa kembali formulir</h2>
                        <p class="mt-1 text-xs leading-5 text-red-600">Terdapat informasi yang perlu diperbaiki.</p>

                        <ul class="mt-3 space-y-2">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start gap-2 text-sm text-red-700">
                                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-red-500"></span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>
        @endif

        {{-- FORM --}}
        <form id="assessment-form" action="{{ route('admin.assessments.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- STUDENT AND DATE --}}
            <section data-anim class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-200/50">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-5 sm:px-7">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                        <i data-lucide="user-round" class="h-5 w-5"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Identitas Penilaian</h2>
                        <p class="mt-1 text-xs text-slate-500">Informasi dasar siswa yang dievaluasi.</p>
                    </div>

                    <span class="ml-auto rounded-lg bg-slate-50 px-2.5 py-1.5 font-mono text-[10px] font-semibold text-slate-400">01 / 03</span>
                </div>

                <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-7">
                    <div>
                        <label for="student_id" class="mb-2 block text-xs font-bold text-slate-700">
                            Pilih Siswa <span class="text-red-500">*</span>
                        </label>

                        <div class="relative">
                            <select
                                name="student_id"
                                id="student_id"
                                required
                                class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 pr-10 text-sm text-slate-700 outline-none transition hover:border-sky-300 focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10"
                            >
                                <option value="">-- Pilih Siswa --</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }} — {{ $student->nis }}
                                    </option>
                                @endforeach
                            </select>
                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                        </div>

                        @error('student_id')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="assessment_date" class="mb-2 block text-xs font-bold text-slate-700">
                            Tanggal Penilaian <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="date"
                            name="assessment_date"
                            id="assessment_date"
                            value="{{ old('assessment_date', now()->format('Y-m-d')) }}"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-700 outline-none transition hover:border-sky-300 focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10"
                        >

                        @error('assessment_date')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-start gap-3 rounded-xl border border-sky-100 bg-sky-50/70 p-4 sm:col-span-2">
                        <i data-lucide="info" class="mt-0.5 h-4 w-4 shrink-0 text-sky-600"></i>
                        <p class="text-xs leading-6 text-sky-800">
                            Pastikan siswa yang dipilih sesuai dengan peserta PRAKERIN yang akan dievaluasi.
                        </p>
                    </div>
                </div>
            </section>

            {{-- SCORES --}}
            <section data-anim class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-200/50">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-5 sm:px-7">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-cyan-50 text-cyan-700">
                        <i data-lucide="clipboard-list" class="h-5 w-5"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Aspek Penilaian</h2>
                        <p class="mt-1 text-xs text-slate-500">Berikan nilai untuk setiap kompetensi siswa.</p>
                    </div>

                    <span class="ml-auto rounded-lg border border-sky-100 bg-sky-50 px-2.5 py-1.5 font-mono text-[10px] font-bold text-sky-700">0–100</span>
                </div>

                <div class="p-5 sm:p-7">
                    <div class="mb-5 flex items-start gap-3 rounded-xl border border-amber-200/70 bg-amber-50 p-4">
                        <i data-lucide="lightbulb" class="mt-0.5 h-4 w-4 shrink-0 text-amber-600"></i>
                        <p class="text-xs leading-6 text-amber-900">
                            Masukkan nilai antara <strong>0 sampai 100</strong>. Rata-rata di bawah merupakan pratinjau nilai dan bukan pengganti perhitungan di backend.
                        </p>
                    </div>

                    @php
                        $aspectInputs = [
                            ['name' => 'discipline', 'label' => 'Kedisiplinan', 'icon' => 'shield-check', 'iconClass' => 'text-sky-600', 'iconBg' => 'bg-sky-50'],
                            ['name' => 'responsibility', 'label' => 'Tanggung Jawab', 'icon' => 'target', 'iconClass' => 'text-cyan-700', 'iconBg' => 'bg-cyan-50'],
                            ['name' => 'teamwork', 'label' => 'Kerja Sama', 'icon' => 'users-round', 'iconClass' => 'text-blue-600', 'iconBg' => 'bg-blue-50'],
                            ['name' => 'communication', 'label' => 'Komunikasi', 'icon' => 'messages-square', 'iconClass' => 'text-teal-600', 'iconBg' => 'bg-teal-50'],
                            ['name' => 'initiative', 'label' => 'Inisiatif', 'icon' => 'lightbulb', 'iconClass' => 'text-indigo-600', 'iconBg' => 'bg-indigo-50'],
                            ['name' => 'work_quality', 'label' => 'Kualitas Kerja', 'icon' => 'award', 'iconClass' => 'text-emerald-600', 'iconBg' => 'bg-emerald-50'],
                        ];
                    @endphp

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($aspectInputs as $input)
                            <div class="score-card rounded-2xl border border-slate-200 bg-slate-50/70 p-4 transition duration-200 hover:border-sky-200 hover:bg-white hover:shadow-md hover:shadow-slate-200/50">
                                <label for="{{ $input['name'] }}" class="mb-3 flex items-center gap-2.5 text-xs font-bold text-slate-700">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $input['iconBg'] }}">
                                        <i data-lucide="{{ $input['icon'] }}" class="h-4 w-4 {{ $input['iconClass'] }}"></i>
                                    </span>
                                    {{ $input['label'] }}
                                    <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <input
                                        type="number"
                                        name="{{ $input['name'] }}"
                                        id="{{ $input['name'] }}"
                                        min="0"
                                        max="100"
                                        step="1"
                                        value="{{ old($input['name']) }}"
                                        required
                                        inputmode="numeric"
                                        placeholder="0"
                                        class="score-input w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 pr-14 font-mono text-lg font-bold tabular-nums text-slate-900 outline-none transition placeholder:text-slate-300 focus:border-sky-400 focus:ring-4 focus:ring-sky-500/10"
                                    >
                                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 font-mono text-[10px] text-slate-400">/ 100</span>
                                </div>

                                @error($input['name'])
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror

                                <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-slate-200">
                                    <div data-score-bar="{{ $input['name'] }}" class="h-full w-0 rounded-full bg-gradient-to-r from-sky-500 to-cyan-400 transition-all duration-300"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- AVERAGE PREVIEW --}}
                    <div class="mt-6 rounded-2xl border border-sky-100 bg-gradient-to-br from-sky-50 via-white to-cyan-50 p-5 sm:p-6">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-sky-100 bg-white text-sky-600 shadow-sm">
                                    <i data-lucide="chart-no-axes-combined" class="h-5 w-5"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Rata-rata Sementara</h3>
                                    <p id="average-hint" class="mt-1 text-xs text-slate-500">Isi keenam nilai untuk mendapatkan rata-rata.</p>
                                </div>
                            </div>

                            <div class="flex items-baseline gap-2 sm:text-right">
                                <span id="average-score" class="text-4xl font-black tracking-tight text-sky-700">—</span>
                                <span class="font-mono text-xs text-slate-400">/ 100</span>
                            </div>
                        </div>

                        <div class="mt-5 h-2 overflow-hidden rounded-full bg-sky-100">
                            <div id="average-progress" class="h-full w-0 rounded-full bg-gradient-to-r from-sky-500 to-cyan-400 transition-all duration-300"></div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- NOTES --}}
            <section data-anim class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-200/50">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-5 sm:px-7">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                        <i data-lucide="notebook-pen" class="h-5 w-5"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Catatan Evaluasi</h2>
                        <p class="mt-1 text-xs text-slate-500">Masukan tambahan untuk perkembangan siswa.</p>
                    </div>

                    <span class="ml-auto rounded-lg bg-slate-100 px-2.5 py-1.5 text-[10px] font-semibold uppercase tracking-wider text-slate-500">Opsional</span>
                </div>

                <div class="p-5 sm:p-7">
                    <label for="notes" class="mb-2 block text-xs font-bold text-slate-700">Catatan</label>

                    <textarea
                        name="notes"
                        id="notes"
                        rows="5"
                        placeholder="Tuliskan evaluasi, pencapaian, hal yang perlu ditingkatkan, atau saran untuk siswa..."
                        class="w-full resize-y rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-500/10"
                    >{{ old('notes') }}</textarea>

                    @error('notes')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="mt-3 flex items-start gap-2 text-xs leading-5 text-slate-500">
                        <i data-lucide="info" class="mt-0.5 h-4 w-4 shrink-0 text-sky-600"></i>
                        <p>Catatan ini dapat digunakan untuk mendokumentasikan perkembangan, pencapaian, dan evaluasi siswa selama PRAKERIN.</p>
                    </div>
                </div>
            </section>

            {{-- ACTIONS --}}
            <section data-anim class="flex flex-col-reverse gap-4 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                <p class="flex items-center gap-2 text-xs leading-5 text-slate-500">
                    <i data-lucide="lock-keyhole" class="h-4 w-4 shrink-0 text-emerald-600"></i>
                    Formulir dilindungi oleh token CSRF Laravel.
                </p>

                <div class="flex flex-col-reverse gap-3 sm:flex-row">
                    <a
                        href="{{ route('admin.assessments.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3.5 text-xs font-bold text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900"
                    >
                        <i data-lucide="x" class="h-4 w-4"></i>
                        Batal
                    </a>

                    <button
                        id="submit-button"
                        type="submit"
                        class="group inline-flex items-center justify-center gap-3 rounded-xl bg-sky-600 px-5 py-3.5 text-xs font-bold text-white shadow-lg shadow-sky-600/20 transition duration-200 hover:-translate-y-0.5 hover:bg-sky-700 hover:shadow-xl hover:shadow-sky-600/25 focus:outline-none focus:ring-4 focus:ring-sky-500/20 disabled:cursor-wait disabled:opacity-60"
                    >
                        <i data-lucide="save" class="h-4 w-4"></i>
                        <span>Simpan Penilaian</span>
                        <i data-lucide="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                    </button>
                </div>
            </section>
        </form>

        {{-- FOOTER --}}
        <footer data-anim class="mt-12 border-t border-slate-200 pt-6">
            <div class="flex flex-col items-center justify-between gap-3 text-center sm:flex-row sm:text-left">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span class="font-mono text-[10px] uppercase tracking-[0.12em] text-slate-400">assessment.form.ready</span>
                </div>
                <p class="text-xs text-slate-400">PRAKERIN · DISKOMINFO PACITAN</p>
            </div>
        </footer>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Icons
            if (window.lucide && typeof window.lucide.createIcons === 'function') {
                window.lucide.createIcons({
                    attrs: { 'stroke-width': 1.8 }
                });
            }

            // Entrance animation; page remains usable without GSAP.
            if (window.gsap) {
                try {
                    gsap.config({ force3D: true });
                    gsap.ticker.lagSmoothing(500, 33);

                    gsap.from('[data-anim]', {
                        y: 16,
                        opacity: 0,
                        duration: 0.5,
                        stagger: 0.04,
                        ease: 'power3.out',
                        clearProps: 'transform,opacity'
                    });

                    gsap.from('.score-card', {
                        y: 8,
                        opacity: 0,
                        duration: 0.35,
                        stagger: 0.04,
                        delay: 0.12,
                        ease: 'power2.out',
                        clearProps: 'transform,opacity'
                    });
                } catch (error) {
                    console.warn('Animasi tidak dapat dijalankan:', error);
                }
            }

            // Score preview
            const scoreInputs = Array.from(document.querySelectorAll('.score-input'));
            const averageScore = document.getElementById('average-score');
            const averageProgress = document.getElementById('average-progress');
            const averageHint = document.getElementById('average-hint');

            function updateScores() {
                const values = scoreInputs.map(function (input) {
                    return input.value.trim() === '' ? null : Number(input.value);
                });

                scoreInputs.forEach(function (input, index) {
                    const bar = document.querySelector('[data-score-bar="' + input.name + '"]');
                    if (!bar) return;

                    const value = values[index];
                    bar.style.width = value === null
                        ? '0%'
                        : Math.min(100, Math.max(0, value)) + '%';
                });

                const completed = values.filter(function (value) {
                    return value !== null && Number.isFinite(value);
                });

                if (completed.length === 0) {
                    averageScore.textContent = '—';
                    averageProgress.style.width = '0%';
                    averageHint.textContent = 'Isi keenam nilai untuk mendapatkan rata-rata.';
                    return;
                }

                const average = completed.reduce(function (sum, value) {
                    return sum + value;
                }, 0) / completed.length;

                averageScore.textContent = average.toLocaleString('id-ID', {
                    maximumFractionDigits: 2
                });

                averageProgress.style.width = Math.min(100, Math.max(0, average)) + '%';

                averageHint.textContent = completed.length < scoreInputs.length
                    ? completed.length + ' dari ' + scoreInputs.length + ' aspek terisi · rata-rata sementara'
                    : 'Semua aspek sudah diisi · rata-rata enam nilai';
            }

            scoreInputs.forEach(function (input) {
                input.addEventListener('input', updateScores);

                input.addEventListener('change', function () {
                    if (input.value.trim() !== '') {
                        const value = Number(input.value);
                        if (value < 0) input.value = '0';
                        if (value > 100) input.value = '100';
                    }
                    updateScores();
                });
            });

            updateScores();

            // Prevent accidental double submission.
            const form = document.getElementById('assessment-form');
            const submitButton = document.getElementById('submit-button');

            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    form.reportValidity();
                    return;
                }

                if (submitButton.disabled) {
                    event.preventDefault();
                    return;
                }

                submitButton.disabled = true;

                const label = submitButton.querySelector('span');
                if (label) label.textContent = 'Menyimpan...';
            });
        });
    </script>
</body>
</html>
