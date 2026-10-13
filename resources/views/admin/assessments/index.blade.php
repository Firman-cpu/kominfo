<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kelola data penilaian siswa PRAKERIN DISKOMINFO Pacitan.">
    <meta name="theme-color" content="#f5f7fa">

    <title>Penilaian Siswa — PRAKERIN DISKOMINFO</title>

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
</head>

<body class="min-h-screen overflow-x-hidden bg-[#f5f7fa] text-[#263449] antialiased selection:bg-blue-200 selection:text-[#243f63]">

    {{-- BACKGROUND --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-40 -top-40 h-[460px] w-[460px] rounded-full bg-sky-200/40 blur-[100px]"></div>
        <div class="absolute -right-40 top-[18%] h-[460px] w-[460px] rounded-full bg-blue-200/30 blur-[110px]"></div>
        <div class="absolute -bottom-64 left-[35%] h-[460px] w-[460px] rounded-full bg-indigo-100/60 blur-[110px]"></div>

        <div class="absolute inset-0 bg-[linear-gradient(to_right,#365b88_1px,transparent_1px),linear-gradient(to_bottom,#365b88_1px,transparent_1px)] bg-[size:56px_56px] opacity-[0.035]"></div>

        <div class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2 bg-gradient-to-r from-transparent via-blue-400/50 to-transparent"></div>
    </div>


    <main class="relative mx-auto max-w-6xl px-4 pb-16 pt-8 sm:px-6 sm:pt-12 lg:px-8 lg:pb-24">

        {{-- BACK BUTTON --}}
        <a
            data-anim
            href="{{ route('admin.dashboard.page') }}"
            class="group inline-flex items-center gap-2.5 rounded-full border border-[#dce5f0] bg-white/90 px-4 py-2.5 shadow-sm shadow-slate-200/40 transition duration-300 hover:-translate-y-0.5 hover:border-blue-300 hover:shadow-md hover:shadow-blue-100/70"
        >
            <i data-lucide="arrow-left" class="h-4 w-4 text-[#365b88] transition-transform duration-300 group-hover:-translate-x-1"></i>

            <span class="text-xs font-bold tracking-wide text-[#365b88]">
                Kembali ke Dashboard
            </span>
        </a>


        {{-- PAGE HEADER --}}
        <section class="mt-8">

            <div class="grid items-end gap-6 lg:grid-cols-[1fr_auto]">

                <div>
                    <div
                        data-anim
                        class="mb-5 inline-flex items-center gap-2 rounded-full border border-[#dce7f4] bg-white px-3.5 py-2 shadow-sm"
                    >
                        <i data-lucide="clipboard-list" class="h-4 w-4 text-[#416b9e]"></i>

                        <span class="font-mono text-[10px] font-bold uppercase tracking-[0.16em] text-[#416b9e]">
                            assessment.records
                        </span>
                    </div>

                    <h1
                        data-anim
                        class="max-w-3xl text-4xl font-black leading-[0.95] tracking-tight text-[#243f63] sm:text-5xl lg:text-6xl"
                    >
                        PENILAIAN
                        <span class="mt-1 block bg-gradient-to-r from-[#365b88] via-[#416b9e] to-sky-500 bg-clip-text text-transparent">
                            SISWA
                        </span>
                    </h1>

                    <p data-anim class="mt-5 max-w-xl text-sm leading-7 text-[#718096] sm:text-base">
                        Kelola seluruh data penilaian siswa Praktik Kerja Lapangan.
                        Pantau enam aspek kompetensi, perbarui nilai, dan dokumentasikan catatan pembimbing.
                    </p>
                </div>


                {{-- ADD BUTTON --}}
                <a
                    data-anim
                    href="{{ route('admin.assessments.create') }}"
                    class="btn-magnetic group inline-flex min-h-12 items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-[#243f63] via-[#365b88] to-[#416b9e] px-5 py-3.5 text-xs font-bold uppercase tracking-[0.12em] text-white shadow-lg shadow-blue-900/15 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-900/20"
                >
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Tambah Penilaian
                    <i data-lucide="arrow-up-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"></i>
                </a>

            </div>

            <div data-anim class="mt-8 h-px w-full bg-gradient-to-r from-[#365b88]/30 via-blue-200 to-transparent"></div>
        </section>


        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div
                data-anim
                role="status"
                class="mt-6 overflow-hidden rounded-2xl border border-emerald-200 bg-emerald-50/90 p-4 sm:p-5"
            >
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm">
                        <i data-lucide="check-circle-2" class="h-5 w-5"></i>
                    </div>

                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-extrabold uppercase tracking-[0.12em] text-emerald-800">
                            Berhasil
                        </h2>

                        <p class="mt-1 text-sm leading-6 text-emerald-700">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif


        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())
            <div
                data-anim
                role="alert"
                class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-5"
            >
                <div class="flex items-start gap-3">
                    <i data-lucide="alert-circle" class="mt-0.5 h-5 w-5 shrink-0 text-red-600"></i>

                    <div>
                        <h2 class="text-sm font-bold text-red-800">
                            Terdapat kesalahan
                        </h2>

                        <ul class="mt-2 list-inside list-disc space-y-1 text-sm leading-6 text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif


        {{-- LIST SECTION --}}
        <section class="mt-8">

            <div data-anim class="mb-5 flex flex-wrap items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-[#e0e7f0] bg-white text-[#365b88] shadow-sm">
                    <i data-lucide="files" class="h-4 w-4"></i>
                </div>

                <div>
                    <h2 class="text-sm font-extrabold text-[#263449]">
                        Daftar Penilaian
                    </h2>

                    <p class="mt-0.5 text-xs text-[#8390a1]">
                        Seluruh data hasil evaluasi siswa.
                    </p>
                </div>

                <div class="ml-auto inline-flex items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1.5">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                    <span class="text-[10px] font-bold uppercase tracking-[0.12em] text-emerald-700">
                        Data Penilaian
                    </span>
                </div>
            </div>


            {{-- ASSESSMENT CARDS --}}
            <div class="space-y-4">

                @forelse ($assessments as $assessment)

                    <article
                        data-anim
                        class="assess-card group relative overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white p-5 shadow-sm shadow-slate-200/40 transition duration-300 hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-lg hover:shadow-blue-100/50 sm:p-6"
                    >
                        <div class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-blue-50/80 blur-3xl transition duration-500 group-hover:bg-sky-100/80"></div>

                        <div class="relative">

                            {{-- STUDENT HEADER --}}
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex min-w-0 items-center gap-3.5">

                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#243f63] via-[#365b88] to-[#6090c6] text-lg font-black text-white shadow-md shadow-blue-900/15">
                                        {{ strtoupper(substr($assessment->student->name ?? '?', 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">
                                        <h3 class="break-words text-base font-extrabold text-[#263449] sm:text-lg">
                                            {{ $assessment->student->name ?? 'Siswa tidak ditemukan' }}
                                        </h3>

                                        <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-[#8390a1]">
                                            <span class="inline-flex items-center gap-1.5">
                                                <i data-lucide="calendar-days" class="h-3.5 w-3.5 text-[#416b9e]"></i>

                                                {{ $assessment->assessment_date
                                                    ? \Illuminate\Support\Carbon::parse($assessment->assessment_date)->format('d M Y')
                                                    : 'Tanggal tidak tersedia'
                                                }}
                                            </span>

                                            @if ($assessment->student && $assessment->student->nis)
                                                <span class="inline-flex items-center gap-1.5">
                                                    <i data-lucide="contact-round" class="h-3.5 w-3.5 text-[#416b9e]"></i>
                                                    NIS: {{ $assessment->student->nis }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                {{-- ACTIONS --}}
                                <div class="flex shrink-0 items-center gap-2">

                                    <a
                                        href="{{ route('admin.assessments.edit', $assessment) }}"
                                        aria-label="Edit penilaian {{ $assessment->student->name ?? 'siswa' }}"
                                        class="inline-flex min-h-10 flex-1 items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-3.5 py-2 text-xs font-bold text-[#365b88] transition duration-200 hover:border-blue-300 hover:bg-blue-100 sm:flex-none"
                                    >
                                        <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.assessments.destroy', $assessment) }}"
                                        method="POST"
                                        class="delete-form flex-1 sm:flex-none"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            aria-label="Hapus penilaian {{ $assessment->student->name ?? 'siswa' }}"
                                            class="inline-flex min-h-10 w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-3.5 py-2 text-xs font-bold text-red-700 transition duration-200 hover:border-red-300 hover:bg-red-100 sm:w-auto"
                                        >
                                            <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </div>


                            {{-- SCORES --}}
                            <div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">

                                {{-- DISCIPLINE --}}
                                <div class="rounded-xl border border-[#e6edf5] bg-[#f8fafc] p-3.5 transition duration-200 hover:border-blue-200 hover:bg-blue-50/50">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-[0.1em] text-[#718096]">
                                            Kedisiplinan
                                        </span>

                                        <i data-lucide="shield-check" class="h-4 w-4 text-blue-600"></i>
                                    </div>

                                    <div class="mt-2 text-2xl font-black text-[#243f63]">
                                        {{ $assessment->discipline }}
                                    </div>
                                </div>


                                {{-- RESPONSIBILITY --}}
                                <div class="rounded-xl border border-[#e6edf5] bg-[#f8fafc] p-3.5 transition duration-200 hover:border-cyan-200 hover:bg-cyan-50/50">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-[0.1em] text-[#718096]">
                                            Tanggung Jawab
                                        </span>

                                        <i data-lucide="target" class="h-4 w-4 text-cyan-600"></i>
                                    </div>

                                    <div class="mt-2 text-2xl font-black text-cyan-800">
                                        {{ $assessment->responsibility }}
                                    </div>
                                </div>


                                {{-- TEAMWORK --}}
                                <div class="rounded-xl border border-[#e6edf5] bg-[#f8fafc] p-3.5 transition duration-200 hover:border-indigo-200 hover:bg-indigo-50/50">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-[0.1em] text-[#718096]">
                                            Kerja Sama
                                        </span>

                                        <i data-lucide="handshake" class="h-4 w-4 text-indigo-600"></i>
                                    </div>

                                    <div class="mt-2 text-2xl font-black text-indigo-800">
                                        {{ $assessment->teamwork }}
                                    </div>
                                </div>


                                {{-- COMMUNICATION --}}
                                <div class="rounded-xl border border-[#e6edf5] bg-[#f8fafc] p-3.5 transition duration-200 hover:border-teal-200 hover:bg-teal-50/50">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-[0.1em] text-[#718096]">
                                            Komunikasi
                                        </span>

                                        <i data-lucide="messages-square" class="h-4 w-4 text-teal-600"></i>
                                    </div>

                                    <div class="mt-2 text-2xl font-black text-teal-800">
                                        {{ $assessment->communication }}
                                    </div>
                                </div>


                                {{-- INITIATIVE --}}
                                <div class="rounded-xl border border-[#e6edf5] bg-[#f8fafc] p-3.5 transition duration-200 hover:border-amber-200 hover:bg-amber-50/50">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-[0.1em] text-[#718096]">
                                            Inisiatif
                                        </span>

                                        <i data-lucide="lightbulb" class="h-4 w-4 text-amber-600"></i>
                                    </div>

                                    <div class="mt-2 text-2xl font-black text-amber-800">
                                        {{ $assessment->initiative }}
                                    </div>
                                </div>


                                {{-- WORK QUALITY --}}
                                <div class="rounded-xl border border-[#e6edf5] bg-[#f8fafc] p-3.5 transition duration-200 hover:border-sky-200 hover:bg-sky-50/50">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-[0.1em] text-[#718096]">
                                            Kualitas Kerja
                                        </span>

                                        <i data-lucide="award" class="h-4 w-4 text-sky-600"></i>
                                    </div>

                                    <div class="mt-2 text-2xl font-black text-sky-800">
                                        {{ $assessment->work_quality }}
                                    </div>
                                </div>

                            </div>


                            {{-- NOTES --}}
                            @if ($assessment->notes)
                                <div class="mt-4 rounded-xl border border-amber-200/80 bg-amber-50/70 p-4">
                                    <div class="flex items-center gap-2">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-amber-700 shadow-sm">
                                            <i data-lucide="notebook-pen" class="h-4 w-4"></i>
                                        </div>

                                        <h4 class="text-xs font-extrabold text-amber-900">
                                            Catatan Pembimbing
                                        </h4>
                                    </div>

                                    <p class="mt-3 whitespace-pre-line text-sm leading-7 text-[#64748b]">
                                        {{ $assessment->notes }}
                                    </p>
                                </div>
                            @else
                                <div class="mt-4 flex items-center gap-2 rounded-xl border border-dashed border-[#e0e7f0] px-4 py-3 text-xs text-[#9aa5b4]">
                                    <i data-lucide="notebook-text" class="h-4 w-4"></i>
                                    Belum ada catatan pembimbing.
                                </div>
                            @endif

                        </div>
                    </article>

                @empty

                    {{-- EMPTY STATE --}}
                    <div
                        data-anim
                        class="rounded-2xl border border-dashed border-[#d6e0ec] bg-white/90 px-5 py-12 text-center shadow-sm shadow-slate-200/30"
                    >
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#f0f5fb] text-[#416b9e]">
                            <i data-lucide="clipboard-x" class="h-7 w-7"></i>
                        </div>

                        <h3 class="mt-5 text-base font-extrabold text-[#263449]">
                            Belum Ada Penilaian
                        </h3>

                        <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-[#8390a1]">
                            Data penilaian siswa belum tersedia. Tambahkan penilaian pertama untuk mulai memantau perkembangan kompetensi siswa.
                        </p>

                        <a
                            href="{{ route('admin.assessments.create') }}"
                            class="mt-6 inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#243f63] to-[#416b9e] px-5 py-3 text-xs font-bold text-white shadow-md shadow-blue-900/10 transition duration-200 hover:-translate-y-0.5 hover:shadow-lg"
                        >
                            <i data-lucide="plus" class="h-4 w-4"></i>
                            Tambah Penilaian Pertama
                        </a>
                    </div>

                @endforelse

            </div>
        </section>


        {{-- FOOTER --}}
        <footer
            data-anim
            class="mt-12 flex flex-col items-center justify-center gap-2 border-t border-[#e0e7f0] pt-7 text-center sm:flex-row sm:gap-3"
        >
            <span class="inline-flex items-center gap-2 text-[10px] font-semibold text-[#718096]">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                Assessment Records
            </span>

            <span class="hidden text-[#cbd5e1] sm:inline">/</span>

            <span class="text-[10px] text-[#9aa5b4]">
                PRAKERIN — DISKOMINFO PACITAN
            </span>

            <span class="hidden text-[#cbd5e1] sm:inline">/</span>

            <span class="text-[10px] font-semibold text-[#416b9e]">
                Student Evaluation
            </span>
        </footer>

    </main>


    {{-- ICONS & ANIMATIONS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            'use strict';

            /*
             * LUCIDE ICONS
             */
            if (
                window.lucide &&
                typeof window.lucide.createIcons === 'function'
            ) {
                window.lucide.createIcons({
                    attrs: {
                        'stroke-width': 1.8
                    }
                });
            }


            /*
             * DELETE CONFIRMATION
             */
            document.querySelectorAll('.delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    var confirmed = window.confirm(
                        'Apakah kamu yakin ingin menghapus penilaian ini? Data yang dihapus tidak dapat dikembalikan.'
                    );

                    if (!confirmed) {
                        event.preventDefault();
                    }
                });
            });


            /*
             * GSAP ENTRANCE ANIMATION
             *
             * Konten tidak disembunyikan saat halaman dimuat.
             * Jika GSAP gagal dimuat, halaman tetap bisa digunakan.
             */
            if (!window.gsap) {
                return;
            }

            try {
                gsap.config({
                    force3D: true
                });

                gsap.ticker.lagSmoothing(500, 33);

                gsap.from('[data-anim]', {
                    y: 18,
                    opacity: 0,
                    duration: 0.6,
                    stagger: 0.035,
                    ease: 'power3.out',
                    clearProps: 'transform,opacity'
                });


                /*
                 * BUTTON MAGNETIC EFFECT
                 */
                var prefersReducedMotion = window.matchMedia(
                    '(prefers-reduced-motion: reduce)'
                ).matches;

                if (!prefersReducedMotion) {
                    document.querySelectorAll('.btn-magnetic').forEach(function (button) {
                        button.addEventListener('pointermove', function (event) {
                            if (event.pointerType === 'touch') {
                                return;
                            }

                            var rect = button.getBoundingClientRect();

                            var x = event.clientX - rect.left - rect.width / 2;
                            var y = event.clientY - rect.top - rect.height / 2;

                            gsap.to(button, {
                                x: x * 0.08,
                                y: y * 0.12,
                                duration: 0.3,
                                ease: 'power2.out'
                            });
                        });

                        button.addEventListener('pointerleave', function () {
                            gsap.to(button, {
                                x: 0,
                                y: 0,
                                duration: 0.55,
                                ease: 'elastic.out(1, 0.45)'
                            });
                        });
                    });
                }

            } catch (error) {
                console.warn('[assessment] Animation initialization failed:', error);
            }
        });
    </script>

</body>
</html>