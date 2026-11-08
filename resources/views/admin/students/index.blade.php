@extends('layouts/admin')

@section('title', 'Data Siswa & Mahasiswa')
@section('page-title', 'Siswa Prakerin & Mahasiswa Magang')
@section('page-subtitle', 'Pengelolaan data peserta PKL Dinas Komunikasi dan Informatika')

@section('content')
<div class="space-y-6">
    {{-- Header Action & Search/Filter Toolbar --}}
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Daftar Seluruh Peserta</h3>
                <p class="text-xs text-slate-500">Total terdata: {{ $students->total() }} peserta</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.export.index') }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i>
                    <span>Ekspor Excel</span>
                </a>
                <a href="{{ route('admin.students.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition-colors">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span>Tambah Peserta Baru</span>
                </a>
            </div>
        </div>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('admin.students.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 pt-3 border-t border-slate-100">
            {{-- Search Input --}}
            <div class="lg:col-span-1">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-3.5 h-3.5"></i>
                    </span>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama, NIS, instansi..."
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
                    <option value="">Semua Tipe Peserta</option>
                    <option value="prakerin" {{ request('type') === 'prakerin' ? 'selected' : '' }}>Siswa Prakerin (SMK)</option>
                    <option value="magang" {{ request('type') === 'magang' ? 'selected' : '' }}>Mahasiswa Magang (PT)</option>
                </select>
            </div>

            {{-- Filter Bidang --}}
            <div>
                <select name="department_id" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-700 bg-white">
                    <option value="">Semua Bidang</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Status & Submit/Reset --}}
            <div class="flex items-center gap-2">
                <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-700 bg-white">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Sedang Aktif</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
                @if (request()->hasAny(['search', 'year', 'type', 'department_id', 'status']))
                    <a href="{{ route('admin.students.index') }}"
                       class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs transition-colors shrink-0"
                       title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Main Data Table --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-4">Peserta & Foto</th>
                        <th class="py-3.5 px-4">Tipe</th>
                        <th class="py-3.5 px-4">Sekolah / Kampus</th>
                        <th class="py-3.5 px-4">Jurusan / Prodi</th>
                        <th class="py-3.5 px-4">Bidang Penempatan</th>
                        <th class="py-3.5 px-4">Durasi PKL</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-center">Nilai</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($students as $student)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            {{-- Peserta (Foto + Nama + Identitas) --}}
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $student->photo_url }}"
                                         alt="{{ $student->name }}"
                                         class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-xs shrink-0">
                                    <div>
                                        <a href="{{ route('admin.students.show', $student->id) }}"
                                           class="font-bold text-slate-900 hover:text-blue-600 transition-colors">
                                            {{ $student->name }}
                                        </a>
                                        <p class="text-[11px] text-slate-500 font-mono">
                                            {{ $student->type === 'magang' ? 'NIM' : 'NIS' }}: {{ $student->identity_number }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Tipe --}}
                            <td class="py-3.5 px-4">
                                <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-semibold {{ $student->type === 'magang' ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                    {{ $student->type_label }}
                                </span>
                            </td>

                            {{-- Sekolah / Kampus --}}
                            <td class="py-3.5 px-4 font-medium text-slate-800">
                                {{ $student->institution ?? '-' }}
                            </td>

                            {{-- Jurusan --}}
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $student->major }}
                                @if ($student->type === 'prakerin' && $student->class)
                                    <span class="block text-[10px] text-slate-400">Kelas: {{ $student->class }}</span>
                                @elseif ($student->type === 'magang' && $student->faculty)
                                    <span class="block text-[10px] text-slate-400">{{ $student->faculty }}</span>
                                @endif
                            </td>

                            {{-- Bidang --}}
                            <td class="py-3.5 px-4">
                                @if ($student->department)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $student->department->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Belum diatur</span>
                                @endif
                            </td>

                            {{-- Durasi --}}
                            <td class="py-3.5 px-4 text-slate-600 text-[11px]">
                                {{ $student->start_date ? $student->start_date->format('d/m/Y') : '-' }}
                                <span class="text-slate-400">s/d</span>
                                {{ $student->end_date ? $student->end_date->format('d/m/Y') : '-' }}
                            </td>

                            {{-- Status --}}
                            <td class="py-3.5 px-4">
                                @include('components.admin.badge-status', ['status' => $student->status])
                            </td>

                            {{-- Status Penilaian --}}
                            <td class="py-3.5 px-4 text-center">
                                @if ($student->assessment)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200" title="Rata-rata Nilai">
                                        <i data-lucide="star" class="w-3 h-3 text-amber-500 fill-amber-500"></i>
                                        {{ $student->assessment->average_score }}
                                    </span>
                                @else
                                    <a href="{{ route('admin.assessments.create', ['student_id' => $student->id]) }}"
                                       class="inline-flex items-center gap-1 text-[11px] text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                        <i data-lucide="plus-circle" class="w-3 h-3"></i>
                                        Beri Nilai
                                    </a>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('admin.students.show', $student->id) }}"
                                       class="p-1.5 rounded-lg text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                       title="Lihat Detail Lengkap">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('admin.students.edit', $student->id) }}"
                                       class="p-1.5 rounded-lg text-slate-600 hover:text-amber-600 hover:bg-amber-50 transition-colors"
                                       title="Edit Data">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.students.destroy', $student->id) }}"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $student->name }}? Data nilai terkait juga akan terhapus.')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 rounded-lg text-slate-600 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer"
                                                title="Hapus Data">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-400">
                                <div class="max-w-sm mx-auto">
                                    <i data-lucide="users" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                    <p class="font-medium text-slate-600">Tidak ada data peserta ditemukan.</p>
                                    <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau filter yang Anda gunakan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($students->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection