@extends('layouts/admin')

@section('title', 'Detail Log Aktivitas #' . $log->id)
@section('page-title', 'Detail Audit Log')
@section('page-subtitle', 'Rincian snapshot aktivitas sistem dan perbandingan perubahan data')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.logs.index') }}"
           class="neu-btn px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:text-slate-900 inline-flex items-center gap-1.5 transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Log</span>
        </a>
    </div>

    {{-- Detail Card --}}
    <div class="neu-card p-6 md:p-8 rounded-3xl space-y-6">
        <div class="flex items-center gap-3 border-b border-slate-200/70 pb-4">
            <div class="neu-card-sm w-10 h-10 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900">{{ $log->description }}</h3>
                <p class="text-xs text-slate-500 font-mono mt-0.5">Waktu: {{ $log->created_at->format('d/m/Y H:i:s') }} &bull; IP: {{ $log->ip_address ?? '-' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="neu-card-sm p-4 rounded-2xl border border-white/80">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Petugas / Aktor</span>
                <span class="text-sm font-bold text-slate-900 mt-1 block">{{ $log->admin?->name ?? 'Sistem / Tamu' }}</span>
                <span class="text-[11px] text-slate-400 block">{{ $log->admin?->role ?? '-' }}</span>
            </div>

            <div class="neu-card-sm p-4 rounded-2xl border border-white/80">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Jenis Aksi</span>
                <span class="neu-card-sm inline-flex mt-1 px-3 py-1 rounded-xl text-xs font-bold uppercase text-blue-700 border border-blue-200/50">
                    {{ $log->action }}
                </span>
            </div>

            <div class="neu-card-sm p-4 rounded-2xl border border-white/80">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Subjek Terdampak</span>
                <span class="text-sm font-bold text-slate-900 mt-1 block font-mono text-xs truncate">
                    {{ $log->subject_type ? class_basename($log->subject_type) . ' #' . $log->subject_id : '-' }}
                </span>
            </div>
        </div>

        {{-- Snapshot Diff --}}
        @if (!empty($log->old_values) || !empty($log->new_values))
            <div class="pt-4 border-t border-slate-200/70 space-y-4">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Perbandingan Snapshot Data</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Old --}}
                    <div>
                        <span class="block font-bold text-rose-700 uppercase tracking-wider text-[10px] mb-2 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            Data Sebelum (Old Values)
                        </span>
                        <div class="neu-inset rounded-2xl p-4 font-mono text-[11px] overflow-x-auto text-slate-800 max-h-80">
                            @if (!empty($log->old_values))
                                <pre class="whitespace-pre-wrap">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
                            @else
                                <span class="text-slate-400 italic">Tidak ada (data baru)</span>
                            @endif
                        </div>
                    </div>

                    {{-- New --}}
                    <div>
                        <span class="block font-bold text-emerald-700 uppercase tracking-wider text-[10px] mb-2 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Data Sesudah (New Values)
                        </span>
                        <div class="neu-inset rounded-2xl p-4 font-mono text-[11px] overflow-x-auto text-slate-800 max-h-80">
                            @if (!empty($log->new_values))
                                <pre class="whitespace-pre-wrap">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
                            @else
                                <span class="text-slate-400 italic">Tidak ada (data dihapus)</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
