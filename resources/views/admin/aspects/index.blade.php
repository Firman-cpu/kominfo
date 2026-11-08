@extends('layouts/admin')

@section('title', 'Kelola Aspek Penilaian')
@section('page-title', 'Aspek Penilaian Kinerja')
@section('page-subtitle', 'Kustomisasi aspek nilai dinamis yang digunakan oleh pembimbing')

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
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-base font-bold text-slate-900">Daftar Aspek Penilaian Aktif</h3>
            <p class="text-xs text-slate-500">Aspek yang dinonaktifkan tidak akan muncul pada pengisian penilaian baru.</p>
        </div>
        <button @click="showAddModal = true"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition-colors cursor-pointer">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Tambah Aspek Baru</span>
        </button>
    </div>

    {{-- Aspects Table --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-4 w-16 text-center">Urutan</th>
                        <th class="py-3.5 px-4">Nama Aspek Penilaian</th>
                        <th class="py-3.5 px-4">Identifier Key</th>
                        <th class="py-3.5 px-4 text-center">Digunakan di Penilaian</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($aspects as $aspect)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-4 text-center font-bold text-slate-700">
                                {{ $aspect->sort_order }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $aspect->name }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 font-mono text-[11px]">
                                {{ $aspect->key }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">
                                    {{ $aspect->scores_count }} penilaian
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if ($aspect->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <button @click="openEdit({{ json_encode($aspect) }})"
                                            class="p-1.5 rounded-lg text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-colors cursor-pointer"
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
                                                    class="p-1.5 rounded-lg text-slate-600 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer"
                                                    title="Hapus Aspek">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="p-1.5 text-slate-300 cursor-not-allowed" title="Aspek ini sudah memiliki rekaman nilai, tidak dapat dihapus">
                                            <i data-lucide="lock" class="w-4 h-4"></i>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada aspek penilaian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Aspek --}}
    <div x-cloak x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="showAddModal = false"></div>
        <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200">
            <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-5 h-5 text-blue-600"></i>
                <span>Tambah Aspek Penilaian</span>
            </h3>

            <form method="POST" action="{{ route('admin.aspects.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="aspect_name" class="block text-xs font-semibold text-slate-700 mb-1">
                        Nama Aspek <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           id="aspect_name"
                           required
                           placeholder="Contoh: Pemecahan Masalah (Problem Solving)"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                </div>

                <div>
                    <label for="aspect_sort_order" class="block text-xs font-semibold text-slate-700 mb-1">
                        Nomor Urutan Tampilan
                    </label>
                    <input type="number"
                           name="sort_order"
                           id="aspect_sort_order"
                           value="{{ $aspects->max('sort_order') + 1 }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                </div>

                <div class="flex items-center justify-end gap-2 pt-4">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-100">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs">
                        Simpan Aspek
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Aspek --}}
    <div x-cloak x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="showEditModal = false"></div>
        <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200">
            <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                <i data-lucide="edit-3" class="w-5 h-5 text-blue-600"></i>
                <span>Edit Aspek Penilaian</span>
            </h3>

            <form method="POST" :action="'/admin/aspects/' + editData.id" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Aspek <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" x-model="editData.name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Urutan Tampilan</label>
                    <input type="number" name="sort_order" x-model="editData.sort_order" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" :checked="editData.is_active" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span>Aktifkan aspek ini untuk penilaian baru</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-2 pt-4">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-100">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs">
                        Perbarui Aspek
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
