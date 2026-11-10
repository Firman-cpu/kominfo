@extends('layouts/admin')

@section('title', 'Lembar Nilai — ' . $assessment->student?->name)
@section('page-title', 'Lembar Evaluasi Penilaian')
@section('page-subtitle', 'Transkrip capaian dan skor evaluasi peserta magang/PKL')

@push('styles')
<style>
@media print {
    body * { visibility: hidden; }
    #printable-sheet, #printable-sheet * { visibility: visible; }
    #printable-sheet {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
        padding: 24px;
        background: white !important;
        border: none !important;
        box-shadow: none !important;
    }
    .no-print { display: none !important; }
}
</style>
@endpush

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between no-print">
        <a href="{{ route('admin.assessments.index') }}"
           class="neu-btn px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:text-slate-900 inline-flex items-center gap-1.5 transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Penilaian</span>
        </a>
        <div class="flex items-center gap-2.5">
            <button onclick="window.print()"
                    class="neu-btn px-4 py-2 rounded-xl text-slate-700 text-xs font-semibold inline-flex items-center gap-1.5 transition-all cursor-pointer">
                <i data-lucide="printer" class="w-4 h-4 text-slate-600"></i>
                <span>Cetak Lembar Nilai</span>
            </button>
            <a href="{{ route('admin.assessments.edit', $assessment->id) }}"
               class="neu-primary px-4 py-2 rounded-xl text-white text-xs font-semibold shadow-lg shadow-blue-500/20 inline-flex items-center gap-1.5 transition-all">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                <span>Edit Nilai</span>
            </a>
        </div>
    </div>

    {{-- Printable Sheet --}}
    <div id="printable-sheet" class="neu-card rounded-3xl p-6 md:p-8 space-y-8">
        {{-- Header --}}
        <div class="flex items-start justify-between border-b border-slate-200/80 pb-6">
            <div class="flex items-center gap-5">
                <div class="neu-card-sm w-20 h-20 rounded-2xl overflow-hidden p-1 shrink-0">
                    <img src="{{ $assessment->student?->photo_url }}"
                         alt="{{ $assessment->student?->name }}"
                         class="w-full h-full rounded-xl object-cover">
                </div>
                <div>
                    <span class="inline-flex rounded text-[11px] font-bold uppercase tracking-wider mb-0.5 {{ $assessment->student?->type === 'magang' ? 'text-indigo-600' : 'text-blue-600' }}">
                        {{ $assessment->student?->type_label }}
                    </span>
                    <h2 class="text-xl md:text-2xl font-extrabold text-slate-900">{{ $assessment->student?->name }}</h2>
                    <p class="text-xs text-slate-500 font-mono mt-0.5">
                        {{ $assessment->student?->type === 'magang' ? 'NIM' : 'NIS' }}: {{ $assessment->student?->identity_number }} &bull; {{ $assessment->student?->institution ?? '-' }}
                    </p>
                </div>
            </div>

            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-slate-800">DINAS KOMUNIKASI DAN INFORMATIKA</p>
                <p class="text-[11px] text-slate-500">KABUPATEN PACITAN</p>
                <p class="text-[11px] text-slate-400 mt-1 font-mono">Tanggal: {{ $assessment->assessment_date ? $assessment->assessment_date->format('d/m/Y') : '-' }}</p>
            </div>
        </div>

        {{-- Score Highlights --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="neu-card-sm p-5 rounded-2xl border border-white/80">
                <span class="text-xs font-semibold text-amber-700 uppercase tracking-wider block">Rata-rata Skor</span>
                <span class="text-3xl font-black text-amber-900 mt-1.5 block font-mono">{{ $assessment->average_score }}</span>
            </div>
            <div class="neu-card-sm p-5 rounded-2xl border border-white/80">
                <span class="text-xs font-semibold text-blue-700 uppercase tracking-wider block">Kategori Performa</span>
                <span class="text-xl font-black text-blue-900 mt-1.5 block">{{ $assessment->category?->name ?? '-' }}</span>
            </div>
            <div class="neu-card-sm p-5 rounded-2xl border border-white/80">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Bidang Praktik</span>
                <span class="text-sm font-bold text-slate-800 mt-2 block">{{ $assessment->student?->department?->name ?? '-' }}</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="neu-card-sm rounded-2xl overflow-hidden border border-white/80">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-[#ebf0f7] border-b border-slate-300/60 text-slate-500 font-bold uppercase text-[11px] tracking-wider">
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Aspek Penilaian</th>
                        <th class="py-3 px-4 text-center w-32">Nilai (0-100)</th>
                        <th class="py-3 px-4">Taraf Kinerja</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/70">
                    @foreach ($assessment->scores as $index => $scoreItem)
                        <tr class="hover:bg-white/40 transition-colors">
                            <td class="py-3 px-4 text-center text-slate-400 font-medium">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-800">{{ $scoreItem->aspect?->name ?? 'Aspek' }}</td>
                            <td class="py-3 px-4 text-center font-black text-slate-900 font-mono text-sm">{{ $scoreItem->score }}</td>
                            <td class="py-3 px-4 text-slate-600">
                                @if ($scoreItem->score >= 85)
                                    <span class="text-emerald-700 font-bold">Sangat Baik</span>
                                @elseif ($scoreItem->score >= 75)
                                    <span class="text-blue-700 font-bold">Baik</span>
                                @elseif ($scoreItem->score >= 65)
                                    <span class="text-amber-700 font-bold">Cukup</span>
                                @else
                                    <span class="text-rose-700 font-bold">Perlu Pembinaan</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Notes --}}
        @if ($assessment->notes)
            <div class="neu-inset-sm p-4 rounded-2xl text-xs space-y-1">
                <p class="font-bold text-slate-700">Catatan Pembimbing:</p>
                <p class="text-slate-600 leading-relaxed italic">"{{ $assessment->notes }}"</p>
            </div>
        @endif
    </div>
</div>
@endsection
