@props(['status'])

@if ($status === 'completed')
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
        <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
        Selesai
    </span>
@else
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
        Sedang Aktif
    </span>
@endif
