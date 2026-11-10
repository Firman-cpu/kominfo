@extends('layouts/admin')

@section('title', 'Profile Akun Saya')
@section('page-title', 'Profile Dan Keamanan Akun')
@section('page-subtitle', 'Pengaturan informasi pengguna, foto identitas, dan kredensial keamanan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Profile Header Card --}}
    <div class="neu-card p-6 md:p-8 rounded-3xl flex flex-col sm:flex-row sm:items-center justify-between gap-5">
        <div class="flex items-center gap-5">
            <div class="neu-card-sm w-20 h-20 rounded-2xl overflow-hidden p-1 shrink-0">
                <img id="current-photo-display"
                     src="{{ $admin->photo_url }}"
                     alt="Foto {{ $admin->name }}"
                     class="w-full h-full rounded-xl object-cover"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=3b52f6&color=ffffff&bold=true&size=128'">
            </div>
            <div>
                <div class="mb-1">
                    @if ($admin->isAdministrator())
                        <span class="neu-card-sm inline-flex px-2.5 py-0.5 rounded-lg text-[10px] font-bold text-amber-900 border border-amber-200/60">
                            Administrator
                        </span>
                    @else
                        <span class="neu-card-sm inline-flex px-2.5 py-0.5 rounded-lg text-[10px] font-bold text-emerald-900 border border-emerald-200/60">
                            Operator Data
                        </span>
                    @endif
                </div>
                <h3 class="text-xl font-extrabold text-slate-900">{{ $admin->name }}</h3>
                <p class="text-xs text-slate-500 font-mono mt-0.5">{{ $admin->username }}</p>
                <p class="text-[11px] text-slate-400 mt-1">
                    Login Terakhir: {{ $admin->last_login_at ? $admin->last_login_at->format('d M Y, H:i') . ' WIB' : 'Sesi aktif pertama kali' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Update Profile & Password Form --}}
    <form method="POST"
          action="{{ route('admin.profile.update') }}"
          enctype="multipart/form-data"
          class="neu-card p-6 md:p-8 rounded-3xl space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-5">
            <div class="flex items-center gap-2.5 border-b border-slate-200/70 pb-3">
                <div class="neu-card-sm w-8 h-8 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </div>
                <h4 class="text-sm font-bold text-slate-900">Informasi Akun</h4>
            </div>

            {{-- Photo Upload Section --}}
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-2">
                    Foto Profil
                    <span class="text-slate-400 font-normal">(opsional &bull; maks. 2 MB &bull; JPG/PNG/WebP)</span>
                </label>
                <div class="flex items-center gap-5">
                    {{-- Preview Avatar --}}
                    <div id="photo-wrap"
                         class="neu-inset w-20 h-20 rounded-2xl overflow-hidden
                                flex items-center justify-center shrink-0 relative">
                        <img id="photo-preview"
                             src="{{ $admin->photo_url }}"
                             alt="Preview foto profil"
                             class="w-full h-full object-cover"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=3b52f6&color=ffffff&bold=true&size=128'">
                        {{-- Overlay saat hover --}}
                        <label for="photo"
                               class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition-opacity
                                      flex items-center justify-center cursor-pointer rounded-2xl">
                            <i data-lucide="camera" class="w-6 h-6 text-white"></i>
                        </label>
                    </div>

                    {{-- Upload Controls --}}
                    <div class="flex-1 space-y-1.5">
                        <label for="photo"
                               class="cursor-pointer neu-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl
                                      text-blue-700 text-xs font-semibold transition-all">
                            <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                            <span>Pilih Foto Baru</span>
                        </label>
                        <input type="file"
                               name="photo"
                               id="photo"
                               accept="image/jpeg,image/png,image/jpg,image/webp,image/gif"
                               class="sr-only"
                               onchange="previewProfilePhoto(this)">
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Klik foto atau tombol di atas untuk memilih gambar baru.<br>
                            Foto akan diperbarui segera setelah disimpan.
                        </p>
                        @error('photo')
                            <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Name --}}
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $admin->name) }}"
                       required
                       class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800">
                @error('name')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Username --}}
            <div>
                <label for="username" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Username Login <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="username"
                       id="username"
                       value="{{ old('username', $admin->username) }}"
                       required
                       class="neu-input w-full px-4 py-2.5 rounded-xl text-sm font-mono text-slate-800">
                @error('username')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Password Section --}}
        <div class="pt-5 border-t border-slate-200/70 space-y-4">
            <div class="flex items-center gap-2.5 pb-1">
                <div class="neu-card-sm w-8 h-8 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900">Ganti Password</h4>
                    <p class="text-xs text-slate-500">Kosongkan kolom password jika tidak ingin mengubah password saat ini.</p>
                </div>
            </div>

            <div>
                <label for="current_password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Password Saat Ini
                </label>
                <input type="password"
                       name="current_password"
                       id="current_password"
                       placeholder="Masukkan password lama Anda"
                       class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800">
                @error('current_password')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="new_password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Password Baru
                    </label>
                    <input type="password"
                           name="new_password"
                           id="new_password"
                           placeholder="Minimal 8 karakter"
                           class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800">
                    @error('new_password')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="new_password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Konfirmasi Password Baru
                    </label>
                    <input type="password"
                           name="new_password_confirmation"
                           id="new_password_confirmation"
                           placeholder="Ulangi password baru"
                           class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800">
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="pt-4 border-t border-slate-200/70 flex items-center justify-end gap-3">
            <a href="{{ route('admin.profile.index') }}"
               class="neu-btn px-5 py-2.5 rounded-xl text-slate-700 text-xs font-semibold transition-all">
                Batal
            </a>
            <button type="submit"
                    class="neu-primary px-6 py-2.5 rounded-xl text-white text-xs font-semibold shadow-lg shadow-blue-500/20 transition-all flex items-center gap-2 cursor-pointer">
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
