@extends('layouts/admin')

@section('title', 'Lembar Nilai — ' . $assessment->student?->name)
@section('page-title', 'Lembar Evaluasi Penilaian')
@section('page-subtitle', '')

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
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Penilaian</span>
        </a>
        <div class="flex items-center gap-2">
            <button onclick="window.print()"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors cursor-pointer">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak Lembar Nilai</span>
            </button>
            <a href="{{ route('admin.assessments.edit', $assessment->id) }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                <span>Edit Nilai</span>
            </a>
        </div>
    </div>

    {{-- Printable Sheet --}}
    <div id="printable-sheet" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 md:p-8 space-y-8">
        {{-- Header --}}
        <div class="flex items-start justify-between border-b border-slate-200 pb-6">
            <div class="flex items-center gap-5">
                <img src="{{ $assessment->student?->photo_url }}"
                     alt="{{ $assessment->student?->name }}"
                     class="w-20 h-20 rounded-2xl object-cover border-2 border-slate-200 shadow-xs shrink-0">
                <div>
                    <span class="inline-flex pt-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $assessment->student?->type === 'magang' ? 'text-indigo-700' : 'stext-blue-700' }}">
                        {{ $assessment->student?->type_label }}
                    </span>
                    <h2 class="text-xl md:text-2xl font-extrabold text-slate-900">{{ $assessment->student?->name }}</h2>
                    <p class="text-xs text-slate-500 font-mono">
                        {{ $assessment->student?->type === 'magang' ? 'NIM' : 'NIS' }}: {{ $assessment->student?->identity_number }} | {{ $assessment->student?->institution ?? '-' }}
                    </p>
                </div>
            </div>

            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-slate-800">DINAS KOMUNIKASI DAN KOMUNIKASI</p>
                <p class="text-[11px] text-slate-500">Transkrip Nilai Prakerin & Magang</p>
                <p class="text-[11px] text-slate-400 mt-1">Tanggal: {{ $assessment->assessment_date ? $assessment->assessment_date->format('d/m/Y') : '-' }}</p>
            </div>
        </div>

        {{-- Score Highlights --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-xl bg-amber-50 border border-amber-200">
                <span class="text-xs font-semibold text-amber-700 uppercase tracking-wider block">Rata-rata Skor</span>
                <span class="text-2xl font-extrabold text-amber-900 mt-1 block">{{ $assessment->average_score }}</span>
            </div>
            <div class="p-4 rounded-xl bg-blue-50 border border-blue-200">
                <span class="text-xs font-semibold text-blue-700 uppercase tracking-wider block">Kategori Performa</span>
                <span class="text-lg font-extrabold text-blue-900 mt-1 block">{{ $assessment->category?->name ?? '-' }}</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Bidang Praktik</span>
                <span class="text-sm font-bold text-slate-800 mt-1 block">{{ $assessment->student?->department?->name ?? '-' }}</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="border border-slate-200 rounded-xl overflow-hidden">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase">
                        <th class="py-2.5 px-4 w-12 text-center">No</th>
                        <th class="py-2.5 px-4">Aspek Penilaian</th>
                        <th class="py-2.5 px-4 text-center w-28">Nilai (0-100)</th>
                        <th class="py-2.5 px-4">Taraf Kinerja</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($assessment->scores as $index => $scoreItem)
                        <tr>
                            <td class="py-2.5 px-4 text-center text-slate-400 font-medium">{{ $index + 1 }}</td>
                            <td class="py-2.5 px-4 font-semibold text-slate-800">{{ $scoreItem->aspect?->name ?? 'Aspek' }}</td>
                            <td class="py-2.5 px-4 text-center font-extrabold text-slate-900 font-mono text-sm">{{ $scoreItem->score }}</td>
                            <td class="py-2.5 px-4 text-slate-600">
                                @if ($scoreItem->score >= 85)
                                    <span class="text-emerald-600 font-semibold">Sangat Baik</span>
                                @elseif ($scoreItem->score >= 75)
                                    <span class="text-blue-600 font-semibold">Baik</span>
                                @elseif ($scoreItem->score >= 65)
                                    <span class="text-amber-600 font-semibold">Cukup</span>
                                @else
                                    <span class="text-rose-600 font-semibold">Perlu Pembinaan</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Notes --}}
        @if ($assessment->notes)
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                <p class="font-bold text-slate-700 mb-1">Catatan Pembimbing:</p>
                <p class="text-slate-600 leading-relaxed italic">"{{ $assessment->notes }}"</p>
            </div>
        @endif
    </div>
</div>
@endsection
