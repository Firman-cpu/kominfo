{{--
  Toast Notification System
  Muncul dari kanan bawah, auto-dismiss 4 detik, bisa di-swipe/klik tutup.
  Mendukung: success, error, warning, info
--}}

@php
    $toasts = [];
    if (session('success')) $toasts[] = ['type' => 'success', 'message' => session('success')];
    if (session('error'))   $toasts[] = ['type' => 'error',   'message' => session('error')];
    if (session('warning')) $toasts[] = ['type' => 'warning', 'message' => session('warning')];
    if (session('info'))    $toasts[] = ['type' => 'info',    'message' => session('info')];

    // Validation errors juga ditampilkan sebagai toast
    if ($errors->any()) {
        $toasts[] = [
            'type'    => 'error',
            'message' => 'Terdapat ' . $errors->count() . ' kesalahan: ' . implode('. ', $errors->all()),
        ];
    }
@endphp

@if (count($toasts))
<div id="toast-container"
     class="fixed bottom-5 right-5 z-[9999] flex flex-col gap-3 max-w-sm w-full pointer-events-none"
     aria-live="polite" aria-atomic="true">
    @foreach ($toasts as $i => $toast)
        @php
            $cfg = match($toast['type']) {
                'success' => ['bg' => 'bg-emerald-600', 'icon' => 'check-circle-2',  'ring' => 'ring-emerald-500/30'],
                'error'   => ['bg' => 'bg-rose-600',    'icon' => 'alert-octagon',   'ring' => 'ring-rose-500/30'],
                'warning' => ['bg' => 'bg-amber-500',   'icon' => 'alert-triangle',  'ring' => 'ring-amber-400/30'],
                default   => ['bg' => 'bg-blue-600',    'icon' => 'info',            'ring' => 'ring-blue-500/30'],
            };
        @endphp
        <div id="toast-{{ $i }}"
             class="toast-item pointer-events-auto w-full flex items-start gap-3 p-4 rounded-2xl shadow-xl ring-1 {{ $cfg['ring'] }} {{ $cfg['bg'] }} text-white relative
                    translate-x-full opacity-0 transition-all duration-500 ease-out"
             role="alert"
             data-index="{{ $i }}">
            {{-- Icon --}}
            <div class="shrink-0 w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center">
                <i data-lucide="{{ $cfg['icon'] }}" class="w-5 h-5"></i>
            </div>
            {{-- Text --}}
            <div class="flex-1 min-w-0 pt-0.5">
                <p class="text-sm font-semibold leading-snug break-words">{{ $toast['message'] }}</p>
            </div>
            {{-- Close button --}}
            <button onclick="dismissToast({{ $i }})"
                    class="shrink-0 w-7 h-7 rounded-xl hover:bg-white/20 flex items-center justify-center transition-colors mt-0.5 cursor-pointer"
                    aria-label="Tutup notifikasi">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
            {{-- Progress bar --}}
            <div class="absolute bottom-0 left-0 right-0 h-0.5 rounded-b-2xl bg-white/30 overflow-hidden">
                <div id="toast-progress-{{ $i }}"
                     class="h-full bg-white/70 transition-none"
                     style="width: 100%"></div>
            </div>
        </div>
    @endforeach
</div>

<script>
(function () {
    const DURATION = 4500; // ms sebelum auto-dismiss
    const ANIM_IN  = 50;   // delay sebelum slide masuk (ms)

    function dismissToast(index) {
        const el = document.getElementById('toast-' + index);
        if (!el) return;
        el.classList.remove('translate-x-0', 'opacity-100');
        el.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => el.remove(), 500);
    }

    function startProgress(index, duration) {
        const bar = document.getElementById('toast-progress-' + index);
        if (!bar) return;
        const start = performance.now();
        function step(now) {
            const elapsed = now - start;
            const pct = Math.max(0, 100 - (elapsed / duration) * 100);
            bar.style.width = pct + '%';
            if (pct > 0) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const items = document.querySelectorAll('.toast-item');
        items.forEach(function (el, i) {
            const index = parseInt(el.dataset.index, 10);

            // Slide in dari kanan
            setTimeout(function () {
                el.classList.remove('translate-x-full', 'opacity-0');
                el.classList.add('translate-x-0', 'opacity-100');
                startProgress(index, DURATION);
            }, ANIM_IN + i * 150);

            // Auto-dismiss
            setTimeout(function () {
                dismissToast(index);
            }, ANIM_IN + i * 150 + DURATION);
        });
    });

    // Expose globally sehingga onclick bisa pakai
    window.dismissToast = dismissToast;
})();
</script>
@endif
