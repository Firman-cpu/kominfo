{{-- =========================================================
     PAGE TRANSITION — Blue Ice Fade
     - Opacity 1 saat load → fade OUT untuk menampilkan halaman
     - Opacity 0 saat idle → fade IN sebelum navigasi
========================================================== --}}

<div
    id="page-transition"
    aria-hidden="true"
    style="opacity: 1;"
    class="fixed inset-0 z-[9999] flex items-center justify-center overflow-hidden bg-[#f5f7fa]"
>
    {{-- Soft blue radial glow --}}
    <div
        class="pointer-events-none absolute inset-0 opacity-80
               [background:radial-gradient(circle_at_50%_45%,rgba(65,107,158,0.13),transparent_55%)]"
    ></div>

    {{-- Subtle ambient glow --}}
    <div
        class="pointer-events-none absolute h-56 w-56 rounded-full
               bg-[#416b9e]/[0.06] blur-3xl"
    ></div>

    {{-- Loading indicator --}}
    <div class="relative flex items-center justify-center">

        {{-- Pulse ring --}}
        <span
            class="absolute inline-flex h-20 w-20 animate-ping rounded-full
                   border border-[#416b9e]/20 bg-[#416b9e]/[0.04]"
        ></span>

        {{-- Icon container --}}
        <div
            class="relative flex h-14 w-14 items-center justify-center
                   rounded-2xl border border-[#dce5f0]
                   bg-white/90 shadow-[0_8px_30px_rgba(54,91,136,0.12)]
                   backdrop-blur-xl"
        >
            <i
                data-lucide="database"
                class="h-6 w-6 text-[#365b88]"
            ></i>
        </div>

        {{-- Small status dot --}}
        <span
            class="absolute -right-1 -top-1 h-3 w-3 rounded-full
                   border-2 border-[#f5f7fa] bg-[#416b9e]"
        ></span>
    </div>
</div>


<script>
(function () {
    function init() {
        var pt = document.getElementById('page-transition');
        if (!pt) return;

        /* Render icon di dalam overlay */
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

        if (!window.gsap) {
            pt.style.display = 'none';
            return;
        }

        /* FADE OUT — reveal halaman */
        gsap.to(pt, {
            opacity: 0,
            duration: 0.5,
            delay: 0.05,
            ease: 'power2.out',
            onComplete: function () {
                pt.style.display = 'none';
                pt.style.pointerEvents = 'none';
            }
        });

        /* FADE IN — intercept internal link */
        document.addEventListener('click', function (e) {

            if (pt.style.display === 'flex') return;
            if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

            var link = e.target.closest('a[href]');
            if (!link) return;
            if (link.target === '_blank') return;
            if (link.hasAttribute('download')) return;

            var href = link.getAttribute('href');
            if (!href) return;
            if (href.charAt(0) === '#') return;

            if (/^(mailto:|tel:|javascript:|blob:|data:)/i.test(href)) {
                return;
            }

            try {
                var url = new URL(href, window.location.origin);

                if (url.origin !== window.location.origin) return;

                if (
                    url.pathname === window.location.pathname &&
                    url.search === window.location.search
                ) {
                    return;
                }
            } catch (err) {
                return;
            }

            e.preventDefault();

            pt.style.display = 'flex';
            pt.style.pointerEvents = 'auto';

            gsap.to(pt, {
                opacity: 1,
                duration: 0.35,
                ease: 'power2.in',
                onComplete: function () {
                    window.location.href = href;
                }
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>