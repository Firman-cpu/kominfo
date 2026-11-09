@extends('layouts/admin')

@section('title', 'Kategori Nilai & Performa')
@section('page-title', 'Batas Kategori Performa')
@section('page-subtitle', '')

@section('content')
    <form method="POST" action="{{ route('admin.categories.update') }}" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        @csrf
        @method('PUT')

        <div class="p-6 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-900">Konfigurasi Ambang Batas Nilai Minimum</h3>
            <p class="text-xs text-slate-500 mt-0.5">Atur batas nilai minimum (0-100) untuk masing-masing taraf predikat</p>
        </div>

        <div class="p-6 space-y-6">
            @foreach ($categories as $index => $cat)
                <input type="hidden" name="categories[{{ $index }}][id]" value="{{ $cat->id }}">

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    {{-- Predikat / Nama --}}
                    <div class="md:col-span-4">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Predikat</label>
                        <input type="text"
                               name="categories[{{ $index }}][name]"
                               value="{{ old("categories.{$index}.name", $cat->name) }}"
                               required
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 bg-white">
                    </div>

                    {{-- Batas Minimum --}}
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Batas Minimal Skor (≥)</label>
                        <div class="relative">
                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   max="100"
                                   name="categories[{{ $index }}][min_score]"
                                   value="{{ old("categories.{$index}.min_score", $cat->min_score) }}"
                                   required
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono font-extrabold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-blue-700 bg-white">
                        </div>
                    </div>

                    {{-- Keterangan / Deskripsi --}}
                    <div class="md:col-span-5">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Hasil</label>
                        <input type="text"
                               name="categories[{{ $index }}][description]"
                               value="{{ old("categories.{$index}.description", $cat->description) }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 bg-white">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-end">
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition-all flex items-center gap-2 cursor-pointer">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Simpan Perubahan Kategori</span>
            </button>
        </div>
    </form>
</div>
@endsection
