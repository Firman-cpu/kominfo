<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tambah Penilaian Siswa — PRAKERIN DISKOMINFO.">

    <title>Tambah Penilaian — PRAKERIN</title>

    {{-- Preconnect --}}
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

        /* Orb pakai radial-gradient — 0 cost GPU */
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
                rgba(59, 130, 246, 0.24) 0%,
                rgba(59, 130, 246, 0.1) 38%,
                rgba(59, 130, 246, 0.03) 62%,
                transparent 78%);
        }

        .field,
        .btn-magnetic {
            will-change: transform;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
        }

        /* Sembunyikan spinner default input number biar konsisten */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Color-scheme biar ikon date-picker browser ikut gelap */
        input[type="date"] { color-scheme: dark; }

        /* Select option warna sesuai tema */
        select option { background-color: #0f1b2c; color: #e2e8f0; }
    </style>

    {{-- Libs di HEAD + defer --}}
    <script defer src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
</head>

<body class="min-h-screen overflow-x-hidden bg-[#0a1520] text-slate-100 antialiased selection:bg-sky-400/30">

    {{-- BACKGROUND — ICE ATMOSPHERE --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="orb orb-1 absolute -left-40 -top-40 h-[500px] w-[500px] rounded-full"></div>
        <div class="orb orb-2 absolute -right-40 top-[18%] h-[500px] w-[500px] rounded-full"></div>
        <div class="orb orb-3 absolute bottom-[-250px] left-[35%] h-[500px] w-[500px] rounded-full"></div>

        <div class="absolute inset-0 opacity-[0.05] [background-image:linear-gradient(rgba(186,230,253,1)_1px,transparent_1px),linear-gradient(90deg,rgba(186,230,253,1)_1px,transparent_1px)] [background-size:56px_56px] [mask-image:linear-gradient(to_bottom,black,transparent_70%)]"></div>

        <div class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2 bg-gradient-to-r from-transparent via-sky-400/60 to-transparent"></div>
    </div>


    <main class="relative mx-auto max-w-4xl px-4 pb-20 pt-12 sm:px-6 sm:pt-16 lg:px-8 lg:pb-28">

        {{-- BACK --}}
        <a
            data-anim
            href="{{ route('admin.assessments.index') }}"
            class="group inline-flex items-center gap-2.5 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-4 py-2 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/40 hover:bg-sky-400/[0.14]"
        >
            <i data-lucide="arrow-left" class="h-3.5 w-3.5 text-sky-300 transition group-hover:-translate-x-0.5"></i>
            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                Kembali
            </span>
        </a>


        {{-- HEADER --}}
        <section class="mt-6">
            <div data-anim class="mb-6 inline-flex items-center gap-2 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-3 py-1.5">
                <i data-lucide="clipboard-plus" class="h-3.5 w-3.5 text-sky-300"></i>
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                    assessment.create
                </span>
            </div>

            <h1 data-anim class="max-w-3xl text-5xl font-black leading-[0.9] tracking-[-0.055em] text-white sm:text-6xl">
                TAMBAH
                <span class="shimmer-text mt-1 block bg-gradient-to-r from-sky-200 via-cyan-200 to-blue-300 bg-clip-text text-transparent">
                    PENILAIAN
                </span>
            </h1>

            <p data-anim class="mt-6 max-w-xl text-sm leading-7 text-slate-400 sm:text-base">
                Isi seluruh aspek penilaian siswa Praktik Kerja Lapangan.
                Semua kolom bernilai wajib kecuali catatan.
            </p>

            <div data-anim class="mt-8 h-px w-full bg-gradient-to-r from-sky-400/30 via-cyan-300/10 to-transparent"></div>
        </section>


        {{-- ERRORS --}}
        @if ($errors->any())
            <div data-anim class="mt-8 overflow-hidden rounded-2xl border border-red-400/25 bg-red-500/[0.08] p-5">
                <div class="flex items-start gap-3">
                    <i data-lucide="alert-triangle" class="mt-0.5 h-4 w-4 shrink-0 text-red-300"></i>
                    <div class="min-w-0">
                        <div class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-red-300">
                            Ada kesalahan
                        </div>
                        <ul class="mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-xs leading-5 text-red-200/90">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif


        {{-- FORM --}}
        <form
            data-anim
            action="{{ route('admin.assessments.store') }}"
            method="POST"
            class="mt-8 space-y-8"
        >
            @csrf


            {{-- STUDENT & DATE --}}
            <section class="form-card relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl sm:p-7">
                <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-sky-500/10 blur-[100px]"></div>

                <div class="relative">
                    <div class="mb-5 flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-sky-300/15 bg-sky-300/[0.08]">
                            <i data-lucide="user-round" class="h-4 w-4 text-sky-300"></i>
                        </div>
                        <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-400">
                            Identitas
                        </span>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">

                        {{-- SISWA --}}
                        <div class="field">
                            <label
                                for="student_id"
                                class="mb-2 flex items-center gap-2 font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500"
                            >
                                <i data-lucide="users" class="h-3.5 w-3.5 text-sky-300"></i>
                                Siswa
                            </label>

                            <select
                                name="student_id"
                                id="student_id"
                                required
                                class="w-full rounded-xl border border-sky-200/[0.12] bg-black/25 px-4 py-3 text-sm text-slate-100 outline-none transition duration-200 focus:border-sky-300/50 focus:bg-black/35 focus:ring-2 focus:ring-sky-400/20"
                            >
                                <option value="">
                                    -- Pilih Siswa --
                                </option>

                                @foreach ($students as $student)
                                    <option
                                        value="{{ $student->id }}"
                                        {{ old('student_id') == $student->id ? 'selected' : '' }}
                                    >
                                        {{ $student->name }} — {{ $student->nis }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- DATE --}}
                        <div class="field">
                            <label
                                for="assessment_date"
                                class="mb-2 flex items-center gap-2 font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500"
                            >
                                <i data-lucide="calendar-check" class="h-3.5 w-3.5 text-cyan-300"></i>
                                Tanggal Penilaian
                            </label>

                            <input
                                type="date"
                                name="assessment_date"
                                id="assessment_date"
                                value="{{ old('assessment_date', now()->format('Y-m-d')) }}"
                                required
                                class="w-full rounded-xl border border-sky-200/[0.12] bg-black/25 px-4 py-3 font-mono text-sm text-slate-100 outline-none transition duration-200 focus:border-cyan-300/50 focus:bg-black/35 focus:ring-2 focus:ring-cyan-400/20"
                            >
                        </div>

                    </div>
                </div>
            </section>


            {{-- ASPECTS --}}
            <section class="form-card relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl sm:p-7">
                <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-cyan-500/10 blur-[100px]"></div>

                <div class="relative">
                    <div class="mb-5 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-cyan-300/15 bg-cyan-300/[0.08]">
                                <i data-lucide="clipboard-list" class="h-4 w-4 text-cyan-300"></i>
                            </div>
                            <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-400">
                                Aspek Penilaian
                            </span>
                        </div>
                        <span class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">
                            0 – 100
                        </span>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                        @php
                            $aspectInputs = [
                                ['name' => 'discipline',     'label' => 'Kedisiplinan',   'icon' => 'shield',         'accent' => 'sky'],
                                ['name' => 'responsibility', 'label' => 'Tanggung Jawab', 'icon' => 'target',         'accent' => 'cyan'],
                                ['name' => 'teamwork',       'label' => 'Kerja Sama',     'icon' => 'handshake',      'accent' => 'blue'],
                                ['name' => 'communication',  'label' => 'Komunikasi',     'icon' => 'message-square', 'accent' => 'teal'],
                                ['name' => 'initiative',     'label' => 'Inisiatif',      'icon' => 'lightbulb',      'accent' => 'sky'],
                                ['name' => 'work_quality',   'label' => 'Kualitas Kerja', 'icon' => 'award',          'accent' => 'cyan'],
                            ];
                        @endphp

                        @foreach ($aspectInputs as $input)
                            <div class="field">
                                <label
                                    for="{{ $input['name'] }}"
                                    class="mb-2 flex items-center gap-2 font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500"
                                >
                                    <i data-lucide="{{ $input['icon'] }}" class="h-3.5 w-3.5 text-{{ $input['accent'] }}-300"></i>
                                    {{ $input['label'] }}
                                </label>

                                <input
                                    type="number"
                                    name="{{ $input['name'] }}"
                                    id="{{ $input['name'] }}"
                                    min="0"
                                    max="100"
                                    value="{{ old($input['name']) }}"
                                    required
                                    placeholder="0"
                                    inputmode="numeric"
                                    class="w-full rounded-xl border border-sky-200/[0.12] bg-black/25 px-4 py-3 font-mono text-sm text-slate-100 placeholder:text-slate-600 outline-none transition duration-200 focus:border-sky-300/50 focus:bg-black/35 focus:ring-2 focus:ring-sky-400/20"
                                >
                            </div>
                        @endforeach

                    </div>
                </div>
            </section>


            {{-- NOTES --}}
            <section class="form-card relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl sm:p-7">
                <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-blue-500/10 blur-[100px]"></div>

                <div class="relative">
                    <div class="mb-5 flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-blue-300/15 bg-blue-300/[0.08]">
                            <i data-lucide="message-square-text" class="h-4 w-4 text-blue-300"></i>
                        </div>
                        <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-400">
                            Catatan
                        </span>
                        <span class="ml-auto font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">
                            Opsional
                        </span>
                    </div>

                    <div class="field">
                        <textarea
                            name="notes"
                            id="notes"
                            rows="5"
                            placeholder="Tuliskan catatan tambahan untuk siswa ini..."
                            class="w-full resize-y rounded-xl border border-sky-200/[0.12] bg-black/25 px-4 py-3 text-sm leading-6 text-slate-100 placeholder:text-slate-600 outline-none transition duration-200 focus:border-blue-300/50 focus:bg-black/35 focus:ring-2 focus:ring-blue-400/20"
                        >{{ old('notes') }}</textarea>
                    </div>
                </div>
            </section>


            {{-- ACTIONS --}}
            <div class="flex flex-wrap items-center justify-end gap-3 pt-2">
                <a
                    href="{{ route('admin.assessments.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-sky-200/[0.12] bg-white/[0.03] px-5 py-3.5 text-xs font-bold uppercase tracking-[0.14em] text-slate-300 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/30 hover:bg-white/[0.06] hover:text-white"
                >
                    <i data-lucide="x" class="h-4 w-4"></i>
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn-magnetic group inline-flex items-center gap-3 rounded-xl bg-gradient-to-r from-sky-500 via-cyan-400 to-blue-500 px-5 py-3.5 text-xs font-bold uppercase tracking-[0.14em] text-white shadow-xl shadow-sky-500/30 transition duration-300 hover:-translate-y-0.5 hover:shadow-sky-400/50"
                >
                    <i data-lucide="save" class="h-4 w-4"></i>
                    Simpan Penilaian
                    <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-0.5"></i>
                </button>
            </div>

        </form>


        {{-- FOOTER NOTE --}}
        <div data-anim class="mt-14 flex items-center justify-center gap-3 font-mono text-[9px] text-slate-600">
            <span class="text-teal-300">●</span>
            assessment.form.ready
            <span class="text-slate-700">/</span>
            <span class="text-sky-300/80">csrf.protected</span>
        </div>

    </main>


    {{-- SCRIPT — ICONS + ANIMATIONS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        var root = document.documentElement;

        /* ICONS */
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
        }

        /* GSAP */
        if (!window.gsap) {
            root.classList.remove('gsap-init');
        } else {
            gsap.config({ force3D: true });
            gsap.ticker.lagSmoothing(500, 33);

            try {
                var tl = gsap.timeline({
                    defaults: { ease: 'power3.out', clearProps: 'transform,opacity' }
                });

                tl.from('[data-anim]', {
                    y: 22,
                    opacity: 0,
                    duration: 0.6,
                    stagger: { each: 0.04, from: 'start' }
                });

                root.classList.remove('gsap-init');

                /* Ambient orb — transform only */
                gsap.to('.orb-1', { x: 40,  y: 30,  duration: 14, repeat: -1, yoyo: true, ease: 'sine.inOut' });
                gsap.to('.orb-2', { x: -30, y: 40,  duration: 16, repeat: -1, yoyo: true, ease: 'sine.inOut' });
                gsap.to('.orb-3', { x: 20,  y: -30, duration: 18, repeat: -1, yoyo: true, ease: 'sine.inOut' });

                /* SUBMIT BUTTON MAGNETIC */
                document.querySelectorAll('.btn-magnetic').forEach(function (btn) {
                    btn.addEventListener('mousemove', function (e) {
                        var rect = btn.getBoundingClientRect();
                        var x = e.clientX - rect.left - rect.width / 2;
                        var y = e.clientY - rect.top - rect.height / 2;
                        gsap.to(btn, { x: x * 0.12, y: y * 0.2, duration: 0.4, ease: 'power2.out' });
                    });
                    btn.addEventListener('mouseleave', function () {
                        gsap.to(btn, { x: 0, y: 0, duration: 0.6, ease: 'elastic.out(1, 0.4)' });
                    });
                });

            } catch (err) {
                console.warn('[gsap] animation error — showing content', err);
                root.classList.remove('gsap-init');
            }
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