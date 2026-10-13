<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Login — PRAKERIN DISKOMINFO PACITAN.">
    <meta name="theme-color" content="#f5f7fa">

    <title>Admin Login — PRAKERIN DISKOMINFO</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
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

        .login-input {
            transition:
                border-color 200ms ease,
                box-shadow 200ms ease,
                background-color 200ms ease;
        }

        .login-input:focus {
            outline: none;
        }

        .grid-mask {
            mask-image: linear-gradient(to bottom, black, transparent 85%);
            -webkit-mask-image: linear-gradient(to bottom, black, transparent 85%);
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
</head>

<body class="min-h-screen overflow-x-hidden bg-[#f5f7fa] text-[#263449] antialiased selection:bg-[#365b88]/15">

    {{-- BACKGROUND — PRAKERIN LIGHT ATMOSPHERE --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">

        <div class="orb-1 absolute -left-40 -top-40 h-[440px] w-[440px] rounded-full bg-[#416b9e]/10 blur-[120px]"></div>

        <div class="orb-2 absolute -right-40 top-[15%] h-[440px] w-[440px] rounded-full bg-sky-300/20 blur-[130px]"></div>

        <div class="orb-3 absolute bottom-[-240px] left-[35%] h-[460px] w-[460px] rounded-full bg-blue-200/30 blur-[130px]"></div>

        <div class="grid-mask absolute inset-0 opacity-[0.32] [background-image:linear-gradient(#dce5f0_1px,transparent_1px),linear-gradient(90deg,#dce5f0_1px,transparent_1px)] [background-size:48px_48px]"></div>

        <div class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2 bg-gradient-to-r from-transparent via-[#416b9e]/40 to-transparent"></div>
    </div>


    {{-- LOGIN --}}
    <main class="relative flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">

        <section
            class="login-card relative w-full max-w-md overflow-hidden rounded-3xl border border-[#e0e7f0] bg-white/90 p-7 shadow-[0_24px_80px_-30px_rgba(36,63,99,0.22)] backdrop-blur-2xl sm:p-9"
            aria-labelledby="login-heading"
        >
            {{-- CARD DECORATION --}}
            <div class="pointer-events-none absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-[#243f63] via-[#416b9e] to-sky-400"></div>

            <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-blue-100/60 blur-[100px]"></div>

            <div class="pointer-events-none absolute -bottom-32 -left-20 h-56 w-56 rounded-full bg-sky-100/70 blur-[110px]"></div>

            <div class="relative">

                {{-- BRAND --}}
                <div class="login-brand mb-8 flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-[#243f63] to-[#416b9e] text-white shadow-lg shadow-[#243f63]/15">
                        <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                    </div>

                    <div>
                        <p class="text-sm font-extrabold tracking-tight text-[#263449]">
                            PRAKERIN
                        </p>

                        <p class="mt-0.5 text-[10px] font-semibold uppercase tracking-[0.15em] text-[#8390a1]">
                            DISKOMINFO PACITAN
                        </p>
                    </div>
                </div>


                {{-- BADGE --}}
                <div class="login-badge mb-6 inline-flex items-center gap-2 rounded-full border border-[#dce6f2] bg-[#f4f8fc] px-3 py-1.5">
                    <i data-lucide="shield-check" class="h-3.5 w-3.5 text-[#365b88]"></i>

                    <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-[#365b88]">
                        admin.auth.required
                    </span>
                </div>


                {{-- HEADING --}}
                <h1
                    id="login-heading"
                    class="login-title text-4xl font-black leading-[0.98] tracking-[-0.045em] text-[#263449] sm:text-[2.75rem]"
                >
                    ADMIN

                    <span class="shimmer-text mt-1 block bg-gradient-to-r from-[#243f63] via-[#416b9e] to-sky-500 bg-clip-text text-transparent">
                        LOGIN
                    </span>
                </h1>

                <p class="login-sub mt-4 max-w-sm text-sm leading-6 text-[#718096]">
                    Masuk ke dashboard administrator untuk mengelola data siswa Praktik Kerja Lapangan DISKOMINFO.
                </p>


                {{-- ERRORS --}}
                @if ($errors->any())
                    <div
                        class="login-errors mt-6 overflow-hidden rounded-2xl border border-red-200 bg-red-50 p-4"
                        role="alert"
                        aria-live="polite"
                    >
                        <div class="flex items-start gap-3">
                            <i data-lucide="alert-triangle" class="mt-0.5 h-4 w-4 shrink-0 text-red-500"></i>

                            <div class="min-w-0">
                                <div class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-red-600">
                                    login.failed
                                </div>

                                <ul class="mt-2 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-xs leading-5 text-red-700">
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
                    action="{{ route('admin.login.submit') }}"
                    method="POST"
                    class="login-form mt-7 space-y-5"
                >
                    @csrf

                    {{-- USERNAME --}}
                    <div class="field">
                        <label
                            for="username"
                            class="mb-2 flex items-center justify-between font-mono text-[10px] font-bold uppercase tracking-[0.16em] text-[#718096]"
                        >
                            <span class="flex items-center gap-2">
                                <i data-lucide="user-round" class="h-3.5 w-3.5 text-[#416b9e]"></i>
                                Username
                            </span>

                            <span class="text-[9px] font-medium normal-case tracking-normal text-[#a0aaba]">
                                Required
                            </span>
                        </label>

                        <div class="relative">
                            <i data-lucide="user" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#9aa7b8]"></i>

                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                required
                                autocomplete="username"
                                placeholder="Masukkan username"
                                class="login-input w-full rounded-xl border border-[#e0e7f0] bg-[#f8fafc] py-3.5 pl-11 pr-4 text-sm text-[#263449] placeholder:text-[#a0aaba] focus:border-[#416b9e] focus:bg-white focus:ring-4 focus:ring-[#416b9e]/10"
                            >
                        </div>
                    </div>


                    {{-- PASSWORD --}}
                    <div class="field">
                        <label
                            for="password"
                            class="mb-2 flex items-center justify-between font-mono text-[10px] font-bold uppercase tracking-[0.16em] text-[#718096]"
                        >
                            <span class="flex items-center gap-2">
                                <i data-lucide="lock-keyhole" class="h-3.5 w-3.5 text-[#416b9e]"></i>
                                Password
                            </span>

                            <span class="text-[9px] font-medium normal-case tracking-normal text-[#a0aaba]">
                                Required
                            </span>
                        </label>

                        <div class="relative">
                            <i data-lucide="key-round" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#9aa7b8]"></i>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                class="login-input w-full rounded-xl border border-[#e0e7f0] bg-[#f8fafc] py-3.5 pl-11 pr-4 text-sm text-[#263449] placeholder:text-[#a0aaba] focus:border-[#416b9e] focus:bg-white focus:ring-4 focus:ring-[#416b9e]/10"
                            >
                        </div>
                    </div>


                    {{-- SUBMIT BUTTON --}}
                    <button
                        type="submit"
                        class="btn-submit group relative flex w-full items-center justify-center gap-3 overflow-hidden rounded-xl bg-gradient-to-r from-[#243f63] via-[#365b88] to-[#416b9e] px-5 py-3.5 text-xs font-bold uppercase tracking-[0.14em] text-white shadow-lg shadow-[#243f63]/20 transition duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-[#243f63]/25 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-[#416b9e]/25 active:translate-y-0"
                    >
                        <span class="pointer-events-none absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/15 to-transparent transition-transform duration-700 group-hover:translate-x-full"></span>

                        <i data-lucide="log-in" class="relative h-4 w-4"></i>

                        <span class="relative">Login Dashboard</span>

                        <i data-lucide="arrow-right" class="relative h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"></i>
                    </button>
                </form>


                {{-- SECURITY NOTE --}}
                <div class="login-security mt-6 flex items-start gap-3 rounded-xl border border-[#e5ebf3] bg-[#f8fafc] p-3.5">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#eaf1f9] text-[#365b88]">
                        <i data-lucide="shield-check" class="h-4 w-4"></i>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-[#3b4d65]">
                            Akses administrator
                        </p>

                        <p class="mt-1 text-[11px] leading-5 text-[#8390a1]">
                            Gunakan akun resmi yang telah diberikan. Jangan bagikan kredensial login kepada orang lain.
                        </p>
                    </div>
                </div>


                {{-- FOOTER NOTE --}}
                <div class="login-footer mt-7 flex flex-wrap items-center justify-center gap-2 font-mono text-[9px] text-[#9aa7b8]">
                    <span class="text-emerald-500">●</span>

                    <span>secure.channel</span>

                    <span class="text-[#d1d9e4]">/</span>

                    <span class="text-[#416b9e]">session.ready</span>
                </div>

                <div class="mt-5 border-t border-[#edf1f6] pt-4 text-center">
                    <p class="text-[10px] text-[#a0aaba]">
                        &copy; {{ date('Y') }} DISKOMINFO Kabupaten Pacitan
                    </p>
                </div>

            </div>
        </section>

    </main>


    {{-- CDN LIBRARIES --}}
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>


    {{-- ICONS + ANIMATIONS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide && typeof window.lucide.createIcons === 'function') {
                window.lucide.createIcons({
                    attrs: {
                        'stroke-width': 1.8
                    }
                });
            }

            const animatedElements = document.querySelectorAll(
                '.login-card, .login-brand, .login-badge, .login-title, ' +
                '.login-sub, .login-errors, .field, .btn-submit, ' +
                '.login-security, .login-footer'
            );

            function resetAnimations() {
                animatedElements.forEach(function (element) {
                    element.style.opacity = '';
                    element.style.transform = '';
                    element.style.visibility = '';
                });
            }

            if (!window.gsap) {
                console.warn('[gsap] not loaded — animations skipped');
                return;
            }

            const prefersReducedMotion = window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;

            try {
                if (!prefersReducedMotion) {
                    const tl = gsap.timeline({
                        defaults: {
                            ease: 'power3.out'
                        }
                    });

                    tl.from('.login-card', {
                        y: 28,
                        opacity: 0,
                        scale: 0.985,
                        duration: 0.75
                    })
                    .from('.login-brand', {
                        y: 12,
                        opacity: 0,
                        duration: 0.4
                    }, '-=0.4')
                    .from('.login-badge', {
                        y: 10,
                        opacity: 0,
                        duration: 0.4
                    }, '-=0.2')
                    .from('.login-title', {
                        y: 18,
                        opacity: 0,
                        duration: 0.55
                    }, '-=0.2')
                    .from('.login-sub', {
                        y: 10,
                        opacity: 0,
                        duration: 0.4
                    }, '-=0.3');

                    if (document.querySelector('.login-errors')) {
                        tl.from('.login-errors', {
                            y: 10,
                            opacity: 0,
                            duration: 0.4
                        }, '-=0.2');
                    }

                    tl.from('.field', {
                        y: 12,
                        opacity: 0,
                        duration: 0.4,
                        stagger: 0.08
                    }, '-=0.15')
                    .from('.btn-submit', {
                        y: 8,
                        opacity: 0,
                        duration: 0.4
                    }, '-=0.15')
                    .from('.login-security', {
                        y: 8,
                        opacity: 0,
                        duration: 0.35
                    }, '-=0.15')
                    .from('.login-footer', {
                        y: 6,
                        opacity: 0,
                        duration: 0.35
                    }, '-=0.15');

                    // Ambient background movement
                    gsap.to('.orb-1', {
                        x: 30,
                        y: 20,
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

                    gsap.to('.orb-3', {
                        x: 18,
                        y: -25,
                        duration: 18,
                        repeat: -1,
                        yoyo: true,
                        ease: 'sine.inOut'
                    });
                }
            } catch (error) {
                console.warn('[gsap] animation error — showing content', error);
                resetAnimations();
            }

            // Safety net: content must remain visible.
            window.setTimeout(resetAnimations, 2500);
        });
    </script>

</body>

</html>