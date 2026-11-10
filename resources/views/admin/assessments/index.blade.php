@extends('layouts/admin')

@section('title', 'Penilaian Peserta PKL & Magang')
@section('page-title', 'Daftar Penilaian Peserta')
@section('page-subtitle', 'Rekapitulasi nilai evaluasi kinerja dan predikat capaian peserta magang/PKL')

@section('content')
<div class="space-y-6">
    {{-- Header Action & Search/Filter Toolbar --}}
    <div class="neu-card p-6 rounded-3xl space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Rekapitulasi Nilai Peserta</h3>
                <p class="text-xs text-slate-500">Evaluasi seluruh aspek kinerja peserta selama berada di DISKOMINFO</p>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('admin.export.index') }}"
                   class="neu-btn px-4 py-2.5 rounded-xl text-slate-700 text-xs font-semibold inline-flex items-center gap-1.5 transition-all">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i>
                    <span>Ekspor Nilai</span>
                </a>
                <a href="{{ route('admin.assessments.create') }}"
                   class="neu-primary px-4 py-2.5 rounded-xl text-white text-xs font-semibold shadow-lg shadow-blue-500/20 inline-flex items-center gap-1.5 transition-all">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Input Penilaian Baru</span>
                </a>
            </div>
        </div>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('admin.assessments.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 pt-4 border-t border-slate-200/70">
            {{-- Search Input --}}
            <div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-3.5 h-3.5"></i>
                    </span>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama atau NIS/NIM..."
                           class="neu-input w-full pl-9 pr-3.5 py-2.5 rounded-xl text-xs placeholder-slate-400 text-slate-800">
                </div>
            </div>

            {{-- Filter Tahun --}}
            <div>
                <select name="year" onchange="this.form.submit()" class="neu-input w-full px-3.5 py-2.5 rounded-xl text-xs text-slate-700 bg-[#ebf0f7]">
                    <option value="">Semua Tahun</option>
                    @foreach ($availableYears as $yr)
                        <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>
                            Tahun {{ $yr }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Tipe --}}
            <div>
                <select name="type" onchange="this.form.submit()" class="neu-input w-full px-3.5 py-2.5 rounded-xl text-xs text-slate-700 bg-[#ebf0f7]">
                    <option value="">Semua Tipe</option>
                    <option value="prakerin" {{ request('type') === 'prakerin' ? 'selected' : '' }}>Siswa Prakerin</option>
                    <option value="magang" {{ request('type') === 'magang' ? 'selected' : '' }}>Mahasiswa Magang</option>
                </select>
            </div>

            {{-- Filter Bidang & Reset --}}
            <div class="flex items-center gap-2">
                <select name="department_id" onchange="this.form.submit()" class="neu-input w-full px-3.5 py-2.5 rounded-xl text-xs text-slate-700 bg-[#ebf0f7]">
                    <option value="">Semua Bidang</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                @if (request()->hasAny(['search', 'year', 'type', 'department_id']))
                    <a href="{{ route('admin.assessments.index') }}"
                       class="neu-btn p-2.5 rounded-xl text-slate-600 hover:text-slate-900 text-xs transition-all shrink-0"
                       title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Assessment Data Table --}}
    <div class="neu-card rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-300/60 bg-[#ebf0f7] text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                        <th class="py-4 px-5">Peserta</th>
                        <th class="py-4 px-5">Tipe & Bidang</th>
                        <th class="py-4 px-5">Tanggal Penilaian</th>
                        <th class="py-4 px-5 text-center">Rata-rata Skor</th>
                        <th class="py-4 px-5">Kategori Performa</th>
                        <th class="py-4 px-5">Catatan</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60">
                    @forelse ($assessments as $item)
                        <tr class="hover:bg-white/40 transition-colors">
                            {{-- Peserta --}}
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3.5">
                                    <div class="neu-card-sm w-11 h-11 rounded-xl overflow-hidden p-0.5 shrink-0">
                                        <img src="{{ $item->student?->photo_url }}"
                                             alt="{{ $item->student?->name }}"
                                             class="w-full h-full rounded-[10px] object-cover">
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.students.show', $item->student_id) }}"
                                           class="font-bold text-slate-900 hover:text-blue-600 transition-colors">
                                            {{ $item->student?->name ?? 'Peserta' }}
                                        </a>
                                        <p class="text-[11px] text-slate-500 font-mono mt-0.5">
                                            {{ $item->student?->identity_number }} &bull; {{ $item->student?->institution ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Tipe & Bidang --}}
                            <td class="py-4 px-5">
                                <span class="inline-flex rounded text-xs font-bold {{ $item->student?->type === 'magang' ? 'text-indigo-600' : 'text-blue-600' }} block mb-0.5">
                                    {{ $item->student?->type_label ?? '-' }}
                                </span>
                                <span class="text-slate-600 font-medium tracking-wide truncate block text-[11px]">
                                    {{ $item->student?->department?->name ?? '-' }}
                                </span>
                            </td>

                            {{-- Tanggal --}}
                            <td class="py-4 px-5 text-slate-600 font-medium">
                                {{ $item->assessment_date ? $item->assessment_date->format('d/m/Y') : '-' }}
                            </td>

                            {{-- Skor --}}
                            <td class="py-4 px-5 text-center">
                                <span class="neu-inset-sm inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-black text-amber-900 bg-amber-50/40 border border-amber-200/40">
                                    <i data-lucide="star" class="w-3.5 h-3.5 text-amber-500 fill-amber-500"></i>
                                    {{ $item->average_score }}
                                </span>
                            </td>

                            {{-- Kategori Performa --}}
                            <td class="py-4 px-5">
                                <span class="neu-card-sm inline-flex px-3 py-1 rounded-xl text-xs font-bold text-blue-900 border border-white/80">
                                    {{ $item->category?->name ?? 'Belum terdefinisi' }}
                                </span>
                            </td>

                            {{-- Catatan --}}
                            <td class="py-4 px-5 text-slate-500 max-w-xs truncate italic">
                                {{ $item->notes ? '"' . $item->notes . '"' : '-' }}
                            </td>

                            {{-- Aksi --}}
                            <td class="py-4 px-5 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.assessments.show', $item->id) }}"
                                       class="neu-btn p-2 rounded-xl text-slate-600 hover:text-blue-600 transition-all"
                                       title="Lihat Lembar Nilai">
                                        <i data-lucide="file-text" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('admin.assessments.edit', $item->id) }}"
                                       class="neu-btn p-2 rounded-xl text-slate-600 hover:text-amber-600 transition-all"
                                       title="Edit Nilai">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.assessments.destroy', $item->id) }}"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus penilaian peserta {{ $item->student?->name }}?')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="neu-btn p-2 rounded-xl text-slate-600 hover:text-rose-600 transition-all cursor-pointer"
                                                title="Hapus Nilai">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="max-w-sm mx-auto">
                                    <div class="neu-card-sm w-14 h-14 rounded-2xl flex items-center justify-center text-slate-400 mx-auto mb-3">
                                        <i data-lucide="award" class="w-7 h-7"></i>
                                    </div>
                                    <p class="font-bold text-slate-700">Belum ada data penilaian.</p>
                                    <p class="text-xs text-slate-500 mt-1">Gunakan tombol "Input Penilaian Baru" untuk menilai peserta.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($assessments->hasPages())
            <div class="p-4 border-t border-slate-200/80 bg-[#ebf0f7]/60">
                {{ $assessments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
