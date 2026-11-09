@extends('layouts/admin')

@section('title', 'Profile Akun Saya')
@section('page-title', 'Profile Dan Keamanan Akun')
@section('page-subtitle', '')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Profile Card --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl overflow-hidden flex items-center justify-center text-white font-extrabold text-xl shrink-0">
                <img id="current-photo-display"
                     src="{{ $admin->photo_url }}"
                     alt="Foto {{ $admin->name }}"
                     class="w-full h-full object-cover"
                     onerror="this.style.display='none'">
            </div>
            <div>
                <div class="items-center">
                    @if ($admin->isAdministrator())
                        <span class="text-[10px] font-bold text-amber-800">
                            Administrator
                        </span>
                    @else
                        <span class="inline-flex text-[10px] font-bold text-emerald-800">
                            Operator Data
                        </span>
                    @endif
                    <h3 class="text-lg font-bold text-slate-900">{{ $admin->name }}</h3>
                </div>
                <p class="text-xs text-slate-500 font-mono">{{ $admin->username }}</p>
                <p class="text-[11px] text-slate-400 mt-0.5">
                    Login Terakhir: {{ $admin->last_login_at ? $admin->last_login_at->format('d M Y, H:i') . ' WIB' : 'Sesi aktif pertama kali' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Update Profile & Password Form --}}
    <form method="POST"
          action="{{ route('admin.profile.update') }}"
          enctype="multipart/form-data"
          class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-5">
            <h4 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                <i data-lucide="user" class="w-4 h-4 text-blue-600"></i>
                <span>Informasi Akun</span>
            </h4>

            {{-- ─── Photo Upload Section ─── --}}
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-3">
                    Foto Profil
                    <span class="text-slate-400 font-normal">(opsional · maks. 2 MB · JPG/PNG/WebP)</span>
                </label>
                <div class="flex items-center gap-5">
                    {{-- Preview Avatar --}}
                    <div id="photo-wrap"
                         class="w-20 h-20 rounded-2xl overflow-hidden
                                flex items-center justify-center text-white font-bold text-2xl shrink-0 relative">
                        <img id="photo-preview"
                             src="{{ $admin->photo_url }}"
                             alt="Preview foto profil"
                             class="w-full h-full object-cover"
                             onerror="this.style.display='none'">
                        {{-- Overlay saat hover --}}
                        <label for="photo"
                               class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition-opacity
                                      flex items-center justify-center cursor-pointer rounded-2xl">
                            <i data-lucide="camera" class="w-6 h-6 text-white"></i>
                        </label>
                    </div>

                    {{-- Upload Controls --}}
                    <div class="flex-1 space-y-2">
                        <label for="photo"
                               class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 rounded-xl
                                      bg-blue-50 hover:bg-blue-100 border border-blue-200 hover:border-blue-300
                                      text-blue-700 text-xs font-semibold transition-colors">
                            <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                            Pilih Foto Baru
                        </label>
                        <input type="file"
                               name="photo"
                               id="photo"
                               accept="image/jpeg,image/png,image/jpg,image/webp,image/gif"
                               class="sr-only"
                               onchange="previewProfilePhoto(this)">
                        <p class="text-[11px] text-slate-400 leading-relaxed">
                            Klik foto atau tombol di atas untuk memilih gambar.<br>
                            Foto baru akan tampil segera setelah disimpan.
                        </p>
                        @error('photo')
                            <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Name --}}
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $admin->name) }}"
                       required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm
                              focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                @error('name')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Username --}}
            <div>
                <label for="username" class="block text-xs font-semibold text-slate-700 mb-1">
                    Username Login <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="username"
                       id="username"
                       value="{{ old('username', $admin->username) }}"
                       required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-mono
                              focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                @error('username')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Password Section --}}
        <div class="pt-5 border-t border-slate-100 space-y-4">
            <div>
                <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="lock" class="w-4 h-4 text-blue-600"></i>
                    <span>Ganti Password</span>
                </h4>
                <p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah password saat ini.</p>
            </div>

            <div>
                <label for="current_password" class="block text-xs font-semibold text-slate-700 mb-1">
                    Password Saat Ini
                </label>
                <input type="password"
                       name="current_password"
                       id="current_password"
                       placeholder="Masukkan password lama Anda"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm
                              focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                @error('current_password')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="new_password" class="block text-xs font-semibold text-slate-700 mb-1">
                        Password Baru
                    </label>
                    <input type="password"
                           name="new_password"
                           id="new_password"
                           placeholder="Minimal 8 karakter"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm
                                  focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                    @error('new_password')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="new_password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">
                        Konfirmasi Password Baru
                    </label>
                    <input type="password"
                           name="new_password_confirmation"
                           id="new_password_confirmation"
                           placeholder="Ulangi password baru"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm
                                  focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.profile.index') }}"
               class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold
                           shadow-xs transition-all flex items-center gap-2 cursor-pointer">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewProfilePhoto(input) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];

    // Validasi ukuran di sisi klien
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran foto maksimal 2 MB. Pilih file yang lebih kecil.');
        input.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        // Update semua preview avatar di halaman ini
        document.querySelectorAll('#photo-preview, #current-photo-display').forEach(img => {
            img.src = e.target.result;
            img.style.display = '';
        });
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
