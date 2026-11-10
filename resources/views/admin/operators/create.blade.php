@extends('layouts/admin')

@section('title', 'Tambah Operator Baru')
@section('page-title', 'Tambah Akun Operator')
@section('page-subtitle', 'Buat akun staf operasional untuk pengelolaan data siswa dan nilai')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <a href="{{ route('admin.operators.index') }}"
       class="neu-btn px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:text-slate-900 inline-flex items-center gap-1.5 transition-all">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>Kembali ke Daftar Operator</span>
    </a>

    <form method="POST" action="{{ route('admin.operators.store') }}" class="neu-card p-6 md:p-8 rounded-3xl space-y-5" enctype="multipart/form-data">
        @csrf

        {{-- Photo Upload --}}
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-2">
                Foto Profil Operator <span class="text-slate-400 font-normal">(opsional, maks. 2MB)</span>
            </label>
            <div class="flex items-center gap-4">
                <div class="neu-inset w-20 h-20 rounded-2xl overflow-hidden flex items-center justify-center shrink-0 relative" id="photo-preview-wrap">
                    <div id="photo-placeholder" class="text-center">
                        <i data-lucide="user" class="w-8 h-8 text-slate-400 mx-auto"></i>
                    </div>
                    <img id="photo-preview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                </div>
                <div class="flex-1 space-y-1.5">
                    <label for="photo" class="cursor-pointer neu-btn inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 transition-all">
                        <i data-lucide="upload" class="w-4 h-4 text-blue-600"></i>
                        <span>Pilih Foto</span>
                    </label>
                    <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/jpg,image/webp" class="sr-only"
                           onchange="previewPhoto(this, 'photo-preview', 'photo-placeholder')">
                    <p class="text-[11px] text-slate-500">JPG, PNG, atau WebP — maks. 2 MB</p>
                </div>
            </div>
            @error('photo')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Nama Lengkap Petugas Operator <span class="text-rose-500">*</span>
            </label>
            <input type="text"
                   name="name"
                   id="name"
                   value="{{ old('name') }}"
                   required
                   placeholder="Contoh: Budi Santoso, S.Kom"
                   class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800">
            @error('name')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="username" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Username Login <span class="text-rose-500">*</span>
            </label>
            <input type="text"
                   name="username"
                   id="username"
                   value="{{ old('username') }}"
                   required
                   placeholder="Contoh: operator_ti atau budi"
                   class="neu-input w-full px-4 py-2.5 rounded-xl text-sm font-mono text-slate-800">
            @error('username')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Password Sementara <span class="text-rose-500">*</span>
            </label>
            <input type="password"
                   name="password"
                   id="password"
                   required
                   placeholder="Minimal 8 karakter"
                   class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800">
            @error('password')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-2">
            <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-700 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <span>Akun langsung aktif dan dapat login</span>
            </label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200/70">
            <a href="{{ route('admin.operators.index') }}"
               class="neu-btn px-5 py-2.5 rounded-xl text-slate-700 text-xs font-semibold transition-all">
                Batal
            </a>
            <button type="submit"
                    class="neu-primary px-6 py-2.5 rounded-xl text-white text-xs font-semibold shadow-lg shadow-blue-500/20 transition-all flex items-center gap-2 cursor-pointer">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Simpan Akun Operator</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewPhoto(input, previewId, placeholderId) {
    const preview = document.getElementById(previewId);
    const placeholder = document.getElementById(placeholderId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection
