{{-- =========================================================
     FLOATING NAVBAR — shared partial
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
            'route' => null,
            'match' => null,
            'href'  => '#analytics',
            'icon'  => 'chart-no-axes-combined',
            'color' => 'blue',
        ],
        [
            'label' => 'Profile',
            'route' => null,
            'match' => null,
            'href'  => '#profile',
            'icon'  => 'building-2',
            'color' => 'teal',
        ],
    ];
@endphp

<nav id="floating-nav"
     class="fixed bottom-5 left-1/2 z-[100] flex -translate-x-1/2 items-center gap-1 rounded-2xl border border-sky-200/[0.12] bg-[#0f1b2c]/90 p-1.5 shadow-2xl shadow-sky-950/50 backdrop-blur-2xl">

    {{-- SLIDING INDICATOR --}}
    <span
        id="nav-indicator"
        aria-hidden="true"
        class="pointer-events-none absolute left-0 top-0 z-0 rounded-xl bg-sky-400/[0.14] ring-1 ring-sky-300/20 shadow-[0_0_24px_-6px_rgba(125,211,252,0.55)]"
        style="opacity:0;width:0;height:0;"
    ></span>

    @foreach ($navItems as $item)

        @php
            $isAnchor = empty($item['route']);
            $href     = $isAnchor
                ? ($item['href'] ?? '#')
                : route($item['route']);

            $isActive = ! $isAnchor
                && ! empty($item['match'])
                && request()->routeIs($item['match']);
        @endphp

        <a href="{{ $href }}"
           data-nav-link
           data-active="{{ $isActive ? 'true' : 'false' }}"
           class="nav-pill group relative z-10 flex items-center gap-2 rounded-xl px-3 py-2.5 transition-colors duration-200
                  {{ $isActive ? 'text-white' : 'text-slate-500 hover:text-white' }}">

            <i data-lucide="{{ $item['icon'] }}"
               class="h-4 w-4 transition
                      text-{{ $item['color'] }}-300/80
                      group-hover:text-{{ $item['color'] }}-200
                      {{ $isActive ? 'text-' . $item['color'] . '-200' : '' }}"></i>

            <span class="hidden text-[9px] font-bold sm:inline">
                {{ $item['label'] }}
            </span>
        </a>

    @endforeach

</nav>


{{-- =========================================================
     NAV INDICATOR LOGIC
========================================================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    var nav       = document.getElementById('floating-nav');
    var indicator = document.getElementById('nav-indicator');
    if (!nav || !indicator || !window.gsap) return;

    var links      = Array.prototype.slice.call(nav.querySelectorAll('[data-nav-link]'));
    var activeLink = links.filter(function (el) {
        return el.dataset.active === 'true';
    })[0];

    function snapTo(el) {
        if (!el) return;
        gsap.set(indicator, {
            left:   el.offsetLeft,
            top:    el.offsetTop,
            width:  el.offsetWidth,
            height: el.offsetHeight
        });
    }

    function reveal() {
        gsap.fromTo(indicator,
            { opacity: 0, scale: 0.55, transformOrigin: '50% 50%' },
            { opacity: 1, scale: 1, duration: 0.55, ease: 'back.out(2.6)' }
        );
    }

    function slideTo(el) {
        if (!el) return;
        gsap.to(indicator, {
            left:   el.offsetLeft,
            top:    el.offsetTop,
            width:  el.offsetWidth,
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
            var cur = nav.querySelector('[data-nav-link][data-active="true"]') || links[0];
            snapTo(cur);
            gsap.set(indicator, { opacity: 1 });
        }, 120);
    });

    /* CLICK — hanya slide indicator.
       Navigasi ditangani partial page-transition. */
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