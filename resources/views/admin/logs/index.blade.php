@extends('layouts/admin')

@section('title', 'Log Aktivitas Data')
@section('page-title', 'Audit Trail & Log Aktivitas')
@section('page-subtitle', 'Rekam jejak seluruh perubahan data yang dilakukan oleh Administrator dan Operator')

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
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Riwayat Audit Sistem</h3>
                <p class="text-xs text-slate-500">Transparansi dan integritas data operasional instansi</p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.logs.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 pt-3 border-t border-slate-100">
            {{-- Filter Petugas --}}
            <div>
                <select name="admin_id" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-700 bg-white">
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
                <select name="action" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-700 bg-white">
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
                       class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-slate-700 bg-white">
            </div>

            {{-- Reset --}}
            <div>
                @if (request()->hasAny(['admin_id', 'action', 'date']))
                    <a href="{{ route('admin.logs.index') }}"
                       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        <span>Reset Filter</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Log Table --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-4">Waktu</th>
                        <th class="py-3.5 px-4">Petugas / Aktor</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                        <th class="py-3.5 px-4">Keterangan Aktivitas</th>
                        <th class="py-3.5 px-4">IP Address</th>
                        <th class="py-3.5 px-4 text-right">Rincian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-4 font-mono text-slate-600 shrink-0">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">
                                @if ($log->admin)
                                    <div>
                                        <span>{{ $log->admin->name }}</span>
                                        <span class="block text-[10px] text-slate-400 font-normal">
                                            {{ $log->admin->role === 'administrator' ? 'Administrator' : 'Operator' }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">Sistem / Tamu</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @php
                                    $actionStyles = match ($log->action) {
                                        'create' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'update' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'delete' => 'bg-rose-50 text-rose-700 border-rose-200',
                                        'login' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                        'login_failed' => 'bg-rose-100 text-rose-800 border-rose-300 font-bold',
                                        'export' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase border {{ $actionStyles }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-medium max-w-sm truncate">
                                {{ $log->description }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-500 text-[11px]">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                @if (!empty($log->old_values) || !empty($log->new_values))
                                    <button @click="viewDetails({{ json_encode($log) }})"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-[11px] transition-colors cursor-pointer">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        <span>Diff Data</span>
                                    </button>
                                @else
                                    <span class="text-slate-300 text-[11px]">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">Belum ada riwayat aktivitas yang tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($logs->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    {{-- Modal Diff Data Log --}}
    <div x-cloak x-show="detailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="detailModal = false"></div>
        <div class="relative bg-white rounded-2xl max-w-2xl w-full p-6 shadow-2xl border border-slate-200 space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="diff" class="w-4 h-4 text-blue-600"></i>
                    <span>Snapshot Snapshot Data yang Diubah</span>
                </h3>
                <button @click="detailModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <template x-if="selectedLog">
                <div class="space-y-4 text-xs">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                        <p class="font-bold text-slate-800" x-text="selectedLog.description"></p>
                        <p class="text-slate-500 text-[11px] mt-0.5" x-text="'Waktu: ' + selectedLog.created_at + ' | IP: ' + (selectedLog.ip_address || '-')"></p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Data Sebelum --}}
                        <div>
                            <span class="block font-bold text-rose-700 uppercase tracking-wider text-[10px] mb-1.5 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                Data Sebelum (Old Values)
                            </span>
                            <div class="bg-rose-50/50 border border-rose-200 rounded-xl p-3 font-mono text-[11px] overflow-x-auto text-slate-800 max-h-60">
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
                            <span class="block font-bold text-emerald-700 uppercase tracking-wider text-[10px] mb-1.5 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Data Sesudah (New Values)
                            </span>
                            <div class="bg-emerald-50/50 border border-emerald-200 rounded-xl p-3 font-mono text-[11px] overflow-x-auto text-slate-800 max-h-60">
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
