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
    class="space-y-6">

    {{-- Radio Button Pemilihan Tipe Peserta --}}
    <div class="neu-card p-6 rounded-3xl">
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">
            Pilih Tipe Peserta <span class="text-rose-500">*</span>
        </label>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Option 1: Siswa Prakerin --}}
            <label class="relative flex items-center p-4 rounded-2xl cursor-pointer transition-all"
                   :class="type === 'prakerin' ? 'neu-inset-sm border border-blue-500/30 bg-blue-50/20' : 'neu-card-sm hover:bg-[#e4e9f2]'">
                <input type="radio"
                       name="type"
                       value="prakerin"
                       x-model="type"
                       class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                <div class="ml-3.5">
                    <span class="block text-sm font-bold text-slate-900">Siswa Prakerin (SMK)</span>
                    <span class="block text-xs text-slate-500 mt-0.5">Praktik Kerja Industri untuk tingkat Sekolah Menengah Kejuruan</span>
                </div>
            </label>

            {{-- Option 2: Mahasiswa Magang --}}
            <label class="relative flex items-center p-4 rounded-2xl cursor-pointer transition-all"
                   :class="type === 'magang' ? 'neu-inset-sm border border-blue-500/30 bg-blue-50/20' : 'neu-card-sm hover:bg-[#e4e9f2]'">
                <input type="radio"
                       name="type"
                       value="magang"
                       x-model="type"
                       class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                <div class="ml-3.5">
                    <span class="block text-sm font-bold text-slate-900">Mahasiswa Magang (PT / Universitas)</span>
                    <span class="block text-xs text-slate-500 mt-0.5">Program Magang Mahasiswa perguruan tinggi / vokasi / politeknik</span>
                </div>
            </label>
        </div>
        @error('type')
            <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Form Grid Data Pribadi & Akademik --}}
    <div class="neu-card p-6 md:p-8 rounded-3xl space-y-6">
        <div class="flex items-center gap-2.5 border-b border-slate-200/70 pb-4">
            <div class="neu-card-sm w-9 h-9 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                <i data-lucide="user" class="w-4 h-4"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-900">Identitas dan Data Akademik</h4>
                <p class="text-xs text-slate-500">Biodata peserta dan asal lembaga pendidikan</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Nama Lengkap --}}
            <div class="md:col-span-2">
                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $student->name ?? '') }}"
                       required
                       placeholder="Masukkan nama lengkap siswa atau mahasiswa"
                       class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400">
                @error('name')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nomor Identitas --}}
            <div>
                <label for="identity_number" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    <span x-text="type === 'magang' ? 'NIM (Nomor Induk Mahasiswa)' : 'NIS / NISN (Nomor Induk Siswa)'"></span>
                    <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="identity_number"
                       id="identity_number"
                       value="{{ old('identity_number', $student->identity_number ?? '') }}"
                       required
                       placeholder="Contoh: 2108101009 atau 00987654"
                       class="neu-input w-full px-4 py-2.5 rounded-xl text-sm font-mono text-slate-800 placeholder-slate-400">
                @error('identity_number')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Asal Institusi --}}
            <div>
                <label for="institution" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    <span x-text="type === 'magang' ? 'Asal Perguruan Tinggi / Universitas' : 'Asal Sekolah (SMK)'"></span>
                    <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="institution"
                       id="institution"
                       value="{{ old('institution', $student->institution ?? '') }}"
                       required
                       :placeholder="type === 'magang' ? 'Contoh: Universitas Gadjah Mada' : 'Contoh: SMKN 1 Pacitan'"
                       class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400">
                @error('institution')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jurusan / Program Studi --}}
            <div>
                <label for="major" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    <span x-text="type === 'magang' ? 'Program Studi' : 'Jurusan Kejuruan'"></span>
                    <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       name="major"
                       id="major"
                       value="{{ old('major', $student->major ?? '') }}"
                       required
                       :placeholder="type === 'magang' ? 'Contoh: Teknik Informatika / Ilmu Komunikasi' : 'Contoh: Rekayasa Perangkat Lunak (RPL)'"
                       class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400">
                @error('major')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kelas (Prakerin) / Fakultas (Magang) --}}
            <div x-show="type === 'prakerin'">
                <label for="class" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Kelas Siswa
                </label>
                <input type="text"
                       name="class"
                       id="class"
                       value="{{ old('class', $student->class ?? '') }}"
                       placeholder="Contoh: XII RPL 1"
                       class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400">
                @error('class')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div x-show="type === 'magang'">
                <label for="faculty" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Fakultas (Opsional)
                </label>
                <input type="text"
                       name="faculty"
                       id="faculty"
                       value="{{ old('faculty', $student->faculty ?? '') }}"
                       placeholder="Contoh: Fakultas Ilmu Komputer"
                       class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400">
                @error('faculty')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Form Grid Penempatan & Durasi --}}
    <div class="neu-card p-6 md:p-8 rounded-3xl space-y-6">
        <div class="flex items-center gap-2.5 border-b border-slate-200/70 pb-4">
            <div class="neu-card-sm w-9 h-9 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                <i data-lucide="building-2" class="w-4 h-4"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-900">Penempatan Bidang & Durasi Magang/PKL</h4>
                <p class="text-xs text-slate-500">Pilih unit kerja dinas serta jadwal penugasan</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            {{-- Bidang Penempatan --}}
            <div>
                <label for="department_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Bidang Penempatan <span class="text-rose-500">*</span>
                </label>
                <select name="department_id"
                        id="department_id"
                        required
                        class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800 bg-[#ebf0f7]">
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
                <label for="start_date" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Tanggal Mulai <span class="text-rose-500">*</span>
                </label>
                <input type="date"
                       name="start_date"
                       id="start_date"
                       value="{{ old('start_date', $student?->start_date ? $student->start_date->format('Y-m-d') : '') }}"
                       required
                       class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800">
                @error('start_date')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Selesai --}}
            <div>
                <label for="end_date" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Tanggal Selesai <span class="text-rose-500">*</span>
                </label>
                <input type="date"
                       name="end_date"
                       id="end_date"
                       value="{{ old('end_date', $student?->end_date ? $student->end_date->format('Y-m-d') : '') }}"
                       required
                       class="neu-input w-full px-4 py-2.5 rounded-xl text-sm text-slate-800">
                @error('end_date')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Form Grid Upload Foto Profil --}}
    <div class="neu-card p-6 md:p-8 rounded-3xl space-y-5">
        <div class="flex items-center gap-2.5 border-b border-slate-200/70 pb-4">
            <div class="neu-card-sm w-9 h-9 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                <i data-lucide="image" class="w-4 h-4"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-900">Foto Profil Peserta</h4>
                <p class="text-xs text-slate-500">Pas foto resmi peserta (opsional)</p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-6">
            {{-- Preview Image --}}
            <div class="shrink-0 text-center">
                <div class="neu-inset w-24 h-24 rounded-2xl overflow-hidden flex items-center justify-center relative">
                    <template x-if="photoPreview">
                        <img :src="photoPreview" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!photoPreview">
                        <div class="text-slate-400 text-center p-2">
                            <i data-lucide="user" class="w-8 h-8 mx-auto mb-1 text-slate-400"></i>
                            <span class="text-[10px] block font-semibold text-slate-500">Belum ada foto</span>
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
                              file:neu-btn file:text-blue-700
                              cursor-pointer">
                <p class="text-[11px] text-slate-500 leading-normal">
                    Format diperbolehkan: JPG, PNG, WEBP. Maksimal ukuran 2 MB.
                </p>
                @error('photo')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Form Action Buttons --}}
    <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('admin.students.index') }}"
           class="neu-btn px-5 py-2.5 rounded-xl text-slate-700 text-xs font-semibold transition-all">
            Batal
        </a>
        <button type="submit"
                class="neu-primary px-6 py-2.5 rounded-xl text-xs font-semibold text-white flex items-center gap-2 cursor-pointer shadow-lg shadow-blue-500/20">
            <i data-lucide="save" class="w-4 h-4"></i>
            <span>{{ $isEdit ? 'Simpan Perubahan' : 'Tambahkan Peserta' }}</span>
        </button>
    </div>
</div>
