<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kelola data siswa Praktik Kerja Lapangan — PRAKERIN DISKOMINFO PACITAN.">
    <meta name="theme-color" content="#f5f7fa">

    <title>Data Siswa — Admin PRAKERIN</title>

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        document.documentElement.classList.add('gsap-init');
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        html.gsap-init [data-anim] {
            opacity: 0;
        }

        @keyframes shimmer {
            0% {
                background-position: 0% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        .shimmer-text {
            background-size: 200% auto;
            animation: shimmer 6s linear infinite;
        }

        .orb {
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
        }

        .orb-1 {
            background: radial-gradient(
                circle,
                rgba(65, 107, 158, 0.15) 0%,
                rgba(65, 107, 158, 0.06) 40%,
                transparent 75%
            );
        }

        .orb-2 {
            background: radial-gradient(
                circle,
                rgba(125, 211, 252, 0.18) 0%,
                rgba(125, 211, 252, 0.05) 42%,
                transparent 75%
            );
        }

        .grid-mask {
            -webkit-mask-image: linear-gradient(to bottom, black, transparent 85%);
            mask-image: linear-gradient(to bottom, black, transparent 85%);
        }

        .student-card {
            transition:
                border-color 200ms ease,
                box-shadow 200ms ease,
                transform 200ms ease;
        }

        .action-button {
            transition:
                color 180ms ease,
                background-color 180ms ease,
                border-color 180ms ease,
                transform 180ms ease;
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
</head>

<body class="min-h-screen overflow-x-hidden bg-[#f5f7fa] text-[#263449] antialiased selection:bg-[#416b9e]/15">

    {{-- BACKGROUND --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="orb orb-1 absolute -left-40 -top-40 h-[480px] w-[480px] rounded-full"></div>

        <div class="orb orb-2 absolute -right-40 top-[15%] h-[460px] w-[460px] rounded-full"></div>

        <div class="grid-mask absolute inset-0 opacity-70 [background-image:linear-gradient(#e6ecf4_1px,transparent_1px),linear-gradient(90deg,#e6ecf4_1px,transparent_1px)] [background-size:56px_56px]"></div>

        <div class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2 bg-gradient-to-r from-transparent via-[#416b9e]/40 to-transparent"></div>
    </div>


    <main class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 sm:pt-14 lg:px-8 lg:pb-28">

        {{-- HEADER --}}
        <section class="relative">

            <div class="flex flex-col justify-between gap-7 sm:flex-row sm:items-end">

                <div>
                    <div
                        data-anim
                        class="mb-5 inline-flex items-center gap-2 rounded-full border border-[#dce6f2] bg-white/80 px-3 py-1.5 shadow-sm"
                    >
                        <i data-lucide="database" class="h-3.5 w-3.5 text-[#365b88]"></i>

                        <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-[#365b88]">
                            admin.students.management
                        </span>
                    </div>

                    <h1
                        data-anim
                        class="text-4xl font-black leading-[0.98] tracking-[-0.05em] text-[#263449] sm:text-5xl lg:text-6xl"
                    >
                        DATA

                        <span class="shimmer-text block bg-gradient-to-r from-[#243f63] via-[#416b9e] to-sky-500 bg-clip-text text-transparent">
                            SISWA PKL
                        </span>
                    </h1>

                    <p data-anim class="mt-5 max-w-xl text-sm leading-7 text-[#718096]">
                        Kelola data peserta Praktik Kerja Lapangan dalam satu tempat.
                        Pantau informasi siswa dan perbarui data dengan mudah.
                    </p>
                </div>


                {{-- ADD STUDENT --}}
                <a
                    data-anim
                    href="{{ route('admin.students.create') }}"
                    class="group inline-flex shrink-0 items-center justify-center gap-2.5 rounded-xl bg-gradient-to-r from-[#243f63] to-[#416b9e] px-5 py-3.5 text-xs font-bold uppercase tracking-[0.12em] text-white shadow-lg shadow-[#243f63]/15 transition duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-[#243f63]/20 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-[#416b9e]/20"
                >
                    <i data-lucide="user-round-plus" class="h-4 w-4 transition-transform duration-300 group-hover:scale-110"></i>
                    Tambah Siswa
                    <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:translate-x-0.5"></i>
                </a>

            </div>

            <div data-anim class="mt-8 h-px w-full bg-gradient-to-r from-[#416b9e]/30 via-[#416b9e]/10 to-transparent"></div>

        </section>


        {{-- FLASH MESSAGE --}}
        @if (session('success'))
            <div
                data-anim
                class="success-message mt-7 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-white p-4 shadow-sm"
                role="status"
                aria-live="polite"
            >
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="check-circle-2" class="h-5 w-5"></i>
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-emerald-800">
                        Berhasil
                    </p>

                    <p class="mt-1 text-xs leading-5 text-emerald-700">
                        {{ session('success') }}
                    </p>
                </div>

                <i data-lucide="badge-check" class="mt-1 h-4 w-4 shrink-0 text-emerald-500"></i>
            </div>
        @endif


        {{-- SECTION LABEL --}}
        <section class="mt-10">

            <div data-anim class="mb-5 flex items-center gap-3">
                <span class="font-mono text-[10px] font-bold uppercase tracking-[0.18em] text-[#718096]">
                    student.directory
                </span>

                <span class="h-px flex-1 bg-[#e0e7f0]"></span>

                <span class="font-mono text-[9px] text-[#9aa7b8]">
                    RECORDS
                </span>
            </div>


            {{-- STUDENT LIST CARD --}}
            <div
                data-anim
                class="overflow-hidden rounded-2xl border border-[#e0e7f0] bg-white shadow-[0_8px_35px_-20px_rgba(36,63,99,0.2)]"
            >

                {{-- CARD HEADER --}}
                <div class="flex flex-col gap-3 border-b border-[#edf1f6] px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#dce6f2] bg-[#f1f6fc]">
                            <i data-lucide="users-round" class="h-5 w-5 text-[#365b88]"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-bold text-[#263449]">
                                Daftar Siswa
                            </h2>

                            <p class="mt-1 text-[11px] text-[#8390a1]">
                                Data peserta Praktik Kerja Lapangan
                            </p>
                        </div>
                    </div>

                    <div class="inline-flex w-fit items-center gap-2 rounded-full border border-[#e0e7f0] bg-[#f8fafc] px-3 py-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#416b9e]"></span>

                        <span class="font-mono text-[9px] font-bold uppercase tracking-[0.12em] text-[#718096]">
                            {{ $students->count() }} data ditampilkan
                        </span>
                    </div>

                </div>


                {{-- EMPTY STATE --}}
                @if ($students->isEmpty())

                    <div class="empty-state px-5 py-16 text-center sm:px-8 sm:py-20">

                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl border border-[#e0e7f0] bg-[#f8fafc]">
                            <i data-lucide="folder-open" class="h-9 w-9 text-[#9aa7b8]"></i>
                        </div>

                        <h3 class="mt-6 text-lg font-bold text-[#3b4d65]">
                            Belum Ada Data Siswa
                        </h3>

                        <p class="mx-auto mt-2 max-w-sm text-xs leading-6 text-[#8390a1]">
                            Data siswa PKL belum tersedia. Tambahkan siswa untuk mulai mengelola data peserta.
                        </p>

                        <a
                            href="{{ route('admin.students.create') }}"
                            class="mt-6 inline-flex items-center gap-2 rounded-xl bg-[#243f63] px-4 py-3 text-xs font-bold text-white transition hover:bg-[#365b88] focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-[#416b9e]/20"
                        >
                            <i data-lucide="plus" class="h-4 w-4"></i>
                            Tambah Siswa Pertama
                        </a>

                    </div>

                @else

                    {{-- DESKTOP TABLE --}}
                    <div class="hidden overflow-x-auto md:block">
                        <table class="w-full border-collapse text-left">

                            <thead>
                                <tr class="border-b border-[#edf1f6] bg-[#f8fafc]">
                                    <th class="px-6 py-4 font-mono text-[9px] font-bold uppercase tracking-[0.14em] text-[#8390a1]">
                                        Siswa
                                    </th>

                                    <th class="px-6 py-4 font-mono text-[9px] font-bold uppercase tracking-[0.14em] text-[#8390a1]">
                                        Jurusan
                                    </th>

                                    <th class="px-6 py-4 font-mono text-[9px] font-bold uppercase tracking-[0.14em] text-[#8390a1]">
                                        Status
                                    </th>

                                    <th class="px-6 py-4 text-right font-mono text-[9px] font-bold uppercase tracking-[0.14em] text-[#8390a1]">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-[#edf1f6]">

                                @foreach ($students as $student)

                                    <tr
                                        class="student-card group"
                                        data-student-row
                                    >
                                        {{-- STUDENT --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">

                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#dce6f2] bg-gradient-to-br from-[#f1f6fc] to-[#e8eff8] text-sm font-black uppercase text-[#365b88]">
                                                    {{ mb_substr($student->name, 0, 1) }}
                                                </div>

                                                <div class="min-w-0">
                                                    <p class="truncate text-sm font-bold text-[#34445a] transition group-hover:text-[#365b88]">
                                                        {{ $student->name }}
                                                    </p>

                                                    <p class="mt-1 font-mono text-[9px] uppercase tracking-[0.08em] text-[#a0aaba]">
                                                        Student record
                                                    </p>
                                                </div>

                                            </div>
                                        </td>


                                        {{-- MAJOR --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2.5">
                                                <i data-lucide="graduation-cap" class="h-4 w-4 shrink-0 text-[#8390a1]"></i>

                                                <span class="text-xs font-medium text-[#5f6f84]">
                                                    {{ $student->major }}
                                                </span>
                                            </div>
                                        </td>


                                        {{-- STATUS --}}
                                        <td class="px-6 py-4">
                                            @php
                                                $studentStatus = strtolower(trim((string) $student->status));
                                                $isActive = $studentStatus === 'active';
                                            @endphp

                                            <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-[10px] font-bold
                                                {{ $isActive
                                                    ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                                                    : 'border-[#dce6f2] bg-[#f1f6fc] text-[#536b8b]' }}"
                                            >
                                                <span class="h-1.5 w-1.5 rounded-full {{ $isActive ? 'bg-emerald-500' : 'bg-[#7890b1]' }}"></span>

                                                {{ $student->status }}
                                            </span>
                                        </td>


                                        {{-- ACTIONS --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-end gap-2">

                                                <a
                                                    href="{{ route('admin.students.edit', $student) }}"
                                                    class="action-button inline-flex items-center gap-2 rounded-lg border border-[#dce6f2] bg-white px-3 py-2 text-[10px] font-bold text-[#365b88] hover:border-[#b9cbe0] hover:bg-[#f1f6fc] focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-[#416b9e]/15"
                                                    aria-label="Edit data {{ $student->name }}"
                                                >
                                                    <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('admin.students.destroy', $student) }}"
                                                    method="POST"
                                                    class="delete-form"
                                                    data-student-name="{{ $student->name }}"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="action-button inline-flex items-center gap-2 rounded-lg border border-red-100 bg-white px-3 py-2 text-[10px] font-bold text-red-600 hover:border-red-200 hover:bg-red-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-red-500/10"
                                                        aria-label="Hapus data {{ $student->name }}"
                                                    >
                                                        <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                                        Hapus
                                                    </button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>


                    {{-- MOBILE CARDS --}}
                    <div class="divide-y divide-[#edf1f6] md:hidden">

                        @foreach ($students as $student)

                            @php
                                $studentStatus = strtolower(trim((string) $student->status));
                                $isActive = $studentStatus === 'active';
                            @endphp

                            <article class="mobile-student-card p-5" data-student-row>

                                <div class="flex items-start gap-3">

                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#dce6f2] bg-gradient-to-br from-[#f1f6fc] to-[#e8eff8] text-sm font-black uppercase text-[#365b88]">
                                        {{ mb_substr($student->name, 0, 1) }}
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <h3 class="break-words text-sm font-bold text-[#34445a]">
                                            {{ $student->name }}
                                        </h3>

                                        <p class="mt-1.5 flex items-start gap-2 text-xs leading-5 text-[#718096]">
                                            <i data-lucide="graduation-cap" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-[#8390a1]"></i>
                                            {{ $student->major }}
                                        </p>

                                        <div class="mt-3">
                                            <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-[10px] font-bold
                                                {{ $isActive
                                                    ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                                                    : 'border-[#dce6f2] bg-[#f1f6fc] text-[#536b8b]' }}"
                                            >
                                                <span class="h-1.5 w-1.5 rounded-full {{ $isActive ? 'bg-emerald-500' : 'bg-[#7890b1]' }}"></span>
                                                {{ $student->status }}
                                            </span>
                                        </div>
                                    </div>

                                </div>


                                <div class="mt-5 grid grid-cols-2 gap-2">

                                    <a
                                        href="{{ route('admin.students.edit', $student) }}"
                                        class="action-button inline-flex items-center justify-center gap-2 rounded-xl border border-[#dce6f2] bg-[#f8fafc] px-3 py-3 text-xs font-bold text-[#365b88] hover:bg-[#f1f6fc] focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-[#416b9e]/15"
                                    >
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.students.destroy', $student) }}"
                                        method="POST"
                                        class="delete-form"
                                        data-student-name="{{ $student->name }}"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-button inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-100 bg-white px-3 py-3 text-xs font-bold text-red-600 hover:border-red-200 hover:bg-red-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-red-500/10"
                                        >
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                            Hapus
                                        </button>
                                    </form>

                                </div>

                            </article>

                        @endforeach

                    </div>

                @endif

                {{-- CARD FOOTER --}}
                <div class="flex flex-col gap-2 border-t border-[#edf1f6] bg-[#fbfcfe] px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">

                    <p class="flex items-center gap-2 text-[10px] text-[#8390a1]">
                        <i data-lucide="database" class="h-3.5 w-3.5"></i>
                        Sistem Pendataan Siswa PKL
                    </p>

                    <p class="font-mono text-[9px] text-[#a0aaba]">
                        PRAKERIN / DISKOMINFO PACITAN
                    </p>

                </div>

            </div>

        </section>


        {{-- FOOTER --}}
        <footer data-anim class="mt-10 flex flex-col items-center justify-between gap-3 sm:flex-row">

            <p class="text-[10px] text-[#9aa7b8]">
                &copy; {{ date('Y') }} DISKOMINFO Kabupaten Pacitan
            </p>

            <div class="flex items-center gap-2 font-mono text-[9px] text-[#8390a1]">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                admin.students.management
            </div>

        </footer>

    </main>


    {{-- ICONS + ANIMATIONS + DELETE CONFIRMATION --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var root = document.documentElement;

            function showContent() {
                root.classList.remove('gsap-init');

                document.querySelectorAll('[data-anim]').forEach(function (el) {
                    el.style.opacity = '';
                    el.style.transform = '';
                    el.style.visibility = '';
                });
            }

            // Lucide icons
            if (window.lucide && typeof window.lucide.createIcons === 'function') {
                window.lucide.createIcons({
                    attrs: {
                        'stroke-width': 1.8
                    }
                });
            }

            // Delete confirmation
            document.querySelectorAll('.delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    var name = form.dataset.studentName || 'siswa ini';

                    var confirmed = window.confirm(
                        'Yakin ingin menghapus data ' + name + '? Tindakan ini tidak dapat dibatalkan.'
                    );

                    if (!confirmed) {
                        event.preventDefault();
                    }
                });
            });

            // GSAP fallback
            if (!window.gsap) {
                showContent();
                return;
            }

            var prefersReducedMotion = window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;

            if (prefersReducedMotion) {
                showContent();
                return;
            }

            try {
                gsap.config({
                    force3D: true
                });

                var timeline = gsap.timeline({
                    defaults: {
                        ease: 'power3.out'
                    },
                    onComplete: function () {
                        document.querySelectorAll('[data-anim]').forEach(function (el) {
                            el.style.opacity = '';
                            el.style.transform = '';
                        });
                    }
                });

                timeline.from('[data-anim]', {
                    y: 20,
                    opacity: 0,
                    duration: 0.55,
                    stagger: {
                        each: 0.045,
                        from: 'start'
                    }
                });

                root.classList.remove('gsap-init');

                // Ambient background
                gsap.to('.orb-1', {
                    x: 30,
                    y: 25,
                    duration: 14,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });

                gsap.to('.orb-2', {
                    x: -25,
                    y: 30,
                    duration: 16,
                    repeat: -1,
                    yoyo: true,
                    ease: 'sine.inOut'
                });

                // Student row entrance
                gsap.from('[data-student-row]', {
                    y: 10,
                    opacity: 0,
                    duration: 0.4,
                    stagger: 0.045,
                    delay: 0.15,
                    ease: 'power2.out',
                    clearProps: 'all'
                });

            } catch (error) {
                console.warn('[gsap] animation error — showing content', error);
                showContent();
            }

            // Safety net
            window.setTimeout(showContent, 1800);
        });
    </script>

</body>
</html>