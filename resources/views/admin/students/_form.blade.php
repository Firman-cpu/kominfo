@props(['student' => null, 'departments' => []])

@php
    $isEdit = !is_null($student);
    $initialType = old('type', $student->type ?? 'prakerin');
@endphp

<div x-data="{
        type: '{{ $initialType }}',
        photoPreview: '{{ $student?->photo_path ? $student->photo_url : '' }}',
        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file foto maksimal adalah 2 MB.');
                    event.target.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = (e) => { this.photoPreview = e.target.result; };
                reader.readAsDataURL(file);
            }
        }
    }"
    class="space-y-8">

    {{-- Radio Button Pemilihan Tipe Peserta di Bagian Atas --}}
    <div class="p-5 rounded-2xl bg-white">
        <label class="block text-xs font-bold text-blue-900 uppercase tracking-wider mb-3">
            Pilih Tipe Peserta:
        </label>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Option 1: Siswa Prakerin --}}
            <label class="relative flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all bg-white"
                   :class="type === 'prakerin' ? 'border-blue-600 ring-2 ring-blue-500/20 shadow-xs' : 'border-slate-200 hover:border-slate-300'">
                <input type="radio"
                       name="type"
                       value="prakerin"
                       x-model="type"
                       class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                <div class="ml-3">
                    <span class="block text-sm font-bold text-slate-900">Siswa Prakerin (SMK)</span>
                    <span class="block text-xs text-slate-500">Praktik Kerja Industri untuk tingkat Sekolah Menengah Kejuruan</span>
                </div>
            </label>

            {{-- Option 2: Mahasiswa Magang --}}
            <label class="relative flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all bg-white"
                   :class="type === 'magang' ? 'border-blue-600 ring-2 ring-blue-500/20 shadow-xs' : 'border-slate-200 hover:border-slate-300'">
                <input type="radio"
                       name="type"
                       value="magang"
                       x-model="type"
                       class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                <div class="ml-3">
                    <span class="block text-sm font-bold text-slate-900">Mahasiswa Magang (PT / Universitas)</span>
                    <span class="block text-xs text-slate-500">Program Magang Mahasiswa perguruan tinggi / vokasi / politeknik</span>
                </div>
            </label>
        </div>
        @error('type')
            <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Form Grid Data Pribadi & Akademik --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        <h4 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
            <i data-lucide="user" class="w-4 h-4 text-blue-600"></i>
            <span>Identitas dan Data Akademik</span>
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Nama Lengkap --}}
            <div class="md:col-span-2">
                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $student->name ?? '') }}"
                       required
                       placeholder="Masukkan nama lengkap siswa atau mahasiswa"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 placeholder-slate-400">
                @error('name')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nomor Identitas (NIS untuk Prakerin, NIM untuk Magang) --}}
            <div>
                <label for="identity_number" class="block text-xs font-semibold text-slate-700 mb-1">
                    <span x-text="type === 'magang' ? 'NIM (Nomor Induk Mahasiswa)' : 'NIS / NISN (Nomor Induk Siswa)'"></span>
                    <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="identity_number"
                       id="identity_number"
                       value="{{ old('identity_number', $student->identity_number ?? '') }}"
                       required
                       placeholder="Contoh: 2108101009 atau 00987654"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 placeholder-slate-400">
                @error('identity_number')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Asal Institusi (Sekolah untuk Prakerin, Kampus untuk Magang) --}}
            <div>
                <label for="institution" class="block text-xs font-semibold text-slate-700 mb-1">
                    <span x-text="type === 'magang' ? 'Asal Perguruan Tinggi / Universitas' : 'Asal Sekolah (SMK)'"></span>
                    <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="institution"
                       id="institution"
                       value="{{ old('institution', $student->institution ?? '') }}"
                       required
                       :placeholder="type === 'magang' ? 'Contoh: Universitas Gadjah Mada' : 'Contoh: SMKN 1 Pacitan'"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 placeholder-slate-400">
                @error('institution')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jurusan / Program Studi --}}
            <div>
                <label for="major" class="block text-xs font-semibold text-slate-700 mb-1">
                    <span x-text="type === 'magang' ? 'Program Studi' : 'Jurusan Kejuruan'"></span>
                    <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="major"
                       id="major"
                       value="{{ old('major', $student->major ?? '') }}"
                       required
                       :placeholder="type === 'magang' ? 'Contoh: Teknik Informatika / Ilmu Komunikasi' : 'Contoh: Rekayasa Perangkat Lunak (RPL)'"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 placeholder-slate-400">
                @error('major')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kelas (khusus Prakerin) / Fakultas (khusus Magang) --}}
            <div x-show="type === 'prakerin'">
                <label for="class" class="block text-xs font-semibold text-slate-700 mb-1">
                    Kelas Siswa
                </label>
                <input type="text"
                       name="class"
                       id="class"
                       value="{{ old('class', $student->class ?? '') }}"
                       placeholder="Contoh: XII RPL 1"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 placeholder-slate-400">
                @error('class')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div x-show="type === 'magang'">
                <label for="faculty" class="block text-xs font-semibold text-slate-700 mb-1">
                    Fakultas (Opsional)
                </label>
                <input type="text"
                       name="faculty"
                       id="faculty"
                       value="{{ old('faculty', $student->faculty ?? '') }}"
                       placeholder="Contoh: Fakultas Ilmu Komputer"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 placeholder-slate-400">
                @error('faculty')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Form Grid Penempatan & Durasi --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-6">
        <h4 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
            <i data-lucide="building-2" class="w-4 h-4 text-blue-600"></i>
            <span>Penempatan Bidang & Durasi Magang/PKL</span>
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            {{-- Bidang Penempatan (4 Bidang Resmi Kominfo) --}}
            <div>
                <label for="department_id" class="block text-xs font-semibold text-slate-700 mb-1">
                    Bidang Penempatan <span class="text-rose-500">*</span>
                </label>
                <select name="department_id"
                        id="department_id"
                        required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800 bg-white">
                    <option value="">-- Pilih Bidang --</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}"
                                {{ old('department_id', $student->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Mulai --}}
            <div>
                <label for="start_date" class="block text-xs font-semibold text-slate-700 mb-1">
                    Tanggal Mulai <span class="text-rose-500">*</span>
                </label>
                <input type="date"
                       name="start_date"
                       id="start_date"
                       value="{{ old('start_date', $student?->start_date ? $student->start_date->format('Y-m-d') : '') }}"
                       required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                @error('start_date')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Selesai --}}
            <div>
                <label for="end_date" class="block text-xs font-semibold text-slate-700 mb-1">
                    Tanggal Selesai <span class="text-rose-500">*</span>
                </label>
                <input type="date"
                       name="end_date"
                       id="end_date"
                       value="{{ old('end_date', $student?->end_date ? $student->end_date->format('Y-m-d') : '') }}"
                       required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-800">
                @error('end_date')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Form Grid Upload Foto Profil --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        <h4 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
            <i data-lucide="image" class="w-4 h-4 text-blue-600"></i>
            <span>Foto Profil Peserta</span>
        </h4>

        <div class="flex flex-col sm:flex-row items-center gap-6">
            {{-- Preview Image --}}
            <div class="shrink-0 text-center">
                <div class="w-24 h-24 rounded-2xl border-2 border-dashed border-slate-300 overflow-hidden bg-slate-100 flex items-center justify-center relative shadow-xs">
                    <template x-if="photoPreview">
                        <img :src="photoPreview" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!photoPreview">
                        <div class="text-slate-400 text-center p-2">
                            <i data-lucide="user" class="w-8 h-8 mx-auto mb-1"></i>
                            <span class="text-[10px] block font-medium">Belum ada foto</span>
                        </div>
                    </template>
                </div>
            </div>

            {{-- File Input --}}
            <div class="flex-1 space-y-2">
                <input type="file"
                       name="photo"
                       id="photo"
                       accept="image/jpeg,image/png,image/jpg,image/webp"
                       @change="previewImage"
                       class="block w-full text-xs text-slate-500
                              file:mr-4 file:py-2.5 file:px-4
                              file:rounded-xl file:border-0
                              file:text-xs file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100 cursor-pointer">
                <p class="text-[11px] text-slate-400 leading-normal">
                    Format diperbolehkan: JPG, PNG, WEBP. Maksimal ukuran 2 MB.
                </p>
                @error('photo')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Form Action Buttons --}}
    <div class="flex items-center justify-end gap-3 pt-4">
        <a href="{{ route('admin.students.index') }}"
           class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-100 text-xs font-semibold transition-colors">
            Batal
        </a>
        <button type="submit"
                class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs shadow-blue-500/20 transition-all flex items-center gap-2 cursor-pointer">
            <i data-lucide="save" class="w-4 h-4"></i>
            <span>{{ $isEdit ? 'Simpan Perubahan' : 'Tambahkan Peserta' }}</span>
        </button>
    </div>
</div>
