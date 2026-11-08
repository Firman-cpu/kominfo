<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator & Operator — PRAKERIN DISKOMINFO Pacitan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full">
        {{-- Card Container --}}
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 p-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-700 to-indigo-600 flex items-center justify-center text-white mx-auto shadow-lg shadow-blue-500/30 mb-4">
                    <i data-lucide="shield-check" class="w-8 h-8"></i>
                </div>
                <h1 class="text-xl font-extrabold text-slate-900">PRAKERIN DISKOMINFO</h1>
                <p class="text-xs text-slate-500 mt-1 font-medium">Kabupaten Pacitan — Masuk ke Portal Pengelolaan</p>
            </div>

            {{-- Flash Alert --}}
            @if (session('success'))
                <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->has('auth'))
                <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                    <span>{{ $errors->first('auth') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf

                {{-- Username --}}
                <div>
                    <label for="username" class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">
                        Username
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </span>
                        <input type="text"
                               name="username"
                               id="username"
                               value="{{ old('username') }}"
                               required
                               autocomplete="username"
                               autofocus
                               placeholder="Masukkan username Anda"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('username') ? 'border-rose-400 bg-rose-50/30 focus:border-rose-500 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-100' }} text-sm focus:ring-4 focus:outline-hidden transition-all text-slate-800 placeholder-slate-400">
                    </div>
                    @error('username')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </span>
                        <input type="password"
                               name="password"
                               id="password"
                               required
                               autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('password') ? 'border-rose-400 bg-rose-50/30 focus:border-rose-500 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-100' }} text-sm focus:ring-4 focus:outline-hidden transition-all text-slate-800 placeholder-slate-400">
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 text-slate-600 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-blue-700 to-indigo-600 hover:from-blue-800 hover:to-indigo-700 text-white font-semibold text-sm shadow-lg shadow-blue-600/30 focus:ring-4 focus:ring-blue-200 transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-blue-600 inline-flex items-center gap-1 transition-colors">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Kembali ke Halaman Utama</span>
                </a>
            </div>
        </div>

        {{-- Footer Note --}}
        <p class="text-center text-xs text-slate-400 mt-6">
            Akses dibatasi khusus Administrator & Operator yang berwenang.
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.initLucide) {
                window.initLucide();
            }
        });
    </script>
</body>
</html>