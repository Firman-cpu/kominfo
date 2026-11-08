@extends('layouts/admin')

@section('title', 'Penilaian Peserta PKL & Magang')
@section('page-title', 'Daftar Penilaian Peserta')
@section('page-subtitle', 'Evaluasi hasil praktik kerja industri dan magang dinas')

@section('content')
<div class="space-y-6">
    {{-- Header Action & Search/Filter Toolbar --}}
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Rekapitulasi Nilai Peserta</h3>
                <p class="text-xs text-slate-500">Tiap peserta hanya memiliki tepat 1 rekaman nilai</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.export.index') }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i>
                    <span>Ekspor Nilai</span>
                </a>
                <a href="{{ route('admin.assessments.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition-colors">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Input Penilaian Baru</span>
                </a>
            </div>
        </div>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('admin.assessments.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 pt-3 border-t border-slate-100">
            {{-- Search Input --}}
            <div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-3.5 h-3.5"></i>
                    </span>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama atau NIS/NIM..."
                           class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all placeholder-slate-400">
                </div>
            </div>

            {{-- Filter Tahun --}}
            <div>
                <select name="year" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-700 bg-white">
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
                <select name="type" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-700 bg-white">
                    <option value="">Semua Tipe</option>
                    <option value="prakerin" {{ request('type') === 'prakerin' ? 'selected' : '' }}>Siswa Prakerin</option>
                    <option value="magang" {{ request('type') === 'magang' ? 'selected' : '' }}>Mahasiswa Magang</option>
                </select>
            </div>

            {{-- Filter Bidang & Reset --}}
            <div class="flex items-center gap-2">
                <select name="department_id" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-700 bg-white">
                    <option value="">Semua Bidang</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                @if (request()->hasAny(['search', 'year', 'type', 'department_id']))
                    <a href="{{ route('admin.assessments.index') }}"
                       class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs transition-colors shrink-0"
                       title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Assessment Data Table --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-4">Peserta</th>
                        <th class="py-3.5 px-4">Tipe & Bidang</th>
                        <th class="py-3.5 px-4">Tanggal Penilaian</th>
                        <th class="py-3.5 px-4 text-center">Rata-rata Skor</th>
                        <th class="py-3.5 px-4">Kategori Performa</th>
                        <th class="py-3.5 px-4">Catatan</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($assessments as $item)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            {{-- Peserta --}}
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item->student?->photo_url }}"
                                         alt="{{ $item->student?->name }}"
                                         class="w-10 h-10 rounded-full object-cover border border-slate-200 shrink-0">
                                    <div>
                                        <a href="{{ route('admin.students.show', $item->student_id) }}"
                                           class="font-bold text-slate-900 hover:text-blue-600 transition-colors">
                                            {{ $item->student?->name ?? 'Peserta' }}
                                        </a>
                                        <p class="text-[11px] text-slate-500 font-mono">
                                            {{ $item->student?->identity_number }} &bull; {{ $item->student?->institution ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Tipe & Bidang --}}
                            <td class="py-3.5 px-4">
                                <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-semibold {{ $item->student?->type === 'magang' ? 'bg-indigo-50 text-indigo-700' : 'bg-blue-50 text-blue-700' }} border border-slate-200 block w-fit mb-1">
                                    {{ $item->student?->type_label ?? '-' }}
                                </span>
                                <span class="text-slate-600 font-medium">
                                    {{ $item->student?->department?->name ?? '-' }}
                                </span>
                            </td>

                            {{-- Tanggal --}}
                            <td class="py-3.5 px-4 text-slate-600 font-medium">
                                {{ $item->assessment_date ? $item->assessment_date->format('d/m/Y') : '-' }}
                            </td>

                            {{-- Skor --}}
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold bg-amber-50 text-amber-800 border border-amber-200">
                                    <i data-lucide="star" class="w-3.5 h-3.5 text-amber-500 fill-amber-500"></i>
                                    {{ $item->average_score }}
                                </span>
                            </td>

                            {{-- Kategori Performa --}}
                            <td class="py-3.5 px-4">
                                <span class="inline-flex px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200">
                                    {{ $item->category?->name ?? 'Belum terdefinisi' }}
                                </span>
                            </td>

                            {{-- Catatan --}}
                            <td class="py-3.5 px-4 text-slate-500 max-w-xs truncate italic">
                                {{ $item->notes ? '"' . $item->notes . '"' : '-' }}
                            </td>

                            {{-- Aksi --}}
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('admin.assessments.show', $item->id) }}"
                                       class="p-1.5 rounded-lg text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                       title="Lihat Lembar Nilai">
                                        <i data-lucide="file-text" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('admin.assessments.edit', $item->id) }}"
                                       class="p-1.5 rounded-lg text-slate-600 hover:text-amber-600 hover:bg-amber-50 transition-colors"
                                       title="Edit Nilai">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.assessments.destroy', $item->id) }}"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus penilaian peserta {{ $item->student?->name }}?')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 rounded-lg text-slate-600 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer"
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
                                    <i data-lucide="award" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                    <p class="font-medium text-slate-600">Belum ada data penilaian.</p>
                                    <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Input Penilaian Baru" untuk menilai peserta.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($assessments->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $assessments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection