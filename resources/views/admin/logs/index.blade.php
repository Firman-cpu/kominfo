@extends('layouts/admin')

@section('title', 'Log Aktivitas Data')
@section('page-title', 'Audit Trail Dan Log Aktivitas')
@section('page-subtitle', 'Transparansi rekam jejak pengubahan data dan aktivitas operasional pengguna sistem')

@section('content')
<div class="space-y-6" x-data="{
    detailModal: false,
    selectedLog: null,
    viewDetails(log) {
        this.selectedLog = log;
        this.detailModal = true;
    }
}">
    {{-- Filter Toolbar --}}
    <div class="neu-card p-6 rounded-3xl space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Riwayat Audit Sistem</h3>
                <p class="text-xs text-slate-500">Transparansi dan integritas data operasional instansi</p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.logs.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 pt-4 border-t border-slate-200/70">
            {{-- Filter Petugas --}}
            <div>
                <select name="admin_id" onchange="this.form.submit()" class="neu-input w-full px-3.5 py-2.5 rounded-xl text-xs text-slate-700 bg-[#ebf0f7]">
                    <option value="">Semua Petugas (Admin/Operator)</option>
                    @foreach ($admins as $adm)
                        <option value="{{ $adm->id }}" {{ request('admin_id') == $adm->id ? 'selected' : '' }}>
                            {{ $adm->name }} ({{ $adm->role }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Aksi --}}
            <div>
                <select name="action" onchange="this.form.submit()" class="neu-input w-full px-3.5 py-2.5 rounded-xl text-xs text-slate-700 bg-[#ebf0f7]">
                    <option value="">Semua Jenis Aksi</option>
                    <option value="login" {{ request('action') === 'login' ? 'selected' : '' }}>Login Berhasil</option>
                    <option value="login_failed" {{ request('action') === 'login_failed' ? 'selected' : '' }}>Login Gagal</option>
                    <option value="logout" {{ request('action') === 'logout' ? 'selected' : '' }}>Logout</option>
                    <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>Tambah Data (Create)</option>
                    <option value="update" {{ request('action') === 'update' ? 'selected' : '' }}>Ubah Data (Update)</option>
                    <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>Hapus Data (Delete)</option>
                    <option value="export" {{ request('action') === 'export' ? 'selected' : '' }}>Ekspor Excel</option>
                </select>
            </div>

            {{-- Filter Tanggal --}}
            <div>
                <input type="date"
                       name="date"
                       value="{{ request('date') }}"
                       onchange="this.form.submit()"
                       class="neu-input w-full px-3.5 py-2.5 rounded-xl text-xs text-slate-700 bg-[#ebf0f7]">
            </div>

            {{-- Reset --}}
            <div class="flex items-center">
                @if (request()->hasAny(['admin_id', 'action', 'date']))
                    <a href="{{ route('admin.logs.index') }}"
                       class="neu-btn inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-slate-700 text-xs font-semibold transition-all">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        <span>Reset Filter</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Log Table --}}
    <div class="neu-card rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-[#ebf0f7] border-b border-slate-300/60 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                        <th class="py-4 px-5">Waktu</th>
                        <th class="py-4 px-5">Petugas / Aktor</th>
                        <th class="py-4 px-5 text-center">Aksi</th>
                        <th class="py-4 px-5">Keterangan Aktivitas</th>
                        <th class="py-4 px-5">IP Address</th>
                        <th class="py-4 px-5 text-right">Rincian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-white/40 transition-colors">
                            <td class="py-4 px-5 font-mono text-slate-600 shrink-0">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="py-4 px-5 font-bold text-slate-800">
                                @if ($log->admin)
                                    <div>
                                        <span>{{ $log->admin->name }}</span>
                                        <span class="block text-[10px] text-slate-500 font-normal">
                                            {{ $log->admin->role === 'administrator' ? 'Administrator' : 'Operator' }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">Sistem / Tamu</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-center">
                                @php
                                    $actionStyles = match ($log->action) {
                                        'create' => 'text-emerald-700 border-emerald-200/60',
                                        'update' => 'text-blue-700 border-blue-200/60',
                                        'delete' => 'text-rose-700 border-rose-200/60',
                                        'login' => 'text-indigo-700 border-indigo-200/60',
                                        'login_failed' => 'text-rose-800 border-rose-300 bg-rose-50/50',
                                        'export' => 'text-amber-700 border-amber-200/60',
                                        default => 'text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="neu-card-sm inline-flex px-3 py-1 rounded-xl text-[10px] font-bold uppercase border {{ $actionStyles }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="py-4 px-5 text-slate-700 font-medium max-w-sm truncate">
                                {{ $log->description }}
                            </td>
                            <td class="py-4 px-5 font-mono text-slate-500 text-[11px]">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                            <td class="py-4 px-5 text-right">
                                @if (!empty($log->old_values) || !empty($log->new_values))
                                    <button @click="viewDetails({{ json_encode($log) }})"
                                            class="neu-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-slate-700 font-semibold text-[11px] transition-all cursor-pointer">
                                        <i data-lucide="eye" class="w-3.5 h-3.5 text-blue-600"></i>
                                        <span>Diff Data</span>
                                    </button>
                                @else
                                    <span class="text-slate-400 text-[11px]">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="max-w-xs mx-auto">
                                    <i data-lucide="clipboard-list" class="w-8 h-8 text-slate-400 mx-auto mb-2"></i>
                                    <p class="font-bold text-slate-700">Belum ada riwayat aktivitas yang tercatat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($logs->hasPages())
            <div class="p-4 border-t border-slate-200/80 bg-[#ebf0f7]/60">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    {{-- Modal Diff Data Log --}}
    <div x-cloak x-show="detailModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" @click="detailModal = false"></div>
        <div class="relative neu-card rounded-3xl max-w-2xl w-full p-6 md:p-8 border border-white/80 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-200/70 pb-3">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <div class="neu-card-sm w-8 h-8 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                        <i data-lucide="diff" class="w-4 h-4"></i>
                    </div>
                    <span>Snapshot Data yang Diubah</span>
                </h3>
                <button @click="detailModal = false" class="neu-btn p-1.5 rounded-xl text-slate-500 hover:text-slate-800 transition-all">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <template x-if="selectedLog">
                <div class="space-y-4 text-xs">
                    <div class="neu-card-sm p-4 rounded-2xl border border-white/80 space-y-1">
                        <p class="font-bold text-slate-800" x-text="selectedLog.description"></p>
                        <p class="text-slate-500 text-[11px] font-mono" x-text="'Waktu: ' + selectedLog.created_at + ' | IP: ' + (selectedLog.ip_address || '-')"></p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Data Sebelum --}}
                        <div>
                            <span class="block font-bold text-rose-700 uppercase tracking-wider text-[10px] mb-2 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                Data Sebelum (Old Values)
                            </span>
                            <div class="neu-inset rounded-2xl p-4 font-mono text-[11px] overflow-x-auto text-slate-800 max-h-60">
                                <template x-if="selectedLog.old_values">
                                    <pre class="whitespace-pre-wrap" x-text="JSON.stringify(selectedLog.old_values, null, 2)"></pre>
                                </template>
                                <template x-if="!selectedLog.old_values">
                                    <span class="text-slate-400 italic">Tidak ada (data baru)</span>
                                </template>
                            </div>
                        </div>

                        {{-- Data Sesudah --}}
                        <div>
                            <span class="block font-bold text-emerald-700 uppercase tracking-wider text-[10px] mb-2 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Data Sesudah (New Values)
                            </span>
                            <div class="neu-inset rounded-2xl p-4 font-mono text-[11px] overflow-x-auto text-slate-800 max-h-60">
                                <template x-if="selectedLog.new_values">
                                    <pre class="whitespace-pre-wrap" x-text="JSON.stringify(selectedLog.new_values, null, 2)"></pre>
                                </template>
                                <template x-if="!selectedLog.new_values">
                                    <span class="text-slate-400 italic">Tidak ada (data dihapus)</span>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection
