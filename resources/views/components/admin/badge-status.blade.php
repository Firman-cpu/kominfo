@props(['status'])

@if ($status === 'completed')
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl neu-card-sm text-[11px] font-bold text-slate-700">
        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
        Selesai
    </span>
@else
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl neu-card-sm text-[11px] font-bold text-emerald-700">
        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 pulse-dot"></span>
        Aktif
    </span>
@endif
