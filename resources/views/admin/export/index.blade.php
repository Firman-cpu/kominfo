@extends('layouts/admin')

@section('title', 'Ekspor Data ke Excel')
@section('page-title', 'Ekspor Data ke Format Excel (.xlsx)')
@section('page-subtitle', 'Unduh rekapitulasi data siswa, mahasiswa, dan nilai evaluasi resmi')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-emerald-50/70 border border-emerald-200 p-5 rounded-2xl flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
            <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
        </div>
        <div class="text-xs text-emerald-900 leading-relaxed">
            <h4 class="font-bold">Keamanan & Performa Ekspor Terpadu</h4>
            <p class="mt-0.5 text-emerald-800">
                Ekspor data menggunakan mesin streaming OpenSpout yang ringan dan cepat. Dilengkapi proteksi otomatis terhadap <em>CSV/Formula Injection</em> serta pencatatan audit log untuk kepatuhan administrasi.
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.export.download') }}" class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf

        {{-- 1. Pilih Dataset yang Diekspor --}}
        <div>
            <label class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-3">
                1. Pilih Dataset yang Ingin Diekspor <span class="text-rose-500">*</span>
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <label class="p-4 rounded-xl border-2 border-slate-200 hover:border-blue-400 cursor-pointer flex flex-col justify-between transition-all has-checked:border-blue-600 has-checked:bg-blue-50/50 has-checked:ring-2 has-checked:ring-blue-500/20">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-800">Semua Data (2 Sheet)</span>
                        <input type="radio" name="dataset" value="both" checked class="w-4 h-4 text-blue-600 border-slate-300">
                    </div>
                    <p class="text-[11px] text-slate-500">Sheet Siswa/Mahasiswa dan Sheet Penilaian sekaligus</p>
                </label>

                <label class="p-4 rounded-xl border-2 border-slate-200 hover:border-blue-400 cursor-pointer flex flex-col justify-between transition-all has-checked:border-blue-600 has-checked:bg-blue-50/50 has-checked:ring-2 has-checked:ring-blue-500/20">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-800">Data Siswa / Mahasiswa</span>
                        <input type="radio" name="dataset" value="students" class="w-4 h-4 text-blue-600 border-slate-300">
                    </div>
                    <p class="text-[11px] text-slate-500">Hanya sheet identitas, sekolah, bidang, dan status</p>
                </label>

                <label class="p-4 rounded-xl border-2 border-slate-200 hover:border-blue-400 cursor-pointer flex flex-col justify-between transition-all has-checked:border-blue-600 has-checked:bg-blue-50/50 has-checked:ring-2 has-checked:ring-blue-500/20">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-800">Data Penilaian</span>
                        <input type="radio" name="dataset" value="assessments" class="w-4 h-4 text-blue-600 border-slate-300">
                    </div>
                    <p class="text-[11px] text-slate-500">Hanya rekap skor seluruh aspek kinerja peserta</p>
                </label>
            </div>
            @error('dataset')
                <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- 2. Filter Ekspor Opsional --}}
        <div class="pt-4 border-t border-slate-100 space-y-4">
            <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
                2. Filter Ekspor (Opsional)
            </h4>
            <p class="text-xs text-slate-500 -mt-2">Kosongkan opsi filter di bawah jika ingin mengekspor seluruh data</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Filter Tahun --}}
                <div>
                    <label for="year" class="block text-xs font-semibold text-slate-700 mb-1">Tahun Angkatan / Mulai</label>
                    <select name="year" id="year" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 bg-white">
                        <option value="">Semua Tahun</option>
                        @foreach ($availableYears as $yr)
                            <option value="{{ $yr }}">Tahun {{ $yr }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Tipe --}}
                <div>
                    <label for="type" class="block text-xs font-semibold text-slate-700 mb-1">Tipe Peserta</label>
                    <select name="type" id="type" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 bg-white">
                        <option value="">Semua Tipe (Prakerin & Magang)</option>
                        <option value="prakerin">Siswa Prakerin (SMK)</option>
                        <option value="magang">Mahasiswa Magang (Universitas)</option>
                    </select>
                </div>

                {{-- Filter Bidang --}}
                <div>
                    <label for="department_id" class="block text-xs font-semibold text-slate-700 mb-1">Bidang Penempatan</label>
                    <select name="department_id" id="department_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 bg-white">
                        <option value="">Semua Bidang</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Status --}}
                <div>
                    <label for="status" class="block text-xs font-semibold text-slate-700 mb-1">Status Keaktifan</label>
                    <select name="status" id="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 bg-white">
                        <option value="">Semua Status</option>
                        <option value="active">Sedang Aktif</option>
                        <option value="completed">Selesai</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="pt-6 border-t border-slate-100 flex items-center justify-end">
            <button type="submit"
                    class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition-all flex items-center gap-2 cursor-pointer">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Unduh File Excel (.xlsx)</span>
            </button>
        </div>
    </form>
</div>
@endsection
