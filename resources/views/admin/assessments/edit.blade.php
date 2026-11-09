@extends('layouts/admin')

@section('title', 'Edit Penilaian — ' . $assessment->student?->name)
@section('page-title', 'Edit Penilaian Peserta')
@section('page-subtitle', '')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.assessments.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Penilaian</span>
        </a>
        <a href="{{ route('admin.assessments.show', $assessment->id) }}"
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800">
            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
            <span>Lihat Lembar Nilai</span>
        </a>
    </div>

    <form method="POST"
          action="{{ route('admin.assessments.update', $assessment->id) }}"
          x-data="{
              scores: {},
              init() {
                  @foreach ($aspects as $aspect)
                      this.scores['{{ $aspect->id }}'] = {{ old("scores.{$aspect->id}", $existingScores[$aspect->id] ?? 80) }};
                  @endforeach
              },
              get average() {
                  const values = Object.values(this.scores).map(v => parseFloat(v) || 0);
                  if (values.length === 0) return 0;
                  const sum = values.reduce((a, b) => a + b, 0);
                  return (sum / values.length).toFixed(1);
              },
              get categoryLabel() {
                  const avg = parseFloat(this.average);
                  if (avg >= 90) return { name: 'Sangat Baik', color: 'bg-emerald-50 text-emerald-700 border-emerald-200' };
                  if (avg >= 80) return { name: 'Baik', color: 'bg-blue-50 text-blue-700 border-blue-200' };
                  if (avg >= 70) return { name: 'Cukup', color: 'bg-amber-50 text-amber-700 border-amber-200' };
                  if (avg >= 60) return { name: 'Perlu Perhatian', color: 'bg-orange-50 text-orange-700 border-orange-200' };
                  return { name: 'Perlu Evaluasi', color: 'bg-rose-50 text-rose-700 border-rose-200' };
              }
          }"
          class="space-y-6">
        @csrf
        @method('PUT')

        <input type="hidden" name="student_id" value="{{ $assessment->student_id }}">

        {{-- Info Peserta --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img src="{{ $assessment->student?->photo_url }}"
                     alt="{{ $assessment->student?->name }}"
                     class="w-14 h-14 rounded-2xl object-cover shrink-0">
                <div>
                    <span class="inline-flex py-0.5 rounded text-[10px] font-bold uppercase {{ $assessment->student?->type === 'magang' ? 'text-indigo-700' : 'text-blue-700' }}">
                        {{ $assessment->student?->type_label }}
                    </span>
                    <h3 class="text-base font-extrabold text-slate-900">{{ $assessment->student?->name }}</h3>
                    <p class="text-xs text-slate-500 font-mono">
                        {{ $assessment->student?->identity_number }} &bull; {{ $assessment->student?->institution ?? '-' }} &bull; Bidang: {{ $assessment->student?->department?->name ?? '-' }}
                    </p>
                </div>
            </div>

            <div>
                <label for="assessment_date" class="block text-xs font-semibold text-slate-700 mb-1">
                    Tanggal Penilaian
                </label>
                <input type="date"
                       name="assessment_date"
                       id="assessment_date"
                       value="{{ old('assessment_date', $assessment->assessment_date ? $assessment->assessment_date->format('Y-m-d') : date('Y-m-d')) }}"
                       required
                       class="px-3.5 py-2 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
            </div>
        </div>

        {{-- Skor Aspek --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="sliders" class="w-4 h-4 text-blue-600"></i>
                        <span>Aspek Penilaian Kinerja</span>
                    </h4>
                    <p class="text-xs text-slate-500 mt-0.5">Ubah nilai sesuai evaluasi pembimbing</p>
                </div>

                {{-- Live Score & Category Widget --}}
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200 shrink-0">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Rata-rata:</span>
                        <span class="text-xl font-extrabold text-blue-700" x-text="average"></span>
                    </div>
                    <div class="border-l border-slate-200 pl-3">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Kategori:</span>
                        <span class="inline-flex px-2 py-0.5 rounded text-xs font-bold border"
                              :class="categoryLabel.color"
                              x-text="categoryLabel.name"></span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                @foreach ($aspects as $aspect)
                    <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex-1">
                            <label for="aspect_{{ $aspect->id }}" class="block text-xs font-bold text-slate-900">
                                {{ $aspect->name }}
                            </label>
                            <p class="text-[11px] text-slate-500 mt-0.5">Aspek evaluasi kinerja peserta</p>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            <input type="range"
                                   min="0"
                                   max="100"
                                   x-model="scores['{{ $aspect->id }}']"
                                   class="w-32 sm:w-48 accent-blue-600 cursor-pointer">
                            <input type="number"
                                   name="scores[{{ $aspect->id }}]"
                                   id="aspect_{{ $aspect->id }}"
                                   min="0"
                                   max="100"
                                   x-model.number="scores['{{ $aspect->id }}']"
                                   required
                                   class="w-20 px-2.5 py-2 rounded-xl border border-slate-300 text-center text-sm font-extrabold font-mono focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-900 bg-white">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Catatan --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
            <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="file-text" class="w-4 h-4 text-blue-600"></i>
                <span>Catatan dan Rekomendasi Pembimbing</span>
            </h4>
            <textarea name="notes"
                      id="notes"
                      rows="3"
                      class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">{{ old('notes', $assessment->notes) }}</textarea>
            @error('notes')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.assessments.index') }}"
               class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-100 text-xs font-semibold transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs shadow-blue-500/20 transition-all flex items-center gap-2 cursor-pointer">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Perbarui Penilaian</span>
            </button>
        </div>
    </form>
</div>
@endsection