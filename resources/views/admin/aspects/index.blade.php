@extends('layouts/admin')

@section('title', 'Kelola Aspek Penilaian')
@section('page-title', 'Aspek Penilaian Kinerja')
@section('page-subtitle', 'Manajemen kriteria dan parameter evaluasi capaian peserta PKL / Magang')

@section('content')
<div class="space-y-6" x-data="{
    showAddModal: false,
    showEditModal: false,
    editData: { id: '', name: '', sort_order: '', is_active: true },
    openEdit(aspect) {
        this.editData = { ...aspect };
        this.showEditModal = true;
    }
}">
    {{-- Header & Action --}}
    <div class="neu-card p-6 rounded-3xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-base font-bold text-slate-900">Daftar Aspek Penilaian Aktif</h3>
            <p class="text-xs text-slate-500">Aspek yang dinonaktifkan tidak akan muncul pada pengisian lembar penilaian baru.</p>
        </div>
        <button @click="showAddModal = true"
                class="neu-primary px-4 py-2.5 rounded-xl text-white text-xs font-semibold shadow-lg shadow-blue-500/20 inline-flex items-center gap-1.5 transition-all cursor-pointer">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Tambah Aspek Baru</span>
        </button>
    </div>

    {{-- Aspects Table --}}
    <div class="neu-card rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-[#ebf0f7] border-b border-slate-300/60 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                        <th class="py-4 px-5 w-16 text-center">Urutan</th>
                        <th class="py-4 px-5">Nama Aspek Penilaian</th>
                        <th class="py-4 px-5">Identifier Key</th>
                        <th class="py-4 px-5 text-center">Digunakan di Penilaian</th>
                        <th class="py-4 px-5 text-center">Status</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60">
                    @forelse ($aspects as $aspect)
                        <tr class="hover:bg-white/40 transition-colors">
                            <td class="py-4 px-5 text-center font-bold text-slate-700">
                                <span class="neu-inset-sm w-7 h-7 rounded-lg inline-flex items-center justify-center font-mono text-xs">
                                    {{ $aspect->sort_order }}
                                </span>
                            </td>
                            <td class="py-4 px-5 font-bold text-slate-900">
                                {{ $aspect->name }}
                            </td>
                            <td class="py-4 px-5 text-slate-500 font-mono text-[11px]">
                                {{ $aspect->key }}
                            </td>
                            <td class="py-4 px-5 text-center">
                                <span class="neu-card-sm inline-flex items-center px-3 py-1 rounded-xl text-[11px] font-semibold text-slate-700 border border-white/80">
                                    {{ $aspect->scores_count }} penilaian
                                </span>
                            </td>
                            <td class="py-4 px-5 text-center">
                                @if ($aspect->is_active)
                                    <span class="neu-card-sm inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold text-emerald-700 border border-emerald-200/50">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="neu-card-sm inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold text-slate-500 border border-slate-200/80">
                                        <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <button @click="openEdit({{ json_encode($aspect) }})"
                                            class="neu-btn p-2 rounded-xl text-slate-600 hover:text-blue-600 transition-all cursor-pointer"
                                            title="Edit Aspek">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>

                                    @if ($aspect->canBeDeleted())
                                        <form method="POST" action="{{ route('admin.aspects.destroy', $aspect->id) }}"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus aspek {{ $aspect->name }}?')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="neu-btn p-2 rounded-xl text-slate-600 hover:text-rose-600 transition-all cursor-pointer"
                                                    title="Hapus Aspek">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="p-2 text-slate-400 cursor-not-allowed opacity-50" title="Aspek ini sudah memiliki rekaman nilai, tidak dapat dihapus">
                                            <i data-lucide="lock" class="w-4 h-4"></i>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">
                                <div class="max-w-xs mx-auto">
                                    <i data-lucide="layers" class="w-8 h-8 text-slate-400 mx-auto mb-2"></i>
                                    <p class="font-bold text-slate-700">Belum ada aspek penilaian.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Aspek --}}
    <div x-cloak x-show="showAddModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" @click="showAddModal = false"></div>
        <div class="relative neu-card rounded-3xl max-w-md w-full p-6 md:p-8 border border-white/80 shadow-2xl">
            <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                <div class="neu-card-sm w-8 h-8 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                </div>
                <span>Tambah Aspek Penilaian</span>
            </h3>

            <form method="POST" action="{{ route('admin.aspects.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="aspect_name" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Nama Aspek <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           id="aspect_name"
                           required
                           placeholder="Contoh: Pemecahan Masalah (Problem Solving)"
                           class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800">
                </div>

                <div>
                    <label for="aspect_sort_order" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Nomor Urutan Tampilan
                    </label>
                    <input type="number"
                           name="sort_order"
                           id="aspect_sort_order"
                           value="{{ $aspects->max('sort_order') + 1 }}"
                           class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800">
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-4">
                    <button type="button" @click="showAddModal = false" class="neu-btn px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="neu-primary px-5 py-2 rounded-xl text-white text-xs font-semibold shadow-lg shadow-blue-500/20 transition-all">
                        Simpan Aspek
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Aspek --}}
    <div x-cloak x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" @click="showEditModal = false"></div>
        <div class="relative neu-card rounded-3xl max-w-md w-full p-6 md:p-8 border border-white/80 shadow-2xl">
            <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                <div class="neu-card-sm w-8 h-8 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                </div>
                <span>Edit Aspek Penilaian</span>
            </h3>

            <form method="POST" :action="'/admin/aspects/' + editData.id" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Aspek <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" x-model="editData.name" required class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Urutan Tampilan</label>
                    <input type="number" name="sort_order" x-model="editData.sort_order" class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800">
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" :checked="editData.is_active" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span>Aktifkan aspek ini untuk penilaian baru</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-4">
                    <button type="button" @click="showEditModal = false" class="neu-btn px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="neu-primary px-5 py-2 rounded-xl text-white text-xs font-semibold shadow-lg shadow-blue-500/20 transition-all">
                        Perbarui Aspek
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
