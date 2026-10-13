{{-- =========================================================
     FLOATING NAVBAR — shared partial
     PRAKERIN / DISKOMINFO PACITAN
     Tailwind CSS styling only
========================================================== --}}

@php
    $navItems = [
        [
            'label' => 'Home',
            'route' => 'home',
            'match' => 'home',
            'icon'  => 'home',
            'color' => 'sky',
        ],
        [
            'label' => 'Data',
            'route' => 'students.index',
            'match' => 'students.*',
            'icon'  => 'users',
            'color' => 'cyan',
        ],
        [
            'label' => 'Analytics',
            'route' => 'analytics.index',
            'match' => 'analytics.index',
            'icon'  => 'chart-no-axes-combined',
            'color' => 'blue',
        ],
        [
            'label' => 'Profile',
            'route' => 'profile.index',
            'match' => 'profile.index',
            'icon'  => 'building-2',
            'color' => 'teal',
        ],
    ];
@endphp

<nav
    id="floating-nav"
    aria-label="Navigasi utama"
    class="fixed bottom-4 left-1/2 z-[100] flex max-w-[calc(100vw-24px)] -translate-x-1/2 items-center gap-1 overflow-visible rounded-2xl border border-[#dce5f0] bg-white/95 p-1.5 shadow-[0_12px_40px_rgba(35,57,84,0.13)] backdrop-blur-2xl sm:bottom-6 sm:gap-1.5 sm:p-2"
>

    {{-- SLIDING INDICATOR --}}
    <span
        id="nav-indicator"
        aria-hidden="true"
        class="pointer-events-none absolute left-0 top-0 z-0 rounded-xl border border-[#d5e2f1] bg-[#eaf1fa] shadow-[0_3px_12px_rgba(54,91,136,0.08)]"
        style="opacity:0;width:0;height:0;"
    ></span>

    @foreach ($navItems as $item)

        @php
            $isAnchor = empty($item['route']);

            $href = $isAnchor
                ? ($item['href'] ?? '#')
                : route($item['route']);

            $isActive = ! $isAnchor
                && ! empty($item['match'])
                && request()->routeIs($item['match']);
        @endphp

        <a
            href="{{ $href }}"
            data-nav-link
            data-active="{{ $isActive ? 'true' : 'false' }}"
            aria-current="{{ $isActive ? 'page' : 'false' }}"
            class="nav-pill group relative z-10 inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-xl px-3 py-2.5 transition-colors duration-200 sm:px-4
                {{ $isActive
                    ? 'text-[#294b76]'
                    : 'text-[#7b899b] hover:text-[#294b76]' }}"
        >

            <i
                data-lucide="{{ $item['icon'] }}"
                class="h-[17px] w-[17px] shrink-0 stroke-[1.8] transition-colors duration-200
                    {{ $isActive
                        ? 'text-[#365b88]'
                        : 'text-[#8194ad] group-hover:text-[#365b88]' }}"
            ></i>

            <span class="hidden text-[10px] font-semibold tracking-wide sm:inline">
                {{ $item['label'] }}
            </span>

        </a>

    @endforeach

</nav>


{{-- =========================================================
     NAV INDICATOR LOGIC — preserved
========================================================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    var nav       = document.getElementById('floating-nav');
    var indicator = document.getElementById('nav-indicator');

    if (!nav || !indicator || !window.gsap) return;

    var links = Array.prototype.slice.call(
        nav.querySelectorAll('[data-nav-link]')
    );

    var activeLink = links.filter(function (el) {
        return el.dataset.active === 'true';
    })[0];

    function snapTo(el) {
        if (!el) return;

        gsap.set(indicator, {
            left: el.offsetLeft,
            top: el.offsetTop,
            width: el.offsetWidth,
            height: el.offsetHeight
        });
    }

    function reveal() {
        gsap.fromTo(
            indicator,
            {
                opacity: 0,
                scale: 0.55,
                transformOrigin: '50% 50%'
            },
            {
                opacity: 1,
                scale: 1,
                duration: 0.55,
                ease: 'back.out(2.6)'
            }
        );
    }

    function slideTo(el) {
        if (!el) return;

        gsap.to(indicator, {
            left: el.offsetLeft,
            top: el.offsetTop,
            width: el.offsetWidth,
            height: el.offsetHeight,
            duration: 0.55,
            ease: 'elastic.out(1, 0.75)'
        });
    }

    var initial = activeLink || links[0];

    if (!initial) return;

    var kickoff = function () {
        snapTo(initial);
        requestAnimationFrame(reveal);
    };

    if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(kickoff);
    } else {
        setTimeout(kickoff, 120);
    }

    var rzTimer;

    window.addEventListener('resize', function () {
        clearTimeout(rzTimer);

        rzTimer = setTimeout(function () {
            var cur = nav.querySelector(
                '[data-nav-link][data-active="true"]'
            ) || links[0];

            snapTo(cur);
            gsap.set(indicator, { opacity: 1 });
        }, 120);
    });

    /*
     * CLICK — hanya menggerakkan indicator.
     * Navigasi tetap ditangani partial page-transition.
     */
    links.forEach(function (link) {
        link.addEventListener('click', function () {
            var href = link.getAttribute('href') || '';

            if (href.charAt(0) === '#' && href.length > 1) return;
            if (link.dataset.active === 'true') return;

            slideTo(link);
        });
    });
});
</script>