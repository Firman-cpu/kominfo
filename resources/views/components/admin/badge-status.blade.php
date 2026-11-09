@props(['status'])

@if ($status === 'completed')
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-slate-700">
        Selesai
    </span>
@else
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-emerald-700">
        Aktif
    </span>
@endif
