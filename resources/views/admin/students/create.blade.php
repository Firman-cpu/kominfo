<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Form tambah data siswa Praktik Kerja Lapangan DISKOMINFO Kabupaten Pacitan.">
    <meta name="theme-color" content="#f5f7fa">

    <title>Tambah Siswa — PRAKERIN DISKOMINFO PACITAN</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [data-animate] {
            opacity: 0;
            transform: translateY(18px);
        }

        .form-field {
            transition:
                border-color 0.25s ease,
                box-shadow 0.25s ease,
                background-color 0.25s ease;
        }

        .form-field:focus {
            border-color: #416b9e;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(65, 107, 158, 0.10);
            outline: none;
        }

        .submit-button {
            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                background-color 0.25s ease;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(36, 63, 99, 0.2);
        }

        .submit-button:active {
            transform: scale(0.98);
        }

        .ambient-orb {
            animation: ambientFloat 9s ease-in-out infinite;
            will-change: transform;
        }

        .ambient-orb:nth-child(2) {
            animation-delay: -4s;
            animation-duration: 12s;
        }

        @keyframes ambientFloat {
            0%, 100% {
                transform: translate3d(0, 0, 0);
            }

            50% {
                transform: translate3d(0, -18px, 0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }

            [data-animate] {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</head>

<body class="min-h-screen overflow-x-hidden bg-[#f5f7fa] text-[#263449] antialiased">

    {{-- Background decoration --}}
    <div class="pointer-events-none fixed inset-0 -z-0 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.35]"
            style="background-image: linear-gradient(rgba(54,91,136,.045) 1px, transparent 1px), linear-gradient(90deg, rgba(54,91,136,.045) 1px, transparent 1px); background-size: 36px 36px;">
        </div>

        <div class="ambient-orb absolute -right-24 -top-24 h-80 w-80 rounded-full bg-blue-200/30 blur-3xl"></div>
        <div class="ambient-orb absolute -bottom-32 -left-24 h-96 w-96 rounded-full bg-indigo-200/25 blur-3xl"></div>
    </div>

    <main class="relative z-10 mx-auto w-full max-w-5xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">

        {{-- Header --}}
        <header data-animate class="mb-8">

            <div class="flex flex-col items-center sm:flex-row sm:justify-between">
                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.22em] text-[#416b9e]">
                        Manajemen Data
                    </p>

                    <h1 class="text-3xl font-bold tracking-tight text-[#243f63] sm:text-4xl">
                        Tambah Siswa PKL
                    </h1>
                </div>
                <img
                    src="{{ asset('image/logo.png') }}"
                    alt="Logo DISKOMINFO Kabupaten Pacitan"
                    class="h-25 w-auto object-contain"
                >
            </div>
        </header>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <section data-animate
                class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5"
                role="alert">

                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                        <i data-lucide="alert-circle" class="h-5 w-5"></i>
                    </div>

                    <div class="min-w-0 flex-1">
                        <h2 class="font-semibold text-red-800">
                            Data belum dapat disimpan
                        </h2>

                        <p class="mt-1 text-sm text-red-700">
                            Periksa kembali beberapa kolom berikut.
                        </p>

                        <ul class="mt-3 space-y-1.5 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start gap-2">
                                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-red-500"></span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>
        @endif

        {{-- Main Form Card --}}
        <section data-animate
            class="overflow-hidden rounded-3xl border border-[#e0e7f0] bg-white shadow-[0_16px_50px_rgba(36,63,99,0.055)]">

            {{-- Card Header --}}
            <div class="border-b border-[#edf1f6] bg-[#fbfcfe] px-5 py-5 sm:px-8 sm:py-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eaf0f8] text-[#365b88]">
                        <i data-lucide="clipboard-list" class="h-5 w-5"></i>
                    </div>

                    <div>
                        <h2 class="font-semibold text-[#243f63]">
                            Informasi Siswa
                        </h2>

                        <p class="mt-1 text-xs text-[#8390a1]">
                            Kolom bertanda <span class="font-semibold text-red-500">*</span> wajib diisi.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.students.store') }}"
                method="POST"
                class="p-5 sm:p-8">

                @csrf

                {{-- Identitas --}}
                <div class="mb-8">
                    <div class="mb-5 flex items-center gap-2">
                        <i data-lucide="contact-round" class="h-4 w-4 text-[#416b9e]"></i>

                        <h3 class="text-sm font-bold uppercase tracking-wider text-[#365b88]">
                            Identitas Siswa
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        {{-- NIS --}}
                        <div>
                            <label for="nis"
                                class="mb-2 block text-sm font-semibold text-[#34445b]">
                                NIS
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <i data-lucide="id-card"
                                    class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8390a1]"></i>

                                <input
                                    type="text"
                                    id="nis"
                                    name="nis"
                                    value="{{ old('nis') }}"
                                    placeholder="Masukkan NIS siswa"
                                    autocomplete="off"
                                    required
                                    aria-invalid="{{ $errors->has('nis') ? 'true' : 'false' }}"
                                    class="form-field w-full rounded-xl border {{ $errors->has('nis') ? 'border-red-300 bg-red-50/40' : 'border-[#dfe6ef] bg-[#fbfcfe]' }} py-3.5 pl-11 pr-4 text-sm text-[#263449] placeholder:text-[#a1acba]">

                            </div>

                            @error('nis')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <div>
                            <label for="name"
                                class="mb-2 block text-sm font-semibold text-[#34445b]">
                                Nama Lengkap
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <i data-lucide="user-round"
                                    class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8390a1]"></i>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Masukkan nama lengkap"
                                    autocomplete="name"
                                    required
                                    aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                                    class="form-field w-full rounded-xl border {{ $errors->has('name') ? 'border-red-300 bg-red-50/40' : 'border-[#dfe6ef] bg-[#fbfcfe]' }} py-3.5 pl-11 pr-4 text-sm text-[#263449] placeholder:text-[#a1acba]">

                            </div>

                            @error('name')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jurusan --}}
                        <div>
                            <label for="major"
                                class="mb-2 block text-sm font-semibold text-[#34445b]">
                                Jurusan
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <i data-lucide="graduation-cap"
                                    class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8390a1]"></i>

                                <input
                                    type="text"
                                    id="major"
                                    name="major"
                                    value="{{ old('major') }}"
                                    placeholder="Contoh: Rekayasa Perangkat Lunak"
                                    required
                                    aria-invalid="{{ $errors->has('major') ? 'true' : 'false' }}"
                                    class="form-field w-full rounded-xl border {{ $errors->has('major') ? 'border-red-300 bg-red-50/40' : 'border-[#dfe6ef] bg-[#fbfcfe]' }} py-3.5 pl-11 pr-4 text-sm text-[#263449] placeholder:text-[#a1acba]">

                            </div>

                            @error('major')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kelas --}}
                        <div>
                            <label for="class"
                                class="mb-2 block text-sm font-semibold text-[#34445b]">
                                Kelas
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <i data-lucide="school"
                                    class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8390a1]"></i>

                                <input
                                    type="text"
                                    id="class"
                                    name="class"
                                    value="{{ old('class') }}"
                                    placeholder="Contoh: XII RPL 1"
                                    required
                                    aria-invalid="{{ $errors->has('class') ? 'true' : 'false' }}"
                                    class="form-field w-full rounded-xl border {{ $errors->has('class') ? 'border-red-300 bg-red-50/40' : 'border-[#dfe6ef] bg-[#fbfcfe]' }} py-3.5 pl-11 pr-4 text-sm text-[#263449] placeholder:text-[#a1acba]">

                            </div>

                            @error('class')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Jadwal PKL --}}
                <div class="mb-8 border-t border-[#edf1f6] pt-8">
                    <div class="mb-5 flex items-center gap-2">
                        <i data-lucide="calendar-days" class="h-4 w-4 text-[#416b9e]"></i>

                        <h3 class="text-sm font-bold uppercase tracking-wider text-[#365b88]">
                            Periode Praktik Kerja
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label for="start_date"
                                class="mb-2 block text-sm font-semibold text-[#34445b]">
                                Tanggal Mulai
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <i data-lucide="calendar-check"
                                    class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8390a1]"></i>

                                <input
                                    type="date"
                                    id="start_date"
                                    name="start_date"
                                    value="{{ old('start_date') }}"
                                    required
                                    aria-invalid="{{ $errors->has('start_date') ? 'true' : 'false' }}"
                                    class="form-field w-full rounded-xl border {{ $errors->has('start_date') ? 'border-red-300 bg-red-50/40' : 'border-[#dfe6ef] bg-[#fbfcfe]' }} py-3.5 pl-11 pr-4 text-sm text-[#263449]">

                            </div>

                            @error('start_date')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div>
                            <label for="end_date"
                                class="mb-2 block text-sm font-semibold text-[#34445b]">
                                Tanggal Selesai
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <i data-lucide="calendar-clock"
                                    class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8390a1]"></i>

                                <input
                                    type="date"
                                    id="end_date"
                                    name="end_date"
                                    value="{{ old('end_date') }}"
                                    required
                                    aria-invalid="{{ $errors->has('end_date') ? 'true' : 'false' }}"
                                    class="form-field w-full rounded-xl border {{ $errors->has('end_date') ? 'border-red-300 bg-red-50/40' : 'border-[#dfe6ef] bg-[#fbfcfe]' }} py-3.5 pl-11 pr-4 text-sm text-[#263449]">

                            </div>

                            @error('end_date')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="mb-8 border-t border-[#edf1f6] pt-8">
                    <div class="mb-5 flex items-center gap-2">
                        <i data-lucide="activity" class="h-4 w-4 text-[#416b9e]"></i>

                        <h3 class="text-sm font-bold uppercase tracking-wider text-[#365b88]">
                            Status Keikutsertaan
                        </h3>
                    </div>

                    <div>
                        <label for="status"
                            class="mb-2 block text-sm font-semibold text-[#34445b]">
                            Status Siswa
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="relative">
                            <i data-lucide="list-checks"
                                class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8390a1]"></i>

                            <select
                                id="status"
                                name="status"
                                required
                                aria-invalid="{{ $errors->has('status') ? 'true' : 'false' }}"
                                class="form-field w-full appearance-none rounded-xl border {{ $errors->has('status') ? 'border-red-300 bg-red-50/40' : 'border-[#dfe6ef] bg-[#fbfcfe]' }} py-3.5 pl-11 pr-11 text-sm text-[#263449]">

                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>
                                    Aktif — Sedang melaksanakan PKL
                                </option>

                                <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>
                                    Selesai — Telah menyelesaikan PKL
                                </option>

                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                                    Tidak Aktif — Tidak sedang melaksanakan PKL
                                </option>
                            </select>

                            <i data-lucide="chevron-down"
                                class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8390a1]"></i>
                        </div>

                        @error('status')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror

                        <p class="mt-2 flex items-start gap-1.5 text-xs leading-5 text-[#8390a1]">
                            <i data-lucide="info" class="mt-0.5 h-3.5 w-3.5 shrink-0"></i>
                            Status dapat disesuaikan dengan kondisi keikutsertaan siswa.
                        </p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col-reverse gap-3 border-t border-[#edf1f6] pt-6 sm:flex-row sm:items-center sm:justify-between">

                    <a href="{{ route('admin.students.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#dfe6ef] bg-white px-5 py-3.5 text-sm font-semibold text-[#526176] transition-colors hover:border-[#c7d4e4] hover:bg-[#f7f9fc] hover:text-[#243f63]">

                        <i data-lucide="arrow-left" class="h-4 w-4"></i>

                        Kembali ke Data Siswa
                    </a>

                    <button type="submit"
                        class="submit-button inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#243f63] to-[#365b88] px-6 py-3.5 text-sm font-semibold text-white shadow-[0_6px_18px_rgba(36,63,99,0.15)]">

                        <i data-lucide="user-round-plus" class="h-4 w-4"></i>

                        Simpan Data Siswa

                        <i data-lucide="arrow-up-right" class="h-4 w-4 opacity-75"></i>
                    </button>
                </div>

            </form>
        </section>

        {{-- Footer --}}
        <footer data-animate class="mt-8 flex flex-col items-center justify-between gap-3 border-t border-[#e0e7f0] pt-6 text-center sm:flex-row sm:text-left">
            <div class="flex items-center gap-2 text-xs text-[#8390a1]">
                <i data-lucide="shield-check" class="h-4 w-4 text-[#416b9e]"></i>

                <span>Data dikelola untuk keperluan administrasi PRAKERIN.</span>
            </div>

            <p class="text-xs text-[#a0aab8]">
                &copy; {{ date('Y') }} DISKOMINFO Kabupaten Pacitan
            </p>
        </footer>

    </main>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }

            const animateElements = document.querySelectorAll('[data-animate]');

            // GSAP entrance animation
            if (window.gsap && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                window.gsap.to(animateElements, {
                    opacity: 1,
                    y: 0,
                    duration: 0.65,
                    stagger: 0.09,
                    ease: 'power3.out',
                    clearProps: 'transform'
                });
            } else {
                animateElements.forEach((element) => {
                    element.style.opacity = '1';
                    element.style.transform = 'none';
                });
            }

            // Date validation: end date cannot precede start date.
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');

            const updateEndDateMinimum = () => {
                if (!startDate || !endDate) return;

                if (startDate.value) {
                    endDate.min = startDate.value;
                } else {
                    endDate.removeAttribute('min');
                }
            };

            startDate?.addEventListener('change', updateEndDateMinimum);

            startDate?.addEventListener('change', () => {
                if (startDate.value && endDate.value && endDate.value < startDate.value) {
                    endDate.value = '';
                }
            });

            updateEndDateMinimum();

            // Prevent accidental double submission.
            const form = document.querySelector('form[action="{{ route('admin.students.store') }}"]');
            const submitButton = form?.querySelector('button[type="submit"]');

            form?.addEventListener('submit', () => {
                if (!form.checkValidity()) return;

                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.classList.add('cursor-not-allowed', 'opacity-70');

                    submitButton.innerHTML = `
                        <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" aria-hidden="true">
                            <circle cx="12" cy="12" r="10" opacity=".25"></circle>
                            <path d="M4 12a8 8 0 0 1 8-8"></path>
                        </svg>
                        Menyimpan data...
                    `;
                }
            });
        });
    </script>

</body>
</html>