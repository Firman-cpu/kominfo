@extends('layouts/admin')

@section('title', 'Edit Penilaian — ' . $assessment->student?->name)
@section('page-title', 'Edit Penilaian Peserta')
@section('page-subtitle', 'Pembaruan data skor kompetensi dan evaluasi kinerja peserta')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.assessments.index') }}"
           class="neu-btn px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:text-slate-900 inline-flex items-center gap-1.5 transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Penilaian</span>
        </a>
        <a href="{{ route('admin.assessments.show', $assessment->id) }}"
           class="neu-btn px-4 py-2 rounded-xl text-xs font-semibold text-blue-600 hover:text-blue-800 inline-flex items-center gap-1.5 transition-all">
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
                  if (avg >= 90) return { name: 'Sangat Baik', color: 'bg-emerald-50 text-emerald-800 border-emerald-300' };
                  if (avg >= 80) return { name: 'Baik', color: 'bg-blue-50 text-blue-800 border-blue-300' };
                  if (avg >= 70) return { name: 'Cukup', color: 'bg-amber-50 text-amber-800 border-amber-300' };
                  if (avg >= 60) return { name: 'Perlu Perhatian', color: 'bg-orange-50 text-orange-800 border-orange-300' };
                  return { name: 'Perlu Evaluasi', color: 'bg-rose-50 text-rose-800 border-rose-300' };
              }
          }"
          class="space-y-6">
        @csrf
        @method('PUT')

        <input type="hidden" name="student_id" value="{{ $assessment->student_id }}">

        {{-- Info Peserta --}}
        <div class="neu-card p-6 md:p-8 rounded-3xl flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div class="flex items-center gap-4">
                <div class="neu-card-sm w-16 h-16 rounded-2xl overflow-hidden p-1 shrink-0">
                    <img src="{{ $assessment->student?->photo_url }}"
                         alt="{{ $assessment->student?->name }}"
                         class="w-full h-full rounded-xl object-cover">
                </div>
                <div>
                    <span class="inline-flex rounded text-[11px] font-bold uppercase tracking-wider mb-0.5 {{ $assessment->student?->type === 'magang' ? 'text-indigo-600' : 'text-blue-600' }}">
                        {{ $assessment->student?->type_label }}
                    </span>
                    <h3 class="text-lg font-extrabold text-slate-900">{{ $assessment->student?->name }}</h3>
                    <p class="text-xs text-slate-500 font-mono mt-0.5">
                        {{ $assessment->student?->identity_number }} &bull; {{ $assessment->student?->institution ?? '-' }} &bull; Bidang: {{ $assessment->student?->department?->name ?? '-' }}
                    </p>
                </div>
            </div>

            <div class="shrink-0">
                <label for="assessment_date" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Tanggal Penilaian
                </label>
                <input type="date"
                       name="assessment_date"
                       id="assessment_date"
                       value="{{ old('assessment_date', $assessment->assessment_date ? $assessment->assessment_date->format('Y-m-d') : date('Y-m-d')) }}"
                       required
                       class="neu-input px-3.5 py-2 rounded-xl text-xs text-slate-800">
            </div>
        </div>

        {{-- Skor Aspek --}}
        <div class="neu-card p-6 md:p-8 rounded-3xl space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/70 pb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <div class="neu-card-sm w-9 h-9 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                            <i data-lucide="sliders" class="w-4 h-4"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900">Aspek Penilaian Kinerja</h4>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Ubah nilai sesuai evaluasi pembimbing lapangan</p>
                </div>

                {{-- Live Score & Category Widget --}}
                <div class="neu-card-sm flex items-center gap-3.5 p-3.5 rounded-2xl border border-white/80 shrink-0">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Rata-rata:</span>
                        <span class="text-2xl font-black text-blue-700" x-text="average"></span>
                    </div>
                    <div class="border-l border-slate-300/60 pl-3.5">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Kategori:</span>
                        <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold border"
                              :class="categoryLabel.color"
                              x-text="categoryLabel.name"></span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                @foreach ($aspects as $aspect)
                    <div class="neu-card-sm p-4 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 border border-white/70">
                        <div class="flex-1">
                            <label for="aspect_{{ $aspect->id }}" class="block text-xs font-bold text-slate-900">
                                {{ $aspect->name }}
                            </label>
                            <p class="text-[11px] text-slate-500 mt-0.5">Aspek evaluasi kinerja peserta</p>
                        </div>

                        <div class="flex items-center gap-3.5 shrink-0">
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
                                   class="neu-input w-20 px-2.5 py-2 rounded-xl text-center text-sm font-extrabold font-mono text-slate-900 bg-[#ebf0f7]">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Catatan --}}
        <div class="neu-card p-6 md:p-8 rounded-3xl space-y-4">
            <div class="flex items-center gap-2.5 border-b border-slate-200/70 pb-3">
                <div class="neu-card-sm w-9 h-9 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                </div>
                <h4 class="text-sm font-bold text-slate-900">Catatan dan Rekomendasi Pembimbing</h4>
            </div>
            <textarea name="notes"
                      id="notes"
                      rows="3"
                      class="neu-input w-full px-4 py-3 rounded-xl text-sm text-slate-800 placeholder-slate-400">{{ old('notes', $assessment->notes) }}</textarea>
            @error('notes')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.assessments.index') }}"
               class="neu-btn px-5 py-2.5 rounded-xl text-slate-700 text-xs font-semibold transition-all">
                Batal
            </a>
            <button type="submit"
                    class="neu-primary px-6 py-2.5 rounded-xl text-white text-xs font-semibold shadow-lg shadow-blue-500/20 transition-all flex items-center gap-2 cursor-pointer">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Perbarui Penilaian</span>
            </button>
        </div>
    </form>
</div>
@endsection
