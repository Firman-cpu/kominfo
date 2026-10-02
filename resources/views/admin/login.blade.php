<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Login — PRAKERIN DISKOMINFO.">

    <title>Admin Login — PRAKERIN</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }

        @keyframes shimmer {
            0%   { background-position: 0% center; }
            100% { background-position: 200% center; }
        }
        .shimmer-text {
            background-size: 200% auto;
            animation: shimmer 6s linear infinite;
        }
    </style>
</head>

<body class="min-h-screen overflow-x-hidden bg-[#0a1520] text-slate-100 antialiased selection:bg-sky-400/30">

    {{-- BACKGROUND — ICE ATMOSPHERE --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="orb-1 absolute -left-40 -top-40 h-[500px] w-[500px] rounded-full bg-sky-500/20 blur-[130px]"></div>
        <div class="orb-2 absolute -right-40 top-[18%] h-[500px] w-[500px] rounded-full bg-cyan-400/15 blur-[140px]"></div>
        <div class="orb-3 absolute bottom-[-250px] left-[35%] h-[500px] w-[500px] rounded-full bg-blue-500/15 blur-[140px]"></div>

        <div class="absolute inset-0 opacity-[0.05] [background-image:linear-gradient(rgba(186,230,253,1)_1px,transparent_1px),linear-gradient(90deg,rgba(186,230,253,1)_1px,transparent_1px)] [background-size:56px_56px] [mask-image:linear-gradient(to_bottom,black,transparent_70%)]"></div>

        <div class="absolute left-1/2 top-0 h-px w-[70%] -translate-x-1/2 bg-gradient-to-r from-transparent via-sky-400/60 to-transparent"></div>
    </div>


    {{-- LOGIN --}}
    <main class="relative flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">

        <section
            class="login-card relative w-full max-w-md overflow-hidden rounded-3xl border border-sky-200/[0.12] bg-[#0f1b2c]/80 p-7 shadow-2xl shadow-black/50 backdrop-blur-2xl sm:p-9"
        >
            <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-sky-400/50 to-transparent"></div>
            <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-sky-500/10 blur-[100px]"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-20 h-56 w-56 rounded-full bg-cyan-400/10 blur-[110px]"></div>

            <div class="relative">

                {{-- BADGE --}}
                <div class="login-badge mb-7 inline-flex items-center gap-2 rounded-full border border-sky-400/20 bg-sky-400/[0.07] px-3 py-1.5">
                    <i data-lucide="shield-check" class="h-3.5 w-3.5 text-sky-300"></i>
                    <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-sky-200">
                        admin.auth.required
                    </span>
                </div>

                {{-- HEADING --}}
                <h1 class="login-title text-4xl font-black leading-[0.95] tracking-[-0.045em] text-white sm:text-[2.75rem]">
                    ADMIN
                    <span class="shimmer-text mt-1 block bg-gradient-to-r from-sky-200 via-cyan-200 to-blue-300 bg-clip-text text-transparent">
                        LOGIN
                    </span>
                </h1>

                <p class="login-sub mt-4 text-sm leading-6 text-slate-400">
                    Masuk untuk mengelola data siswa
                    Praktik Kerja Lapangan DISKOMINFO.
                </p>


                {{-- ERRORS --}}
                @if ($errors->any())
                    <div class="login-errors mt-6 overflow-hidden rounded-2xl border border-red-400/25 bg-red-500/[0.08] p-4">
                        <div class="flex items-start gap-3">
                            <i data-lucide="alert-triangle" class="mt-0.5 h-4 w-4 shrink-0 text-red-300"></i>
                            <div class="min-w-0">
                                <div class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-red-300">
                                    login.failed
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
                    action="{{ route('admin.login.submit') }}"
                    method="POST"
                    class="login-form mt-7 space-y-5"
                >
                    @csrf

                    <div class="field">
                        <label
                            for="username"
                            class="mb-2 flex items-center justify-between font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500"
                        >
                            <span class="flex items-center gap-2">
                                <i data-lucide="user-round" class="h-3.5 w-3.5 text-sky-300"></i>
                                Username
                            </span>
                        </label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            required
                            autocomplete="username"
                            placeholder="masukkan username"
                            class="w-full rounded-xl border border-sky-200/[0.12] bg-black/25 px-4 py-3 font-mono text-sm text-slate-100 placeholder:text-slate-600 outline-none transition duration-200 focus:border-sky-300/50 focus:bg-black/35 focus:ring-2 focus:ring-sky-400/20"
                        >
                    </div>

                    <div class="field">
                        <label
                            for="password"
                            class="mb-2 flex items-center justify-between font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-slate-500"
                        >
                            <span class="flex items-center gap-2">
                                <i data-lucide="lock-keyhole" class="h-3.5 w-3.5 text-cyan-300"></i>
                                Password
                            </span>
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border border-sky-200/[0.12] bg-black/25 px-4 py-3 font-mono text-sm text-slate-100 placeholder:text-slate-600 outline-none transition duration-200 focus:border-cyan-300/50 focus:bg-black/35 focus:ring-2 focus:ring-cyan-400/20"
                        >
                    </div>

                    <button
                        type="submit"
                        class="btn-submit group relative flex w-full items-center justify-center gap-3 overflow-hidden rounded-xl bg-gradient-to-r from-sky-500 via-cyan-400 to-blue-500 px-5 py-3.5 text-xs font-bold uppercase tracking-[0.14em] text-white shadow-xl shadow-sky-500/30 transition duration-300 hover:-translate-y-0.5 hover:shadow-sky-400/50"
                    >
                        <i data-lucide="log-in" class="h-4 w-4"></i>
                        Login
                        <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-0.5"></i>
                    </button>
                </form>

                {{-- FOOTER NOTE --}}
                <div class="login-footer mt-7 flex items-center justify-center gap-3 font-mono text-[9px] text-slate-600">
                    <span class="text-teal-300">●</span>
                    secure.channel
                    <span class="text-slate-700">/</span>
                    <span class="text-sky-300/80">session.ready</span>
                </div>

            </div>
        </section>

    </main>


    {{-- CDN LIBRARIES --}}
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.451.0/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>


    {{-- SCRIPT — ICONS + ANIMATIONS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
        }

        if (!window.gsap) {
            console.warn('[gsap] not loaded — animations skipped');
            return;
        }

        try {
            const tl = gsap.timeline({
                defaults: { ease: 'power3.out', clearProps: 'transform,opacity' }
            });

            tl.from('.login-card',   { y: 40, opacity: 0, scale: 0.97, duration: 0.9 })
              .from('.login-badge',  { y: 16, opacity: 0, duration: 0.5 }, '-=0.55')
              .from('.login-title',  { y: 26, opacity: 0, duration: 0.7 }, '-=0.4')
              .from('.login-sub',    { y: 16, opacity: 0, duration: 0.5 }, '-=0.5')
              .from('.login-errors', { y: 12, opacity: 0, duration: 0.5 }, '-=0.4')
              .from('.field',        { y: 18, opacity: 0, duration: 0.5, stagger: 0.1 }, '-=0.35')
              .from('.btn-submit',   { y: 14, opacity: 0, duration: 0.5 }, '-=0.2')
              .from('.login-footer', { y: 8,  opacity: 0, duration: 0.5 }, '-=0.3');

            /* AMBIENT */
            gsap.to('.orb-1', { x: 40,  y: 30,  duration: 14, repeat: -1, yoyo: true, ease: 'sine.inOut' });
            gsap.to('.orb-2', { x: -30, y: 40,  duration: 16, repeat: -1, yoyo: true, ease: 'sine.inOut' });
            gsap.to('.orb-3', { x: 20,  y: -30, duration: 18, repeat: -1, yoyo: true, ease: 'sine.inOut' });

        } catch (err) {
            console.warn('[gsap] animation error — showing content', err);
        }

        /* SAFETY NET — pastikan konten selalu terlihat */
        window.setTimeout(function () {
            document
                .querySelectorAll('.login-card, .login-badge, .login-title, .login-sub, .login-errors, .field, .btn-submit, .login-footer')
                .forEach(function (el) {
                    el.style.opacity = '';
                    el.style.transform = '';
                    el.style.visibility = '';
                });
        }, 2500);

    });
    </script>

</body>

</html>