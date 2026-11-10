@extends('layouts/admin')

@section('title', 'Ekspor Data ke Excel')
@section('page-title', 'Ekspor Data ke Format Excel (.xlsx)')
@section('page-subtitle', 'Unduh rekapitulasi data siswa magang, instansi, dan nilai ke format spreadsheet')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.export.download') }}" class="neu-card p-6 md:p-8 rounded-3xl space-y-6">
        @csrf

        {{-- 1. Pilih Dataset yang Diekspor --}}
        <div>
            <div class="flex items-center gap-2.5 mb-3">
                <div class="neu-card-sm w-8 h-8 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                </div>
                <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                    1. Pilih Dataset yang Ingin Diekspor <span class="text-rose-500">*</span>
                </label>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <label class="neu-card-sm p-5 rounded-2xl cursor-pointer flex flex-col justify-between transition-all has-checked:neu-inset-sm has-checked:border has-checked:border-emerald-500/30 has-checked:bg-emerald-50/20">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-800">Semua Data (2 Sheet)</span>
                        <input type="radio" name="dataset" value="both" checked class="w-4 h-4 text-emerald-600 border-slate-300">
                    </div>
                    <p class="text-[11px] text-slate-500">Sheet Siswa/Mahasiswa dan Sheet Penilaian sekaligus dalam 1 workbook</p>
                </label>

                <label class="neu-card-sm p-5 rounded-2xl cursor-pointer flex flex-col justify-between transition-all has-checked:neu-inset-sm has-checked:border has-checked:border-emerald-500/30 has-checked:bg-emerald-50/20">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-800">Data Siswa / Mahasiswa</span>
                        <input type="radio" name="dataset" value="students" class="w-4 h-4 text-emerald-600 border-slate-300">
                    </div>
                    <p class="text-[11px] text-slate-500">Hanya sheet identitas, sekolah, bidang, dan status keaktifan</p>
                </label>

                <label class="neu-card-sm p-5 rounded-2xl cursor-pointer flex flex-col justify-between transition-all has-checked:neu-inset-sm has-checked:border has-checked:border-emerald-500/30 has-checked:bg-emerald-50/20">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-800">Data Penilaian</span>
                        <input type="radio" name="dataset" value="assessments" class="w-4 h-4 text-emerald-600 border-slate-300">
                    </div>
                    <p class="text-[11px] text-slate-500">Hanya rekap skor seluruh aspek kinerja dan predikat capaian</p>
                </label>
            </div>
            @error('dataset')
                <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- 2. Filter Ekspor Opsional --}}
        <div class="pt-5 border-t border-slate-200/70 space-y-4">
            <div>
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
                    2. Filter Ekspor (Opsional)
                </h4>
                <p class="text-xs text-slate-500 mt-0.5">Kosongkan opsi filter di bawah jika ingin mengekspor seluruh data</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Filter Tahun --}}
                <div>
                    <label for="year" class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun Angkatan / Mulai</label>
                    <select name="year" id="year" class="neu-input w-full px-4 py-2.5 rounded-xl text-xs text-slate-800 bg-[#ebf0f7]">
                        <option value="">Semua Tahun</option>
                        @foreach ($availableYears as $yr)
                            <option value="{{ $yr }}">Tahun {{ $yr }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Tipe --}}
                <div>
                    <label for="type" class="block text-xs font-semibold text-slate-700 mb-1.5">Tipe Peserta</label>
                    <select name="type" id="type" class="neu-input w-full px-4 py-2.5 rounded-xl text-xs text-slate-800 bg-[#ebf0f7]">
                        <option value="">Semua Tipe (Prakerin & Magang)</option>
                        <option value="prakerin">Siswa Prakerin (SMK)</option>
                        <option value="magang">Mahasiswa Magang (Universitas)</option>
                    </select>
                </div>

                {{-- Filter Bidang --}}
                <div>
                    <label for="department_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Bidang Penempatan</label>
                    <select name="department_id" id="department_id" class="neu-input w-full px-4 py-2.5 rounded-xl text-xs text-slate-800 bg-[#ebf0f7]">
                        <option value="">Semua Bidang</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Status --}}
                <div>
                    <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">Status Keaktifan</label>
                    <select name="status" id="status" class="neu-input w-full px-4 py-2.5 rounded-xl text-xs text-slate-800 bg-[#ebf0f7]">
                        <option value="">Semua Status</option>
                        <option value="active">Sedang Aktif</option>
                        <option value="completed">Selesai</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="pt-4 border-t border-slate-200/70 flex items-center justify-end">
            <button type="submit"
                    class="neu-btn px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-bold shadow-lg shadow-emerald-600/25 transition-all flex items-center gap-2 cursor-pointer border border-emerald-500/40">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Unduh File Excel (.xlsx)</span>
            </button>
        </div>
    </form>
</div>
@endsection
