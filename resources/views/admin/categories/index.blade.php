@extends('layouts/admin')

@section('title', 'Kategori Nilai & Performa')
@section('page-title', 'Batas Kategori Performa')
@section('page-subtitle', 'Penentuan rentang batas ambang skor untuk klasifikasi predikat kelulusan')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.categories.update') }}" class="neu-card p-6 md:p-8 rounded-3xl space-y-6">
        @csrf
        @method('PUT')

        <div class="flex items-center gap-2.5 border-b border-slate-200/70 pb-4">
            <div class="neu-card-sm w-9 h-9 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                <i data-lucide="award" class="w-4 h-4"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900">Konfigurasi Ambang Batas Nilai Minimum</h3>
                <p class="text-xs text-slate-500 mt-0.5">Atur batas nilai minimum (0-100) untuk masing-masing taraf predikat</p>
            </div>
        </div>

        <div class="space-y-4">
            @foreach ($categories as $index => $cat)
                <input type="hidden" name="categories[{{ $index }}][id]" value="{{ $cat->id }}">

                <div class="neu-card-sm p-5 rounded-2xl border border-white/70 grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    {{-- Predikat / Nama --}}
                    <div class="md:col-span-4">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Predikat</label>
                        <input type="text"
                               name="categories[{{ $index }}][name]"
                               value="{{ old("categories.{$index}.name", $cat->name) }}"
                               required
                               class="neu-input w-full px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-800 bg-[#ebf0f7]">
                    </div>

                    {{-- Batas Minimum --}}
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Batas Minimal Skor (≥)</label>
                        <div class="relative">
                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   max="100"
                                   name="categories[{{ $index }}][min_score]"
                                   value="{{ old("categories.{$index}.min_score", $cat->min_score) }}"
                                   required
                                   class="neu-input w-full px-3.5 py-2.5 rounded-xl text-xs font-mono font-black text-blue-700 bg-[#ebf0f7]">
                        </div>
                    </div>

                    {{-- Keterangan / Deskripsi --}}
                    <div class="md:col-span-5">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Hasil</label>
                        <input type="text"
                               name="categories[{{ $index }}][description]"
                               value="{{ old("categories.{$index}.description", $cat->description) }}"
                               class="neu-input w-full px-3.5 py-2.5 rounded-xl text-xs text-slate-800 bg-[#ebf0f7]">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pt-4 border-t border-slate-200/70 flex items-center justify-end">
            <button type="submit"
                    class="neu-primary px-6 py-2.5 rounded-xl text-white text-xs font-semibold shadow-lg shadow-blue-500/20 transition-all flex items-center gap-2 cursor-pointer">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Simpan Perubahan Kategori</span>
            </button>
        </div>
    </form>
</div>
@endsection
