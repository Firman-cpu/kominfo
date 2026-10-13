<header class="sticky top-3 z-50 mx-auto mb-6 w-full px-3 sm:top-4 sm:px-5">
    <div
        class="mx-auto flex min-h-[68px] w-full max-w-7xl items-center justify-between gap-2 rounded-2xl border border-[#e0e7f0] bg-white/90 px-3 py-3 shadow-[0_8px_30px_rgba(35,57,84,0.045)] backdrop-blur-xl transition duration-300 hover:border-[#d5dfec] hover:shadow-[0_12px_34px_rgba(35,57,84,0.065)] sm:gap-4 sm:px-5"
    >

        {{-- BRAND --}}
        <a
            href="{{ route('home') }}"
            class="group inline-flex shrink-0 items-center gap-2.5 text-[#263449] transition-opacity duration-300 hover:opacity-85 sm:gap-3"
        >
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-white/20 bg-gradient-to-br from-[#365b88] to-[#243f63] text-white shadow-[0_4px_12px_rgba(36,63,99,0.16)] transition duration-300 group-hover:-translate-y-0.5 group-hover:shadow-[0_7px_16px_rgba(36,63,99,0.2)] sm:h-11 sm:w-11"
            >
                <i data-lucide="terminal" class="h-[19px] w-[19px] stroke-[1.8]"></i>
            </div>

            <div class="flex flex-col gap-1">
                <strong class="text-[11px] font-extrabold leading-none tracking-[0.055em] text-[#263449] sm:text-[13px]">
                    PRAKERIN
                </strong>

                <span class="font-mono text-[8px] font-semibold leading-none tracking-[0.11em] text-[#7c8ba0] sm:text-[9px] sm:tracking-[0.13em]">
                    DISKOMINFO
                </span>
            </div>
        </a>


        {{-- DESKTOP NAVIGATION --}}
        <nav
            class="flex min-w-0 items-center justify-center gap-0.5 rounded-xl border border-[#edf1f6] bg-[#f7f9fc] p-1 sm:gap-1 sm:p-1.5"
        >

            <a
                href="{{ route('home') }}"
                class="nav-link active inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-[#dfe7f1] bg-white px-2 text-[11px] font-semibold text-[#294b76] shadow-[0_2px_5px_rgba(35,57,84,0.045)] transition duration-300 hover:-translate-y-0.5 hover:bg-[#edf2f9] sm:gap-2 sm:px-3 sm:text-xs"
            >
                <i data-lucide="house" class="h-4 w-4 shrink-0 stroke-[1.8]"></i>
                <span>Home</span>
            </a>

            <a
                href="{{ route('students.index') }}"
                class="nav-link inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-transparent px-2 text-[11px] font-semibold text-[#718096] transition duration-300 hover:-translate-y-0.5 hover:border-[#e3eaf4] hover:bg-[#edf2f9] hover:text-[#294b76] sm:gap-2 sm:px-3 sm:text-xs"
            >
                <i data-lucide="users" class="h-4 w-4 shrink-0 stroke-[1.8]"></i>
                <span>Data</span>
            </a>

            <a
                href="{{ route('admin.analytics.index') }}"
                class="nav-link inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-transparent px-2 text-[11px] font-semibold text-[#718096] transition duration-300 hover:-translate-y-0.5 hover:border-[#e3eaf4] hover:bg-[#edf2f9] hover:text-[#294b76] sm:gap-2 sm:px-3 sm:text-xs"
            >
                <i data-lucide="chart-no-axes-combined" class="h-4 w-4 shrink-0 stroke-[1.8]"></i>
                <span>Analytics</span>
            </a>

            <a
                href="{{ route('admin.profile.index') }}"
                class="nav-link inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-transparent px-2 text-[11px] font-semibold text-[#718096] transition duration-300 hover:-translate-y-0.5 hover:border-[#e3eaf4] hover:bg-[#edf2f9] hover:text-[#294b76] sm:gap-2 sm:px-3 sm:text-xs"
            >
                <i data-lucide="building-2" class="h-4 w-4 shrink-0 stroke-[1.8]"></i>
                <span>Profile</span>
            </a>

        </nav>


        {{-- SYSTEM STATUS --}}
        <div
            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg border border-[#dfe8f2] bg-[#f1f5fa] px-2.5 py-2 sm:px-3"
        >
            <span
                class="relative flex h-2 w-2 shrink-0"
            >
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#5b88b6]/30"></span>
                <span class="relative inline-flex h-2 w-2 rounded-full bg-[#5b88b6]"></span>
            </span>

            <span class="hidden font-mono text-[9px] font-bold tracking-[0.1em] text-[#45668d] sm:inline">
                ONLINE
            </span>
        </div>

    </div>
</header>