{{-- =========================================================
     PAGE TRANSITION — Simple Blue Ice Fade
     - Opacity 1 pada load → fade OUT (reveal page)
     - Opacity 0 saat idle → fade IN (curtain) sebelum navigate
========================================================== --}}

<div
    id="page-transition"
    aria-hidden="true"
    style="opacity:1;"
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-[#0a1520]"
>

    {{-- Soft radial glow --}}
    <div class="pointer-events-none absolute inset-0 opacity-70 [background:radial-gradient(circle_at_50%_50%,rgba(56,189,248,0.16),transparent_65%)]"></div>

    {{-- Icon database + pulse ring --}}
    <div class="relative flex items-center justify-center">

        {{-- Pulsing ring --}}
        <span class="absolute inline-flex h-16 w-16 animate-ping rounded-full bg-sky-400/20"></span>

        {{-- Icon --}}
        <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl border border-sky-300/20 bg-sky-400/[0.08] backdrop-blur-xl">
            <i data-lucide="database" class="h-6 w-6 text-sky-300"></i>
        </div>

    </div>
</div>


<script>
(function () {
    function init() {
        var pt = document.getElementById('page-transition');
        if (!pt) return;

        /* Buat icon di dalam overlay juga (karena overlay di atas icons di body) */
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
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
            if (/^(mailto:|tel:|javascript:|blob:|data:)/i.test(href)) return;

            try {
                var url = new URL(href, window.location.origin);
                if (url.origin !== window.location.origin) return;
                if (url.pathname === window.location.pathname
                    && url.search === window.location.search) {
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