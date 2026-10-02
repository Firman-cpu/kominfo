<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Penilaian Siswa — PRAKERIN DISKOMINFO.">

    <title>Penilaian Siswa — PRAKERIN</title>

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

        .stat-item,
        .assess-card,
        .btn-magnetic {
            will-change: transform;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
        }
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


        {{-- HEADER --}}
        <section class="mt-6">
            <div class="grid items-end gap-6 lg:grid-cols-[1fr_auto]">

                <div>
                    <div data-anim class="mb-6 inline-flex items-center gap-2 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-3 py-1.5">
                        <i data-lucide="clipboard-list" class="h-3.5 w-3.5 text-sky-300"></i>
                        <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                            assessment.records
                        </span>
                    </div>

                    <h1 data-anim class="max-w-3xl text-5xl font-black leading-[0.9] tracking-[-0.055em] text-white sm:text-6xl">
                        PENILAIAN
                        <span class="shimmer-text mt-1 block bg-gradient-to-r from-sky-200 via-cyan-200 to-blue-300 bg-clip-text text-transparent">
                            SISWA
                        </span>
                    </h1>

                    <p data-anim class="mt-6 max-w-xl text-sm leading-7 text-slate-400 sm:text-base">
                        Daftar seluruh penilaian siswa Praktik Kerja Lapangan.
                        Tambah, ubah, atau hapus data penilaian dari halaman ini.
                    </p>
                </div>

                {{-- ADD BUTTON --}}
                <a
                    data-anim
                    href="{{ route('admin.assessments.create') }}"
                    class="btn-magnetic group inline-flex items-center gap-3 rounded-xl bg-gradient-to-r from-sky-500 via-cyan-400 to-blue-500 px-5 py-3.5 text-xs font-bold uppercase tracking-[0.14em] text-white shadow-xl shadow-sky-500/30 transition duration-300 hover:-translate-y-1 hover:shadow-sky-400/50"
                >
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Tambah Penilaian
                    <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-0.5"></i>
                </a>
            </div>

            <div data-anim class="mt-8 h-px w-full bg-gradient-to-r from-sky-400/30 via-cyan-300/10 to-transparent"></div>
        </section>


        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div data-anim class="mt-8 overflow-hidden rounded-2xl border border-teal-300/25 bg-teal-500/[0.08] p-5">
                <div class="flex items-start gap-3">
                    <i data-lucide="check-circle-2" class="mt-0.5 h-4 w-4 shrink-0 text-teal-300"></i>
                    <div class="min-w-0">
                        <div class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-teal-300">
                            success
                        </div>
                        <p class="mt-1 text-sm leading-6 text-teal-100">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif


        {{-- LIST --}}
        <section class="mt-8">
            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    assessment.list
                </span>
                <span class="h-px flex-1 bg-sky-200/[0.08]"></span>
                <span class="flex items-center gap-1.5 font-mono text-[9px] text-slate-500">
                    <span class="h-1.5 w-1.5 rounded-full bg-teal-300 animate-pulse"></span>
                    LIVE
                </span>
            </div>

            <div class="space-y-4">

                @forelse ($assessments as $assessment)

                    <article data-anim class="assess-card group relative overflow-hidden rounded-2xl border border-sky-200/[0.1] bg-[#0f1b2c]/80 p-5 backdrop-blur-xl transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/25 hover:bg-[#0f1b2c]/90 sm:p-6">
                        <div class="pointer-events-none absolute -right-20 -top-20 h-52 w-52 rounded-full bg-sky-500/10 blur-3xl transition group-hover:bg-sky-400/20"></div>

                        <div class="relative">

                            {{-- HEADER ROW --}}
                            <div class="flex flex-wrap items-start justify-between gap-4">

                                <div class="flex items-center gap-3.5">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-sky-500 via-cyan-400 to-blue-500 text-lg font-black text-white shadow-lg shadow-sky-500/25">
                                        {{ strtoupper(substr($assessment->student->name, 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">
                                        <h3 class="truncate text-base font-bold text-white sm:text-lg">
                                            {{ $assessment->student->name }}
                                        </h3>
                                        <div class="mt-0.5 flex items-center gap-2 font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">
                                            <i data-lucide="calendar" class="h-3 w-3 text-sky-300/70"></i>
                                            {{ $assessment->assessment_date->format('d-m-Y') }}
                                        </div>
                                    </div>
                                </div>

                                {{-- ACTIONS (hanya jika notes ada — sesuai logika asli) --}}
                                @if ($assessment->notes)
                                    <div class="flex items-center gap-2">
                                        <a
                                            href="{{ route('admin.assessments.edit', $assessment) }}"
                                            class="inline-flex items-center gap-2 rounded-xl border border-sky-300/20 bg-sky-400/[0.08] px-3 py-2 text-[10px] font-bold uppercase tracking-[0.14em] text-sky-200 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/40 hover:bg-sky-400/[0.15] hover:text-sky-100"
                                        >
                                            <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.assessments.destroy', $assessment) }}"
                                            method="POST"
                                            class="inline"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                onclick="return confirm('Hapus penilaian ini?')"
                                                class="inline-flex items-center gap-2 rounded-xl border border-red-400/25 bg-red-500/[0.08] px-3 py-2 text-[10px] font-bold uppercase tracking-[0.14em] text-red-200 transition duration-300 hover:-translate-y-0.5 hover:border-red-300/50 hover:bg-red-500/[0.15] hover:text-red-100"
                                            >
                                                <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif

                            </div>

                            {{-- SCORES GRID --}}
                            <div class="mt-5 grid gap-2 sm:grid-cols-2 lg:grid-cols-3">

                                <div class="score-cell rounded-xl border border-sky-200/[0.07] bg-black/15 px-3 py-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">Disiplin</span>
                                        <i data-lucide="shield" class="h-3 w-3 text-sky-300/70"></i>
                                    </div>
                                    <div class="mt-1 text-base font-bold text-sky-100">{{ $assessment->discipline }}</div>
                                </div>

                                <div class="score-cell rounded-xl border border-sky-200/[0.07] bg-black/15 px-3 py-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">Tanggung Jawab</span>
                                        <i data-lucide="target" class="h-3 w-3 text-cyan-300/70"></i>
                                    </div>
                                    <div class="mt-1 text-base font-bold text-cyan-100">{{ $assessment->responsibility }}</div>
                                </div>

                                <div class="score-cell rounded-xl border border-sky-200/[0.07] bg-black/15 px-3 py-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">Kerja Sama</span>
                                        <i data-lucide="handshake" class="h-3 w-3 text-blue-300/70"></i>
                                    </div>
                                    <div class="mt-1 text-base font-bold text-blue-100">{{ $assessment->teamwork }}</div>
                                </div>

                                <div class="score-cell rounded-xl border border-sky-200/[0.07] bg-black/15 px-3 py-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">Komunikasi</span>
                                        <i data-lucide="message-square" class="h-3 w-3 text-teal-300/70"></i>
                                    </div>
                                    <div class="mt-1 text-base font-bold text-teal-100">{{ $assessment->communication }}</div>
                                </div>

                                <div class="score-cell rounded-xl border border-sky-200/[0.07] bg-black/15 px-3 py-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">Inisiatif</span>
                                        <i data-lucide="lightbulb" class="h-3 w-3 text-sky-300/70"></i>
                                    </div>
                                    <div class="mt-1 text-base font-bold text-sky-100">{{ $assessment->initiative }}</div>
                                </div>

                                <div class="score-cell rounded-xl border border-sky-200/[0.07] bg-black/15 px-3 py-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">Kualitas Kerja</span>
                                        <i data-lucide="award" class="h-3 w-3 text-cyan-300/70"></i>
                                    </div>
                                    <div class="mt-1 text-base font-bold text-cyan-100">{{ $assessment->work_quality }}</div>
                                </div>

                            </div>

                            {{-- NOTES (hanya jika ada) --}}
                            @if ($assessment->notes)
                                <div class="mt-4 rounded-xl border border-sky-200/[0.07] bg-black/15 p-3">
                                    <div class="flex items-center gap-2 font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">
                                        <i data-lucide="message-square-text" class="h-3 w-3 text-blue-300/70"></i>
                                        Catatan
                                    </div>
                                    <p class="mt-1.5 text-xs leading-6 text-slate-300">
                                        {{ $assessment->notes }}
                                    </p>
                                </div>
                            @endif

                        </div>
                    </article>

                @empty
                    <div data-anim class="rounded-2xl border border-sky-200/[0.08] bg-[#0f1b2c]/60 p-10 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-sky-300/15 bg-sky-300/[0.08]">
                            <i data-lucide="clipboard-x" class="h-6 w-6 text-sky-300"></i>
                        </div>
                        <p class="mt-4 font-mono text-[10px] uppercase tracking-[0.18em] text-slate-500">
                            Belum ada penilaian.
                        </p>
                        <a
                            href="{{ route('admin.assessments.create') }}"
                            class="mt-5 inline-flex items-center gap-2 rounded-xl border border-sky-300/20 bg-sky-400/[0.08] px-4 py-2.5 text-[10px] font-bold uppercase tracking-[0.14em] text-sky-200 transition duration-300 hover:-translate-y-0.5 hover:border-sky-300/40 hover:bg-sky-400/[0.15] hover:text-sky-100"
                        >
                            <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                            Tambah Penilaian Pertama
                        </a>
                    </div>
                @endforelse

            </div>
        </section>


        {{-- FOOTER NOTE --}}
        <div data-anim class="mt-14 flex items-center justify-center gap-3 font-mono text-[9px] text-slate-600">
            <span class="text-teal-300">●</span>
            assessment.list.loaded
            <span class="text-slate-700">/</span>
            <span class="text-sky-300/80">database.connected</span>
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

                /* MAGNETIC BUTTONS */
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