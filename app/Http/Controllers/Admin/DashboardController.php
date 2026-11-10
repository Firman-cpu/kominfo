<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\AnalyticsService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(AnalyticsService $analyticsService)
    {
        // Sinkronisasi status otomatis bila ada yang sudah lewat tanggal selesai
        Student::where('status', 'active')
            ->whereNotNull('end_date')
            ->whereDate('end_date', '<', Carbon::today())
            ->update(['status' => 'completed']);

        $stats = $analyticsService->getDashboardStats();

        return view('admin.dashboard.page', $stats);
    }

    /**
     * Pencarian cepat data peserta, asal sekolah, dan fitur dashboard.
     */
    public function quickSearch(Request $request): JsonResponse
    {
        $q = trim((string) $request->input('q', ''));
        $user = Auth::guard('admin')->user();
        $isAdministrator = $user && method_exists($user, 'isAdministrator') && $user->isAdministrator();

        $allFeatures = [
            [
                'title' => 'Dashboard Utama',
                'category' => 'Menu Utama',
                'description' => 'Ringkasan statistik metrik, kapasitas bidang, dan aktivitas',
                'icon' => 'layout-dashboard',
                'svg' => $this->getIconSvg('layout-dashboard'),
                'url' => route('admin.dashboard.page'),
                'keywords' => 'dashboard beranda home statistik ringkasan grafik bento',
            ],
            [
                'title' => 'Daftar Siswa & Mahasiswa',
                'category' => 'Data Peserta',
                'description' => 'Lihat dan kelola seluruh peserta PKL SMK & mahasiswa magang',
                'icon' => 'users',
                'svg' => $this->getIconSvg('users'),
                'url' => route('admin.students.index'),
                'keywords' => 'siswa mahasiswa peserta data daftar pkl magang smk sekolah kampus instansi',
            ],
            [
                'title' => 'Tambah Peserta Baru',
                'category' => 'Data Peserta',
                'description' => 'Formulir pendaftaran peserta magang atau PKL baru ke dinas',
                'icon' => 'user-plus',
                'svg' => $this->getIconSvg('user-plus'),
                'url' => route('admin.students.create'),
                'keywords' => 'tambah buat daftar baru peserta siswa mahasiswa input registrasi formulir',
            ],
            [
                'title' => 'Daftar Penilaian Peserta',
                'category' => 'Penilaian & Evaluasi',
                'description' => 'Rekapitulasi nilai akhir, skor rata-rata, dan kategori performa',
                'icon' => 'award',
                'svg' => $this->getIconSvg('award'),
                'url' => route('admin.assessments.index'),
                'keywords' => 'nilai penilaian evaluasi skor transkrip performa capaian predikat kelulusan',
            ],
            [
                'title' => 'Input Penilaian Baru',
                'category' => 'Penilaian & Evaluasi',
                'description' => 'Beri penilaian kinerja dan evaluasi kompetensi peserta',
                'icon' => 'plus-circle',
                'svg' => $this->getIconSvg('plus-circle'),
                'url' => route('admin.assessments.create'),
                'keywords' => 'input nilai beri nilai tambah nilai baru skoring evaluasi skor',
            ],
            [
                'title' => 'Aspek Penilaian Kinerja',
                'category' => 'Konfigurasi Penilaian',
                'description' => 'Kelola indikator, kriteria kompetensi, dan parameter penilaian dinamis',
                'icon' => 'sliders',
                'svg' => $this->getIconSvg('sliders'),
                'url' => route('admin.aspects.index'),
                'keywords' => 'aspek kriteria parameter bobot indikator penilaian kompetensi',
            ],
            [
                'title' => 'Batas Kategori Nilai & Performa',
                'category' => 'Konfigurasi Penilaian',
                'description' => 'Atur rentang nilai minimum untuk predikat Sangat Baik, Baik, dll',
                'icon' => 'badge-percent',
                'svg' => $this->getIconSvg('badge-percent'),
                'url' => route('admin.categories.index'),
                'keywords' => 'kategori batas predikat grade huruf nilai minimal ambang skor',
            ],
            [
                'title' => 'Analitik & Distribusi Bidang',
                'category' => 'Statistik & Laporan',
                'description' => 'Grafik sebaran peserta pada unit kerja Diskominfo Pacitan',
                'icon' => 'bar-chart-3',
                'svg' => $this->getIconSvg('bar-chart-3'),
                'url' => route('admin.analytics.index'),
                'keywords' => 'analitik statistik grafik distribusi bidang kuota persentase unit kerja ti infokom sekretariat',
            ],
            [
                'title' => 'Ekspor Data ke Excel (.xlsx)',
                'category' => 'Statistik & Laporan',
                'description' => 'Unduh laporan lengkap data siswa & lembar nilai ke spreadsheet',
                'icon' => 'file-spreadsheet',
                'svg' => $this->getIconSvg('file-spreadsheet'),
                'url' => route('admin.export.index'),
                'keywords' => 'ekspor download unduh excel xlsx spreadsheet rekap cetak file',
            ],
            [
                'title' => 'Profil & Keamanan Akun',
                'category' => 'Akun Pengguna',
                'description' => 'Ganti foto profil, perbarui nama, dan ubah kata sandi login',
                'icon' => 'user',
                'svg' => $this->getIconSvg('user'),
                'url' => route('admin.profile.index'),
                'keywords' => 'profil akun saya foto password ganti sandi keamanan biodata',
            ],
        ];

        if ($isAdministrator) {
            $allFeatures[] = [
                'title' => 'Manajemen Akun Operator',
                'category' => 'Administrator',
                'description' => 'Kelola akun staf operator yang memiliki akses ke sistem',
                'icon' => 'user-check',
                'svg' => $this->getIconSvg('user-check'),
                'url' => route('admin.operators.index'),
                'keywords' => 'operator staf user akun manajemen admin hak akses pengguna',
            ];
            $allFeatures[] = [
                'title' => 'Tambah Operator Baru',
                'category' => 'Administrator',
                'description' => 'Buat akun login baru untuk staf operasional dinas',
                'icon' => 'user-plus',
                'svg' => $this->getIconSvg('user-plus'),
                'url' => route('admin.operators.create'),
                'keywords' => 'tambah operator buat user baru akun operasional admin',
            ];
            $allFeatures[] = [
                'title' => 'Audit Log & Riwayat Aktivitas',
                'category' => 'Administrator',
                'description' => 'Rekam jejak perubahan data, diff snapshot, dan aktivitas',
                'icon' => 'clipboard-list',
                'svg' => $this->getIconSvg('clipboard-list'),
                'url' => route('admin.logs.index'),
                'keywords' => 'log audit aktivitas riwayat trail history perubahan diff snapshot ip',
            ];
        }

        // 1. Filter Features
        if ($q === '') {
            $matchedFeatures = array_slice($allFeatures, 0, 6);
        } else {
            $matchedFeatures = array_values(array_filter($allFeatures, function ($item) use ($q) {
                return stripos($item['title'], $q) !== false
                    || stripos($item['description'], $q) !== false
                    || stripos($item['keywords'], $q) !== false
                    || stripos($item['category'], $q) !== false;
            }));
        }

        // 2. Query Asal Sekolah / Lembaga Pendidikan
        $institutionsQuery = Student::query();
        if ($q !== '') {
            $institutionsQuery->where('institution', 'like', "%{$q}%");
        }
        $institutions = $institutionsQuery
            ->select('institution')
            ->selectRaw('count(*) as total')
            ->whereNotNull('institution')
            ->where('institution', '!=', '')
            ->groupBy('institution')
            ->orderByDesc('total')
            ->take(6)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->institution,
                    'count' => (int) $item->total,
                    'url' => route('admin.students.index', ['search' => $item->institution]),
                ];
            });

        // 3. Query Peserta (Siswa & Mahasiswa)
        $students = [];
        if ($q !== '') {
            $students = Student::query()
                ->with('department')
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('institution', 'like', "%{$q}%")
                        ->orWhere('identity_number', 'like', "%{$q}%")
                        ->orWhere('major', 'like', "%{$q}%");
                })
                ->orderByDesc('created_at')
                ->take(8)
                ->get()
                ->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->name,
                        'identity_number' => $s->identity_number,
                        'institution' => $s->institution,
                        'major' => $s->major,
                        'type_label' => $s->type_label,
                        'type' => $s->type,
                        'photo_url' => $s->photo_url,
                        'department_name' => $s->department?->name ?? '-',
                        'status' => $s->status,
                        'url' => route('admin.students.show', $s->id),
                    ];
                });
        }

        return response()->json([
            'query' => $q,
            'features' => $matchedFeatures,
            'institutions' => $institutions,
            'students' => $students,
        ]);
    }

    /**
     * Helper SVG icon string agar render instan tanpa manipulasi Lucide DOM yang menyebabkan duplikasi node.
     */
    private function getIconSvg(string $name): string
    {
        return match ($name) {
            'layout-dashboard' => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>',
            'users' => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            'user-plus' => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>',
            'award' => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>',
            'plus-circle' => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>',
            'sliders' => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="4" y1="21" y2="14"/><line x1="4" x2="4" y1="10" y2="3"/><line x1="12" x2="12" y1="21" y2="12"/><line x1="12" x2="12" y1="8" y2="3"/><line x1="20" x2="20" y1="21" y2="16"/><line x1="20" x2="20" y1="12" y2="3"/><line x1="1" x2="7" y1="14" y2="14"/><line x1="9" x2="15" y1="8" y2="8"/><line x1="17" x2="23" y1="16" y2="16"/></svg>',
            'badge-percent' => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m15 9-6 6"/><path d="M9 9h.01"/><path d="M15 15h.01"/></svg>',
            'bar-chart-3' => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg>',
            'file-spreadsheet' => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M8 13h2"/><path d="M14 13h2"/><path d="M8 17h2"/><path d="M14 17h2"/></svg>',
            'user' => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
            'user-check' => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>',
            'clipboard-list' => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>',
            default => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>',
        };
    }
}
