@extends('layouts/admin')

@section('title', 'Manajemen Akun Operator')
@section('page-title', 'Manajemen Akun Operator')
@section('page-subtitle', 'Kelola staf data operasional instansi yang memiliki akses sistem')

@section('content')
<div class="space-y-6">
    {{-- Operators Card & Table --}}
    <div class="neu-card rounded-3xl overflow-hidden">
        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/70">
            <div>
                <h3 class="text-base font-bold text-slate-900">Daftar Akun Operator Aktif</h3>
                <p class="text-xs text-slate-500">Operator memiliki hak akses CRUD data siswa dan input penilaian</p>
            </div>
            <div>
                <a href="{{ route('admin.operators.create') }}"
                   class="neu-primary px-4 py-2.5 rounded-xl text-white text-xs font-semibold shadow-lg shadow-blue-500/20 inline-flex items-center gap-1.5 transition-all shrink-0">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span>Tambah Operator Baru</span>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-[#ebf0f7] border-b border-slate-300/60 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                        <th class="py-4 px-5">Nama Operator</th>
                        <th class="py-4 px-5">Username</th>
                        <th class="py-4 px-5">Peran (Role)</th>
                        <th class="py-4 px-5">Login Terakhir</th>
                        <th class="py-4 px-5 text-center">Status Akun</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60">
                    @forelse ($operators as $op)
                        <tr class="hover:bg-white/40 transition-colors">
                            <td class="py-4 px-5 font-bold text-slate-900">
                                <div class="flex items-center gap-3">
                                    <div class="neu-card-sm w-9 h-9 rounded-full overflow-hidden shrink-0 p-0.5">
                                        <img src="{{ $op->photo_url }}" alt="{{ $op->name }}"
                                             class="w-full h-full rounded-full object-cover"
                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($op->name) }}&background=3b52f6&color=ffffff&bold=true&size=64'">
                                    </div>
                                    <span>{{ $op->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-5 font-mono text-slate-600">
                                {{ $op->username }}
                            </td>
                            <td class="py-4 px-5">
                                <span class="neu-card-sm inline-flex px-2.5 py-1 rounded-xl text-[10px] font-bold text-emerald-800 border border-emerald-200/60">
                                    Operator Data
                                </span>
                            </td>
                            <td class="py-4 px-5 text-slate-500">
                                {{ $op->last_login_at ? $op->last_login_at->diffForHumans() : 'Belum pernah login' }}
                            </td>
                            <td class="py-4 px-5 text-center">
                                @if ($op->is_active)
                                    <span class="neu-card-sm inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-[11px] font-bold text-emerald-700 border border-emerald-200/50">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="neu-card-sm inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-[11px] font-bold text-rose-700 border border-rose-200/50">
                                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                        Dinonaktifkan
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.operators.edit', $op->id) }}"
                                       class="neu-btn p-2 rounded-xl text-slate-600 hover:text-blue-600 transition-all"
                                       title="Edit / Reset Password">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.operators.destroy', $op->id) }}"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun operator {{ $op->name }}?')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="neu-btn p-2 rounded-xl text-slate-600 hover:text-rose-600 transition-all cursor-pointer"
                                                title="Hapus Akun">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="max-w-xs mx-auto">
                                    <i data-lucide="user-x" class="w-8 h-8 mx-auto text-slate-400 mb-2"></i>
                                    <p class="font-bold text-slate-700">Belum ada akun operator yang dibuat.</p>
                                    <p class="text-xs text-slate-500 mt-1">Gunakan tombol "Tambah Operator Baru" untuk menambahkan staf data.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($operators->hasPages())
            <div class="p-4 border-t border-slate-200/80 bg-[#ebf0f7]/60">
                {{ $operators->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
