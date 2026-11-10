@extends('layouts.admin')

@section('title', 'Detail Peserta — ' . $student->name)
@section('page-title', 'Detail Profil Peserta')
@section('page-subtitle', 'Informasi lengkap akademik dan rekapitulasi penilaian')

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
<div class="space-y-7">
    {{-- Back & Action Bar --}}
    <div class="flex items-center justify-between no-print flex-wrap gap-3">
        <a href="{{ route('admin.students.index') }}"
           class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-slate-900 px-3.5 py-2 rounded-xl neu-btn transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Peserta</span>
        </a>
        <div class="flex items-center gap-2.5">
            <button onclick="window.print()"
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl neu-btn text-slate-700 text-xs font-bold transition-all cursor-pointer">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak Lembar Nilai</span>
            </button>
            <a href="{{ route('admin.students.edit', $student->id) }}"
               class="inline-flex items-center gap-1.5 px-4.5 py-2.5 rounded-xl neu-primary text-white text-xs font-extrabold btn-press">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                <span>Edit Data</span>
            </a>
        </div>
    </div>

    {{-- Printable Evaluation & Profile Sheet --}}
    <div id="printable-sheet" class="neu-card rounded-3xl p-6 md:p-8 space-y-8">
        {{-- Formal Header (visible on print or screen) --}}
        <div class="flex flex-col sm:flex-row sm:items-start justify-between border-b border-[#d8e2ee] pb-6 gap-4">
            <div class="flex items-center gap-5">
                <img src="{{ $student->photo_url }}"
                     alt="{{ $student->name }}"
                     class="w-24 h-24 rounded-2xl object-cover shrink-0 neu-card-sm">
                <div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="inline-flex px-2.5 py-0.5 rounded-lg neu-card-sm text-[10px] font-extrabold uppercase tracking-wider text-slate-700">
                            {{ $student->type_label }}
                        </span>
                        @include('components.admin.badge-status', ['status' => $student->status])
                    </div>
                    <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">{{ $student->name }}</h2>
                    <p class="text-xs text-slate-500 font-mono mt-0.5">
                        {{ $student->type === 'magang' ? 'NIM' : 'NIS' }}: <strong class="text-slate-800">{{ $student->identity_number }}</strong>
                    </p>
                </div>
            </div>

            <div class="text-left sm:text-right">
                <p class="text-xs font-black text-slate-800">DINAS KOMUNIKASI DAN INFORMATIKA</p>
                <p class="text-[11px] font-semibold text-slate-500">Pemerintah Kabupaten Pacitan</p>
                <p class="text-[11px] text-slate-400 mt-1">Dicetak pada: {{ date('d F Y') }}</p>
            </div>
        </div>

        {{-- Details Grid --}}
        <div>
            <h3 class="text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-4">Informasi Akademik & Penempatan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 p-5 rounded-2xl neu-inset text-xs">
                <div>
                    <span class="text-slate-500 block mb-1 font-medium">Institusi Asal:</span>
                    <span class="font-extrabold text-slate-900 text-sm">{{ $student->institution ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-500 block mb-1 font-medium">Jurusan / Program Studi:</span>
                    <span class="font-extrabold text-slate-900 text-sm">{{ $student->major }}</span>
                    @if ($student->type === 'prakerin' && $student->class)
                        <span class="text-slate-500 block text-[11px] mt-0.5 font-semibold">Kelas: {{ $student->class }}</span>
                    @elseif ($student->type === 'magang' && $student->faculty)
                        <span class="text-slate-500 block text-[11px] mt-0.5 font-semibold">{{ $student->faculty }}</span>
                    @endif
                </div>
                <div>
                    <span class="text-slate-500 block mb-1 font-medium">Bidang Penempatan:</span>
                    <span class="font-black text-[#3B52F6] text-sm flex items-center gap-1.5">
                        @if ($student->department)
                            <i data-lucide="{{ $student->department->icon }}" class="w-4 h-4"></i>
                        @endif
                        {{ $student->department?->name ?? 'Belum ditentukan' }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-500 block mb-1 font-medium">Periode Praktik / Magang:</span>
                    <span class="font-extrabold text-slate-900 text-sm">
                        {{ $student->start_date ? $student->start_date->format('d M Y') : '-' }} s/d {{ $student->end_date ? $student->end_date->format('d M Y') : '-' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Assessment & Evaluation Section --}}
        <div class="space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-slate-900">Hasil Evaluasi & Penilaian</h3>
                    <p class="text-xs text-slate-500 font-medium">Rekap skor nilai dari pembimbing lapangan</p>
                </div>
                @if ($student->assessment)
                    <div class="no-print">
                        <a href="{{ route('admin.assessments.edit', $student->assessment->id) }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl neu-btn text-slate-700 text-xs font-bold transition-all">
                            <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                            <span>Ubah Nilai</span>
                        </a>
                    </div>
                @endif
            </div>

            @if ($student->assessment)
                {{-- Score Summary Card --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 rounded-2xl neu-inset flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold text-amber-700 uppercase tracking-wider">Rata-rata Skor</span>
                            <h4 class="text-2xl font-black text-amber-900 mt-1">{{ $student->assessment->average_score }}</h4>
                        </div>
                        <div class="w-11 h-11 rounded-2xl neu-card-sm text-amber-600 flex items-center justify-center font-bold">
                            <i data-lucide="award" class="w-5 h-5"></i>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl neu-inset flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold text-[#3B52F6] uppercase tracking-wider">Kategori Performa</span>
                            <h4 class="text-lg font-black text-blue-900 mt-1">{{ $student->assessment->category?->name ?? '-' }}</h4>
                        </div>
                        <div class="w-11 h-11 rounded-2xl neu-card-sm text-[#3B52F6] flex items-center justify-center font-bold">
                            <i data-lucide="badge-check" class="w-5 h-5"></i>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl neu-inset flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tanggal Penilaian</span>
                            <h4 class="text-sm font-black text-slate-800 mt-1">
                                {{ $student->assessment->assessment_date ? $student->assessment->assessment_date->format('d F Y') : '-' }}
                            </h4>
                        </div>
                        <div class="w-11 h-11 rounded-2xl neu-card-sm text-slate-600 flex items-center justify-center font-bold">
                            <i data-lucide="calendar" class="w-5 h-5"></i>
                        </div>
                    </div>
                </div>

                {{-- Detailed Aspects Table --}}
                <div class="neu-card rounded-2xl overflow-hidden">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-[#d8e2ee] bg-[#ebf0f7] text-slate-500 font-extrabold uppercase text-[10px] tracking-wider">
                                <th class="py-3 px-4 w-12 text-center">No</th>
                                <th class="py-3 px-4">Aspek Penilaian</th>
                                <th class="py-3 px-4 text-center w-28">Nilai (0-100)</th>
                                <th class="py-3 px-4">Taraf Kinerja</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#d8e2ee]">
                            @foreach ($student->assessment->scores as $index => $scoreItem)
                                <tr class="hover:bg-slate-300/30 transition-colors">
                                    <td class="py-3 px-4 text-center text-slate-500 font-bold">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 font-bold text-slate-800">{{ $scoreItem->aspect?->name ?? 'Aspek' }}</td>
                                    <td class="py-3 px-4 text-center font-black text-slate-900 font-mono text-sm">{{ $scoreItem->score }}</td>
                                    <td class="py-3 px-4">
                                        @if ($scoreItem->score >= 85)
                                            <span class="text-emerald-700 font-bold">Sangat Baik</span>
                                        @elseif ($scoreItem->score >= 75)
                                            <span class="text-[#3B52F6] font-bold">Baik</span>
                                        @elseif ($scoreItem->score >= 65)
                                            <span class="text-amber-700 font-bold">Cukup</span>
                                        @else
                                            <span class="text-rose-600 font-bold">Perlu Pembinaan</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Notes --}}
                @if ($student->assessment->notes)
                    <div class="p-4 rounded-2xl neu-inset text-xs">
                        <p class="font-bold text-slate-700 mb-1">Catatan Pembimbing Lapangan:</p>
                        <p class="text-slate-600 leading-relaxed italic">"{{ $student->assessment->notes }}"</p>
                    </div>
                @endif
            @else
                {{-- Not yet assessed callout --}}
                <div class="p-8 rounded-3xl neu-inset text-center space-y-4">
                    <div class="w-14 h-14 rounded-2xl neu-card-sm text-[#3B52F6] mx-auto flex items-center justify-center">
                        <i data-lucide="clipboard-list" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <h4 class="text-base font-black text-slate-800">Peserta Ini Belum Dinilai</h4>
                        <p class="text-xs text-slate-500 font-medium mt-1">Penilaian dapat diinput oleh Administrator maupun Operator.</p>
                    </div>
                    <a href="{{ route('admin.assessments.create', ['student_id' => $student->id]) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl neu-primary text-white text-xs font-bold btn-press">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Beri Penilaian Sekarang</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
