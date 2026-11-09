@extends('layouts/admin')

@section('title', 'Detail Peserta — ' . $student->name)
@section('page-title', 'Detail Profil Peserta')
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
        padding: 20px;
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
    {{-- Back & Action Bar --}}
    <div class="flex items-center justify-between no-print">
        <a href="{{ route('admin.students.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Peserta</span>
        </a>
        <div class="flex items-center gap-2">
            <button onclick="window.print()"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors cursor-pointer">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak Lembar Nilai</span>
            </button>
            <a href="{{ route('admin.students.edit', $student->id) }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition-colors shadow-xs">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                <span>Edit Data</span>
            </a>
        </div>
    </div>

    {{-- Printable Evaluation & Profile Sheet --}}
    <div id="printable-sheet" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 md:p-8 space-y-8">
        {{-- Formal Header (visible on print or screen) --}}
        <div class="flex items-start justify-between border-b border-slate-200 pb-6">
            <div class="flex items-center gap-5">
                <img src="{{ $student->photo_url }}"
                     alt="{{ $student->name }}"
                     class="w-24 h-24 rounded-2xl object-cover shrink-0">
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="inline-flex pr-2 pt-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                            {{ $student->type_label }}
                        </span>
                        @include('components.admin.badge-status', ['status' => $student->status])
                    </div>
                    <h2 class="text-xl md:text-2xl font-extrabold text-slate-900">{{ $student->name }}</h2>
                    <p class="text-xs text-slate-500 font-mono">
                        {{ $student->type === 'magang' ? 'NIM' : 'NIS' }}: {{ $student->identity_number }}
                    </p>
                </div>
            </div>

            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-slate-800">DINAS KOMUNIKASI DAN INFORMATIKA</p>
                <p class="text-[11px] text-slate-500">Pemerintah Kabupaten Pacitan</p>
                <p class="text-[11px] text-slate-400 mt-1">Dicetak pada: {{ date('d F Y') }}</p>
            </div>
        </div>

        {{-- Details Grid --}}
        <div>
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Informasi Akademik & Penempatan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5 p-5 rounded-xl bg-slate-50/70 border border-slate-200/70 text-xs">
                <div>
                    <span class="text-slate-500 block mb-0.5">Institusi Asal:</span>
                    <span class="font-bold text-slate-900 text-sm">{{ $student->institution ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-500 block mb-0.5">Jurusan / Program Studi:</span>
                    <span class="font-bold text-slate-900 text-sm">{{ $student->major }}</span>
                    @if ($student->type === 'prakerin' && $student->class)
                        <span class="text-slate-500 block text-[11px] mt-0.5">Kelas: {{ $student->class }}</span>
                    @elseif ($student->type === 'magang' && $student->faculty)
                        <span class="text-slate-500 block text-[11px] mt-0.5">{{ $student->faculty }}</span>
                    @endif
                </div>
                <div>
                    <span class="text-slate-500 block mb-0.5">Bidang Penempatan:</span>
                    <span class="font-bold text-blue-700 text-sm">{{ $student->department?->name ?? 'Belum ditentukan' }}</span>
                </div>
                <div>
                    <span class="text-slate-500 block mb-0.5">Periode Praktik / Magang:</span>
                    <span class="font-bold text-slate-900 text-sm">
                        {{ $student->start_date ? $student->start_date->format('d M Y') : '-' }} s/d {{ $student->end_date ? $student->end_date->format('d M Y') : '-' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Assessment & Evaluation Section --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Hasil Evaluasi & Penilaian</h3>
                    <p class="text-xs text-slate-500">Rekap skor nilai dari pembimbing lapangan</p>
                </div>
                @if ($student->assessment)
                    <div class="no-print">
                        <a href="{{ route('admin.assessments.edit', $student->assessment->id) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                            <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                            <span>Ubah Nilai</span>
                        </a>
                    </div>
                @endif
            </div>

            @if ($student->assessment)
                {{-- Score Summary Card --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 rounded-xl bg-amber-50/70 border border-amber-200 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-semibold text-amber-700 uppercase tracking-wider">Rata-rata Skor</span>
                            <h4 class="text-2xl font-extrabold text-amber-900 mt-1">{{ $student->assessment->average_score }}</h4>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold">
                            <i data-lucide="award" class="w-5 h-5"></i>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-blue-50/70 border border-blue-200 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-semibold text-blue-700 uppercase tracking-wider">Kategori Performa</span>
                            <h4 class="text-lg font-extrabold text-blue-900 mt-1">{{ $student->assessment->category?->name ?? '-' }}</h4>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                            <i data-lucide="badge-check" class="w-5 h-5"></i>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal Penilaian</span>
                            <h4 class="text-sm font-bold text-slate-800 mt-1">
                                {{ $student->assessment->assessment_date ? $student->assessment->assessment_date->format('d F Y') : '-' }}
                            </h4>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold">
                            <i data-lucide="calendar" class="w-5 h-5"></i>
                        </div>
                    </div>
                </div>

                {{-- Detailed Aspects Table --}}
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
                            @foreach ($student->assessment->scores as $index => $scoreItem)
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
                @if ($student->assessment->notes)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                        <p class="font-bold text-slate-700 mb-1">Catatan Pembimbing Lapangan:</p>
                        <p class="text-slate-600 leading-relaxed italic">"{{ $student->assessment->notes }}"</p>
                    </div>
                @endif
            @else
                {{-- Not yet assessed callout --}}
                <div class="p-6 rounded-2xl bg-slate-50 border border-dashed border-slate-300 text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 mx-auto flex items-center justify-center">
                        <i data-lucide="clipboard-list" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Peserta Ini Belum Dinilai</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Penilaian dapat diinput oleh Administrator maupun Operator.</p>
                    </div>
                    <a href="{{ route('admin.assessments.create', ['student_id' => $student->id]) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition-colors">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Beri Penilaian Sekarang</span>
                    </a>
                </div>
            @endif
        </div>
        </div>
    </div>
</div>
@endsection
