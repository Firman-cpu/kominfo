@extends('layouts/admin')

@section('title', 'Manajemen Akun Operator')
@section('page-title', 'Manajemen Akun Operator')
@section('page-subtitle', 'Kelola akun staf operator yang bertugas mengelola data siswa & nilai')

@section('content')
<div class="space-y-6">
    {{-- Administrator Account Policy Information Card --}}
    <div class="bg-amber-50/70 border border-amber-200 p-5 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                <i data-lucide="shield-alert" class="w-5 h-5"></i>
            </div>
            <div>
                <h4 class="text-xs font-bold text-amber-900 uppercase tracking-wider">Struktur Kasta & Kebijakan Akun Administrator</h4>
                <p class="text-xs text-amber-800 mt-0.5 leading-relaxed">
                    Sistem dibatasi secara ketat memiliki <strong>maksimal tepat 2 akun Administrator</strong> (Akun Utama + Akun Cadangan). Akun Administrator cadangan dibuat melalui CLI Artisan (<code class="bg-amber-100/80 px-1 py-0.5 rounded text-[11px] font-mono">php artisan admin:create-administrator</code>) demi mencegah eskalasi hak akses lewat antarmuka web.
                </p>
                <p class="text-[11px] text-amber-700 font-semibold mt-1">
                    Status saat ini: Terdaftar {{ $adminCount }} dari maksimal 2 akun Administrator.
                </p>
            </div>
        </div>
        <a href="{{ route('admin.operators.create') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs shrink-0 transition-colors">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Tambah Operator Baru</span>
        </a>
    </div>

    {{-- Operators Table --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-900">Daftar Akun Operator Aktif</h3>
            <p class="text-xs text-slate-500">Operator hanya memiliki hak akses CRUD data siswa dan input penilaian</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-4">Nama Operator</th>
                        <th class="py-3.5 px-4">Username</th>
                        <th class="py-3.5 px-4">Peran (Role)</th>
                        <th class="py-3.5 px-4">Login Terakhir</th>
                        <th class="py-3.5 px-4 text-center">Status Akun</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($operators as $op)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full overflow-hidden shrink-0 bg-slate-100">
                                        <img src="{{ $op->photo_url }}" alt="{{ $op->name }}"
                                             class="w-full h-full object-cover"
                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($op->name) }}&background=1e3a8a&color=ffffff&bold=true&size=64'">
                                    </div>
                                    <span>{{ $op->name }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-600">
                                {{ $op->username }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Operator Data
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">
                                {{ $op->last_login_at ? $op->last_login_at->diffForHumans() : 'Belum pernah login' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if ($op->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Dinonaktifkan
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('admin.operators.edit', $op->id) }}"
                                       class="p-1.5 rounded-lg text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                       title="Edit / Reset Password">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.operators.destroy', $op->id) }}"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun operator {{ $op->name }}?')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 rounded-lg text-slate-600 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer"
                                                title="Hapus Akun">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">
                                <i data-lucide="user-x" class="w-8 h-8 mx-auto text-slate-300 mb-2"></i>
                                <p class="font-medium text-slate-600">Belum ada akun operator yang dibuat.</p>
                                <p class="text-xs text-slate-400 mt-0.5">Gunakan tombol "Tambah Operator Baru" untuk menambahkan staf data.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($operators->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $operators->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
