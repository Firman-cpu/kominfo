@extends('layouts.admin')

@section('title', 'Data Siswa & Mahasiswa')
@section('page-title', 'Siswa Prakerin & Mahasiswa Magang')
@section('page-subtitle', 'Daftar seluruh peserta yang terdaftar di sistem')

@section('content')
<div class="space-y-7">
    {{-- Header Action & Search/Filter Toolbar --}}
    <div class="neu-card p-6 sm:p-7 rounded-3xl space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Daftar Seluruh Peserta</h3>
                <p class="text-xs text-slate-500 font-medium">Total terdata: <strong class="text-slate-800">{{ $students->total() }}</strong> peserta PKL/Magang</p>
            </div>
            <div class="flex items-center gap-2.5 flex-wrap">
                <a href="{{ route('admin.export.index') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl neu-btn text-slate-700 text-xs font-bold">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i>
                    <span>Ekspor Excel</span>
                </a>
                <a href="{{ route('admin.students.create') }}"
                   class="inline-flex items-center gap-1.5 px-4.5 py-2.5 rounded-xl neu-dark-cta text-white text-xs font-bold btn-press">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span>Tambah Peserta Baru</span>
                </a>
            </div>
        </div>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('admin.students.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 pt-4 border-t border-[#d8e2ee]">
            {{-- Search Input --}}
            <div class="lg:col-span-1">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama, NIS, instansi..."
                           class="w-full pl-10 pr-3.5 py-2.5 neu-input text-xs font-medium placeholder-slate-400">
                </div>
            </div>

            {{-- Filter Tahun --}}
            <div>
                <select name="year" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 neu-input text-xs font-bold text-slate-700">
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
                <select name="type" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 neu-input text-xs font-bold text-slate-700">
                    <option value="">Semua Tipe Peserta</option>
                    <option value="prakerin" {{ request('type') === 'prakerin' ? 'selected' : '' }}>Siswa Prakerin (SMK)</option>
                    <option value="magang" {{ request('type') === 'magang' ? 'selected' : '' }}>Mahasiswa Magang (PT)</option>
                </select>
            </div>

            {{-- Filter Bidang --}}
            <div>
                <select name="department_id" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 neu-input text-xs font-bold text-slate-700">
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
                <select name="status" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 neu-input text-xs font-bold text-slate-700">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Sedang Aktif</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
                @if (request()->hasAny(['search', 'year', 'type', 'department_id', 'status']))
                    <a href="{{ route('admin.students.index') }}"
                       class="p-2.5 rounded-xl neu-btn text-slate-600 hover:text-slate-900 shrink-0"
                       title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Main Data Table (Neumorphic) --}}
    <div class="neu-card rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-[#d8e2ee] bg-[#ebf0f7] text-slate-500 font-extrabold uppercase text-[10px] tracking-wider">
                        <th class="py-4 px-5">Peserta & Foto</th>
                        <th class="py-4 px-4">Tipe</th>
                        <th class="py-4 px-4">Sekolah / Kampus</th>
                        <th class="py-4 px-4">Jurusan / Prodi</th>
                        <th class="py-4 px-4">Bidang Penempatan</th>
                        <th class="py-4 px-4">Durasi PKL</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-4 text-center">Nilai</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#d8e2ee]">
                    @forelse ($students as $student)
                        <tr class="hover:bg-slate-300/30 transition-colors">
                            {{-- Peserta (Foto + Nama + Identitas) --}}
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $student->photo_url }}"
                                         alt="{{ $student->name }}"
                                         class="w-10 h-10 rounded-xl object-cover shrink-0 neu-card-sm">
                                    <div>
                                        <a href="{{ route('admin.students.show', $student->id) }}"
                                           class="font-black text-slate-900 hover:text-[#3B52F6] transition-colors">
                                            {{ $student->name }}
                                        </a>
                                        <p class="text-[11px] text-slate-500 font-mono mt-0.5">
                                            {{ $student->type === 'magang' ? 'NIM' : 'NIS' }}: {{ $student->identity_number }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Tipe --}}
                            <td class="py-4 px-4">
                                <span class="inline-flex px-2.5 py-1 rounded-xl neu-card-sm text-[11px] font-bold text-slate-700">
                                    {{ $student->type_label }}
                                </span>
                            </td>

                            {{-- Sekolah / Kampus --}}
                            <td class="py-4 px-4 font-bold text-slate-800">
                                {{ $student->institution ?? '-' }}
                            </td>

                            {{-- Jurusan --}}
                            <td class="py-4 px-4 text-slate-600 font-medium">
                                {{ $student->major }}
                                @if ($student->type === 'prakerin' && $student->class)
                                    <span class="block text-[10px] text-slate-400 mt-0.5">Kelas: {{ $student->class }}</span>
                                @elseif ($student->type === 'magang' && $student->faculty)
                                    <span class="block text-[10px] text-slate-400 mt-0.5">{{ $student->faculty }}</span>
                                @endif
                            </td>

                            {{-- Bidang --}}
                            <td class="py-4 px-4">
                                @if ($student->department)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl neu-inset-sm text-[11px] font-bold text-slate-800">
                                        <i data-lucide="{{ $student->department->icon }}" class="w-3.5 h-3.5 text-[#3B52F6]"></i>
                                        {{ $student->department->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Belum diatur</span>
                                @endif
                            </td>

                            {{-- Durasi --}}
                            <td class="py-4 px-4 text-slate-600 font-semibold text-[11px]">
                                {{ $student->start_date ? $student->start_date->format('d/m/Y') : '-' }}
                                <span class="text-slate-400">s/d</span>
                                {{ $student->end_date ? $student->end_date->format('d/m/Y') : '-' }}
                            </td>

                            {{-- Status --}}
                            <td class="py-4 px-4">
                                @include('components.admin.badge-status', ['status' => $student->status])
                            </td>

                            {{-- Status Penilaian --}}
                            <td class="py-4 px-4 text-center">
                                @if ($student->assessment)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl neu-card-sm text-[11px] font-black text-amber-700" title="Rata-rata Nilai">
                                        <i data-lucide="star" class="w-3.5 h-3.5 text-amber-500 fill-amber-500"></i>
                                        {{ $student->assessment->average_score }}
                                    </span>
                                @else
                                    <a href="{{ route('admin.assessments.create', ['student_id' => $student->id]) }}"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl neu-btn text-[11px] text-[#3B52F6] font-bold">
                                        <i data-lucide="plus-circle" class="w-3 h-3"></i>
                                        Beri Nilai
                                    </a>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="py-4 px-5 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.students.show', $student->id) }}"
                                       class="p-2 rounded-xl neu-btn text-slate-600 hover:text-[#3B52F6] transition-colors"
                                       title="Lihat Detail Lengkap">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('admin.students.edit', $student->id) }}"
                                       class="p-2 rounded-xl neu-btn text-slate-600 hover:text-amber-600 transition-colors"
                                       title="Edit Data">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.students.destroy', $student->id) }}"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $student->name }}? Data nilai terkait juga akan terhapus.')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-xl neu-btn text-slate-600 hover:text-rose-600 transition-colors cursor-pointer"
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
                                    <div class="w-12 h-12 rounded-2xl neu-inset flex items-center justify-center mx-auto mb-3 text-slate-400">
                                        <i data-lucide="users" class="w-6 h-6"></i>
                                    </div>
                                    <p class="font-bold text-slate-700">Tidak ada data peserta ditemukan.</p>
                                    <p class="text-xs text-slate-500 mt-1">Coba sesuaikan kata kunci pencarian atau filter yang Anda gunakan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($students->hasPages())
            <div class="p-4 border-t border-[#d8e2ee] bg-[#ebf0f7]">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
