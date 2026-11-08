PLAN — Rombak Besar PRAKERIN DISKOMINFO Pacitan
Dokumen induk. Semua keputusan, struktur folder, skema database, hak akses, dan urutan kerja ada di sini. File kode baru dibuat setelah Plan ini disetujui, per tahap, urut A → K. 0. Kondisi Project Saat Ini (hasil bedah `kominfo-main.zip` + `kominfo.sql`)
Hal Kondisi sekarang Stack Laravel 13 (PHP ^8.3), Blade, Tailwind 4 (Vite), Alpine, GSAP, Lucide Database MariaDB, DB `kominfo`. Tabel: `admins`, `students`, `assessments`, `sessions`, `cache`, `jobs`, `migrations` (+ `users` bawaan Laravel, tidak dipakai) Data 57 baris siswa maksimum (auto-increment 58), 2 penilaian, 1 akun admin Auth admin Manual: cek `session('admin_id')` lewat `AdminMiddleware`. Tidak ada role, tidak ada throttle login, tidak ada log Siswa Kolom: `nis, name, major, class, start_date, end_date, status (active/completed/inactive)`. Tidak ada sekolah, tipe, bidang, foto Penilaian 6 aspek hardcode sebagai kolom (`discipline`, `responsibility`, `teamwork`, `communication`, `initiative`, `work_quality`). Tidak ada unique per siswa, sehingga bug dobel Kategori performa Hardcode di `PerformanceService` (90/80/70/60) Layout Tiap view adalah HTML lengkap sendiri (24–42 KB per file), tidak ada layout bersama, GSAP/Lucide via CDN Publik `/students` menampilkan nama + NIS + detail. `/analytics` punya "Peringkat Terbaik" dan blok "Ingin melihat profil lengkap siswa?". `/profile` menampilkan Hari Kerja tanpa jam
Temuan yang mempengaruhi rencana:

1. Penilaian siswa id 20 sudah dobel di database. Migrasi harus merapikan ini sebelum unique constraint dipasang.
2. Data siswa lama tidak punya sekolah, tipe, bidang. Semua default `prakerin`, sekolah dan bidang diisi manual oleh admin setelah migrasi.
3. Status `inactive` dihapus (jadi 2 status saja: `active`, `completed`). Data lama `inactive` diubah ke `completed`.
4. `AGENTS.md` / `CLAUDE.md` di repo berisi instruksi bootstrap Laravel Boost. Tidak dipakai dan tidak dijalankan dalam rencana ini.

5. Keputusan & Asumsi (mohon dicek, bisa diubah sebelum Tahap B)

# Keputusan Alasan K1 Satu penilaian per siswa (unique `student_id`). Edit lewat tombol edit, bukan input baru Sesuai bug yang dijelaskan: pilih nama A lagi tidak boleh bisa K2 Export Excel bisa dipakai administrator & operator Sesuai permintaan. Setiap export tercatat di log aktivitas supaya bisa diaudit administrator K3 Foto profil bisa diupload administrator & operator lewat form data siswa Operator memang input data. Foto disimpan di disk private, tampil hanya untuk admin login K4 Akun administrator maksimal 2 (primary + backup), dibuat lewat artisan, bukan lewat UI Mencegah eskalasi hak akses lewat web K5 Aspek penilaian dan kategori performa bisa dikelola administrator & operator Sesuai permintaan. Semua perubahan tercatat di log (nilai lama dan baru) K6 Aspek yang sudah punya nilai tidak bisa dihapus, hanya dinonaktifkan Menjaga integritas data nilai lama K7 "Tahun" pada filter = tahun `start_date`. Ada opsi Semua Konsisten untuk filter dan analytics K8 Hapus data = hard delete, tapi snapshot data lama masuk log aktivitas Sederhana, tetap bisa diaudit K9 Export memakai `openspout/openspout` (streaming XLSX) Ringan untuk data besar, tanpa ekstensi berat K10 Jam kerja publik dipindah ke `config/diskominfo.php`. Jam aslinya perlu dikonfirmasi (placeholder 07.30–16.00 WIB) Saya tidak punya data jam kerja resmi

2. Tahapan Kerja
   Tahap A — Persiapan & Backup

1. Backup DB: `mysqldump -u root -p kominfo > backup_kominfo_2026-11-03.sql`
1. Buat branch git: `git checkout -b rombak-admin-v2`
1. Install dependency export: `composer require openspout/openspout`
1. Install chart lokal: `npm install chart.js`
1. Set `.env` untuk MariaDB (bukan sqlite), `APP_DEBUG=false` untuk produksi, `SESSION_SECURE_COOKIE=true` bila HTTPS

Tahap B — Database & Model
Migrasi dijalankan urut (nama file di bagian 4). Hasil: kolom baru siswa, tabel bidang, aspek dinamis, skor, kategori performa, log aktivitas, role admin, dan unique penilaian. Model: `Admin`, `Student`, `Department`, `Assessment`, `AssessmentAspect`, `AssessmentScore`, `PerformanceCategory`, `ActivityLog`.
Tahap C — Auth, Role, Keamanan Dasar

1. Guard `admin` (session) memakai model `Admin` sebagai `Authenticatable`
2. Login: throttle 5 percobaan/menit per username+IP, regenerate session, cek `is_active`
3. Middleware: `auth:admin`, `role:administrator`, `SecurityHeaders`
4. Gate/Policy untuk aksi tiap role (matriks di bagian 5)
5. Command `admin:create-administrator` (maks 2, flag `--primary`)

Tahap D — Layout Admin Baru (kasar tapi jelas)

- `layouts/admin.blade.php`: sidebar kiri, konten kanan, topbar kecil (nama + role + logout)
- Menu operator: Dashboard, Siswa/Mahasiswa, Penilaian, Aspek Penilaian, Kategori Performa, Analytics, Export, Akun Saya
- Menu tambahan khusus administrator: Akun Operator, Log Aktivitas
- Teks seminimal mungkin: judul halaman + label fitur saja, tanpa paragraf penjelasan
- Komponen bersama: tabel dinamis, filter bar, pagination, flash message, badge status
- Desain polos dulu (Tailwind default). Polish visual menyusul setelah fungsi stabil

Tahap E — Modul Siswa / Mahasiswa

1. Form dengan radio di atas: `Siswa Prakerin` / `Mahasiswa Magang`, form berubah via Alpine
   - Prakerin: NIS, Nama Sekolah, Jurusan, Kelas
   - Magang: NIM, Kampus, Fakultas, Prodi/Jurusan
   - Keduanya: Bidang (Sekretariat, IT, Statistik, Infokom), tanggal mulai, tanggal selesai, foto
2. Upload foto: validasi `image`, jpg/png/webp, maks 2 MB, nama acak, simpan ke disk private, tampil lewat route terautentikasi
3. Tabel dinamis: pencarian (nama, NIS/NIM, sekolah/kampus), filter Tahun (All), Tipe, Bidang, Status, pagination server-side
4. Klik baris → halaman detail lengkap (bukan card)
5. Status otomatis: command `students:sync-status` terjadwal harian + hook saat simpan + sinkron ringan saat buka dashboard. `end_date < hari ini` → `completed`

Tahap F — Modul Penilaian

1. Aspek dinamis (tabel `assessment_aspects`), dikelola administrator & operator. Aspek harus ada sebelum nilai diisi
2. Form penilaian dibangun dari aspek aktif. Dropdown siswa hanya menampilkan siswa yang belum dinilai
3. Fix bug dobel 3 lapis: (a) unique index DB, (b) `Rule::unique` di validasi, (c) dropdown disaring + redirect ke edit bila sudah ada
4. Halaman Penilaian berupa tabel seperti daftar siswa (cari, filter tahun, klik baris → detail)
5. Kategori performa dari tabel `performance_categories`, administrator & operator bisa ubah batas nilai (validasi: urut, tidak tumpang tindih, mulai dari 0). Cache dibersihkan saat diubah

Tahap G — Akun Operator & Log Aktivitas (administrator saja)

1. CRUD operator: tambah, ubah, nonaktifkan, hapus, reset password
2. Log aktivitas otomatis via trait `LogsActivity` pada Student, Assessment, Aspect, Category, Admin + event login/logout/login gagal
3. Halaman log: tabel, filter operator/aksi/tanggal, klik baris → lihat data sebelum dan sesudah
4. Operator mengakses `/admin/logs` atau `/admin/operators` → 403

Tahap H — Analytics Admin

1. Filter: Tahun dan Bidang (juga Tipe)
2. Grafik tahunan: jumlah peserta per tahun (aktif vs selesai), rata-rata nilai per tahun, selesai per bidang
3. Hapus blok Peringkat dan halaman analytics per-siswa (`admin.analytics.student`)
4. Chart.js lokal (bukan CDN) lewat `resources/js/analytics.js`

Tahap I — Export Excel (administrator & operator)

1. Halaman Export: pilih dataset (Data Siswa / Penilaian / keduanya sebagai 2 sheet)
2. Checkbox kolom yang mau diexport, plus filter Tahun, Tipe, Bidang, Status
3. Kolom divalidasi terhadap whitelist di server
4. Proteksi CSV/formula injection (sel diawali `= + - @` diberi awalan `'`)
5. Aksi export masuk log aktivitas

Tahap J — Halaman Publik

1. `/students`: hanya Sekolah/Kampus + Jurusan (tanpa nama, NIS/NIM, foto, status). Route detail `/students/{student}` dihapus
2. `/analytics` publik: hapus "Peringkat Terbaik" dan blok "Ingin melihat profil lengkap siswa?"
3. `/profile`: Hari Kerja + jam kerja dari `config/diskominfo.php`
4. Desain publik tidak diubah selain poin di atas

Tahap K — Hardening, QA, Deploy
Checklist keamanan (bagian 6), test fitur (bagian 8), cron scheduler, `php artisan optimize`, build assets. 3. Struktur Folder Final
`[BARU]` file baru · `[UBAH]` file lama diubah · `[HAPUS]` dihapus · tanpa tanda = tidak disentuh

```
kominfo-main/
├── Plan.md                                              [BARU]
├── .env.example                                         [UBAH]  MariaDB + session secure
├── bootstrap/app.php                                    [UBAH]  alias middleware role, security headers
├── config/
│   ├── auth.php                                         [UBAH]  guard + provider admin
│   └── diskominfo.php                                   [BARU]  hari & jam kerja, daftar bidang
├── app/
│   ├── Console/Commands/
│   │   ├── SyncStudentStatus.php                        [BARU]  students:sync-status
│   │   └── CreateAdministrator.php                      [BARU]  admin:create-administrator
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php                      [UBAH]  login guard + throttle + log
│   │   │   ├── PublicStudentController.php              [UBAH]  hanya sekolah + jurusan
│   │   │   ├── PublicAnalyticsController.php            [UBAH]  hapus ranking
│   │   │   ├── StudentController.php                    [HAPUS] duplikat tak terpakai
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php              [UBAH]
│   │   │       ├── StudentController.php                [UBAH]  tipe, bidang, foto, filter, search
│   │   │       ├── StudentPhotoController.php           [BARU]  tampil foto private
│   │   │       ├── AssessmentController.php             [UBAH]  aspek dinamis + anti dobel
│   │   │       ├── AssessmentAspectController.php       [BARU]  semua admin
│   │   │       ├── PerformanceCategoryController.php    [BARU]  semua admin
│   │   │       ├── OperatorController.php               [BARU]  administrator
│   │   │       ├── ActivityLogController.php            [BARU]  administrator
│   │   │       ├── AnalyticsController.php              [UBAH]  tahun/bidang, hapus ranking + student()
│   │   │       ├── ExportController.php                 [BARU]  semua admin
│   │   │       └── ProfileController.php                [UBAH]  pakai guard auth
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php                      [HAPUS] diganti auth:admin
│   │   │   ├── EnsureRole.php                           [BARU]
│   │   │   └── SecurityHeaders.php                      [BARU]
│   │   └── Requests/
│   │       ├── StudentRequest.php                       [BARU]
│   │       ├── AssessmentRequest.php                    [BARU]
│   │       ├── OperatorRequest.php                      [BARU]
│   │       ├── PerformanceCategoryRequest.php           [BARU]
│   │       └── ExportRequest.php                        [BARU]
│   ├── Models/
│   │   ├── Admin.php                                    [UBAH]  Authenticatable + role
│   │   ├── Student.php                                  [UBAH]
│   │   ├── Assessment.php                               [UBAH]
│   │   ├── Department.php                               [BARU]
│   │   ├── AssessmentAspect.php                         [BARU]
│   │   ├── AssessmentScore.php                          [BARU]
│   │   ├── PerformanceCategory.php                      [BARU]
│   │   ├── ActivityLog.php                              [BARU]
│   │   └── Concerns/LogsActivity.php                    [BARU]  trait
│   ├── Policies/ (atau Gate di AppServiceProvider)      [BARU]
│   ├── Providers/AppServiceProvider.php                 [UBAH]  Gate + schedule hook
│   └── Services/
│       ├── PerformanceService.php                       [UBAH]  baca DB + cache
│       ├── ActivityLogger.php                           [BARU]
│       ├── AnalyticsService.php                         [BARU]  query tahunan
│       └── StudentExportService.php                     [BARU]  openspout
├── database/
│   ├── migrations/                                      (urutan di bagian 4)
│   └── seeders/
│       ├── DatabaseSeeder.php                           [UBAH]
│       ├── DepartmentSeeder.php                         [BARU]
│       ├── AssessmentAspectSeeder.php                   [BARU]
│       └── PerformanceCategorySeeder.php                [BARU]
├── resources/
│   ├── css/app.css                                     [UBAH]
│   ├── js/
│   │   ├── app.js                                       [UBAH]
│   │   ├── admin-table.js                               [BARU]  search/filter dinamis (debounce + fetch)
│   │   └── analytics.js                                 [BARU]  Chart.js
│   └── views/
│       ├── layouts/admin.blade.php                      [BARU]  sidebar kiri + konten kanan
│       ├── components/admin/
│       │   ├── sidebar.blade.php                        [BARU]
│       │   ├── topbar.blade.php                         [BARU]
│       │   ├── filter-bar.blade.php                     [BARU]
│       │   ├── badge-status.blade.php                   [BARU]
│       │   └── flash.blade.php                          [BARU]
│       ├── admin/
│       │   ├── login.blade.php                          [UBAH]
│       │   ├── dashboard/page.blade.php                 [UBAH]
│       │   ├── students/{index,_table,create,edit,show,_form}.blade.php   [BARU/UBAH]
│       │   ├── assessments/{index,_table,create,edit,show,_form}.blade.php [BARU/UBAH]
│       │   ├── aspects/index.blade.php                  [BARU]
│       │   ├── categories/index.blade.php               [BARU]
│       │   ├── operators/{index,create,edit}.blade.php  [BARU]
│       │   ├── logs/{index,show}.blade.php              [BARU]
│       │   ├── analytics/index.blade.php                [UBAH]
│       │   ├── analytics/student.blade.php              [HAPUS]
│       │   ├── export/index.blade.php                   [BARU]
│       │   └── profile/index.blade.php                  [UBAH]
│       ├── students/index.blade.php                     [UBAH]  sekolah + jurusan
│       ├── students/show.blade.php                      [HAPUS]
│       ├── public/analytics.blade.php                   [UBAH]  hapus peringkat + CTA
│       ├── public/profile.blade.php                     [UBAH]  hari + jam kerja
│       └── partials/ (navbar, page-transition)          tetap
├── routes/
│   ├── web.php                                          [UBAH]  group admin + role
│   └── console.php                                      [UBAH]  Schedule students:sync-status
├── storage/app/private/students/                        [BARU]  foto (otomatis dibuat)
└── tests/Feature/                                       [BARU]  Auth, Role, Assessment dobel, Status otomatis, Export

```

4. Skema Database & Urutan Migrasi
   Jalankan berurutan (`php artisan migrate`). Semua file di `database/migrations/`.

# File Isi 1 `2026_11_03_000001_add_role_fields_to_admins_table` `name`, `role` (`administrator`/`operator`, default `operator`), `is_primary` bool, `is_active` bool default true, `last_login_at`. Akun `Diskominfo` (id 1) → `administrator` + `is_primary` 2 `2026_11_03_000002_create_departments_table` `id`, `name` unique, `sort_order`. Seed: Sekretariat, IT, Statistik, Infokom 3 `2026_11_03_000003_update_students_table` rename `nis` → `identity_number`; tambah `type` (`prakerin`/`magang`, default `prakerin`), `institution` (sekolah/kampus), `faculty` (nullable), `department_id` (FK nullable, `nullOnDelete`), `photo_path` (nullable). `inactive` → `completed`. Ganti unique `nis` → unique (`type`,`identity_number`). Index: `status`, `end_date`, `type` 4 `2026_11_03_000004_create_assessment_aspects_table` `id`, `name`, `key` unique, `sort_order`, `is_active`. Seed 6 aspek lama 5 `2026_11_03_000005_create_assessment_scores_table` `assessment_id` FK cascade, `aspect_id` FK restrict, `score` tinyint, unique (`assessment_id`,`aspect_id`). Pindahkan data dari 6 kolom lama 6 `2026_11_03_000006_make_assessments_unique_per_student` Rapikan dobel (simpan yang terbaru per siswa), lalu `unique(student_id)` 7 `2026_11_03_000007_drop_old_score_columns_from_assessments` Hapus 6 kolom nilai lama (setelah data aman di langkah 5) 8 `2026_11_03_000008_create_performance_categories_table` `name`, `level_key`, `min_score`, `sort_order`. Seed 90/80/70/60/0 sesuai kategori lama 9 `2026_11_03_000009_create_activity_logs_table` `admin_id` (nullable), `action`, `subject_type`, `subject_id`, `description`, `old_values` json, `new_values` json, `ip_address`, `user_agent`, `created_at`. Index: `admin_id`, `created_at`

Aturan data:

- `end_date` wajib di form (kolom DB tetap nullable agar data lama tidak rusak)
- `status` dihitung dari `end_date`; tidak bisa dipaksa `active` jika sudah lewat tanggal selesai
- Setelah migrasi, admin melengkapi `institution` dan `department_id` untuk data lama

5. Matriks Hak Akses
   Fitur Administrator Operator Login ke dashboard masing-masing ✅ ✅ Lihat Dashboard, Siswa, Penilaian, Analytics ✅ ✅ Tambah / Ubah / Hapus data siswa & mahasiswa (+ foto) ✅ ✅ Tambah / Ubah / Hapus penilaian ✅ ✅ Kelola Aspek Penilaian ✅ ✅ Atur Kategori Performa (batas nilai) ✅ ✅ CRUD Akun Operator + reset password ✅ ❌ Lihat Log Aktivitas ✅ ❌ Export Excel ✅ ✅ Ganti password sendiri ✅ ✅
   Akun administrator: tepat 2 (primary + backup), dibuat lewat artisan, tidak bisa dihapus lewat UI.
   Catatan: operator kini boleh mengubah aspek dan batas kategori, sehingga perubahan itu mempengaruhi nilai semua siswa. Karena itu setiap perubahan aspek, kategori, dan export wajib masuk Log Aktivitas (hanya dilihat administrator).
   Rute admin (ringkas):

```
/admin/login                         guest
/admin/dashboard                     auth:admin
/admin/students[...]                 auth:admin
/admin/students/{id}/photo           auth:admin
/admin/assessments[...]              auth:admin
/admin/analytics                     auth:admin
/admin/profile                       auth:admin
/admin/aspects[...]                  auth:admin
/admin/categories                    auth:admin
/admin/operators[...]                auth:admin + role:administrator
/admin/logs[...]                     auth:admin + role:administrator
/admin/export                        auth:admin

```

6. Checklist Keamanan (wajib sebelum go-live)

- [ ] Login throttle 5/menit per username+IP, pesan error generik
- [ ] Session regenerate saat login, invalidate saat logout, cookie `HttpOnly`, `SameSite=lax`, `Secure` bila HTTPS
- [ ] Password minimal 10 karakter untuk akun operator, hash bcrypt
- [ ] Semua form pakai CSRF; semua input lewat Form Request; `$fillable` ketat
- [ ] Role dicek di server (middleware + Gate), bukan hanya menyembunyikan menu
- [ ] Upload foto: cek MIME asli, batas 2 MB, nama acak, disk private, tidak bisa dieksekusi
- [ ] Foto hanya tampil lewat route terautentikasi
- [ ] Security headers: `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, CSP dasar
- [ ] Query memakai Eloquent/parameter binding (tanpa raw string dari input)
- [ ] Kolom export lewat whitelist, sel export aman dari formula injection
- [ ] `APP_DEBUG=false`, `.env` tidak bisa diakses dari web, dokumen root = `public/`
- [ ] Backup DB terjadwal; password akun default diganti
- [ ] Halaman publik tidak membocorkan nama, NIS/NIM, foto, atau ID internal

7. Langkah Backend Setelah Kode Siap (urutan eksekusi)

```bash
# 1. Backup
mysqldump -u root -p kominfo > backup_kominfo_2026-11-03.sql

# 2. Dependency
composer require openspout/openspout
npm install && npm install chart.js

# 3. Env (pastikan DB_CONNECTION=mysql, DB_DATABASE=kominfo)
cp .env.example .env   # lalu sesuaikan, jika belum ada
php artisan key:generate

# 4. Database
php artisan migrate
php artisan db:seed --class=DepartmentSeeder   # bila belum otomatis dari migrasi

# 5. Akun administrator cadangan
php artisan admin:create-administrator

# 6. Sinkron status pertama kali
php artisan students:sync-status

# 7. Jalankan
npm run build        # produksi
composer run dev     # lokal

```

Server produksi — tambahkan cron agar status otomatis jalan:

```
* * * * * cd /path/ke/kominfo-main && php artisan schedule:run >> /dev/null 2>&1

```

8. Rencana Pengujian
   Skenario Harus terjadi Operator buka `/admin/logs`, `/admin/operators` 403 Operator buka `/admin/aspects`, `/admin/categories`, `/admin/export` Berhasil, perubahan dan export tercatat di log Operator tambah / ubah / hapus siswa & penilaian Berhasil dan tercatat di log Administrator buat operator lalu login sebagai operator Masuk dashboard operator, menu administrator tidak muncul Buat akun administrator ketiga Ditolak Siswa A sudah dinilai → buka form penilaian baru Nama A tidak ada di dropdown Kirim paksa `student_id` A (manipulasi request) Ditolak validasi + unique DB Siswa dengan `end_date` kemarin Status otomatis `completed` setelah `students:sync-status` Tambah aspek baru → form penilaian Aspek muncul; aspek yang sudah dipakai tidak bisa dihapus Ubah batas kategori (mis. Baik ≥ 75) Kategori di tabel dan analytics ikut berubah Filter Tahun + Bidang + search di tabel Tabel berubah tanpa reload penuh Export dengan kolom terpilih File xlsx hanya berisi kolom tersebut Buka `/students` publik Hanya Sekolah/Kampus + Jurusan Upload file `.php` yang di-rename `.jpg` Ditolak
9. Urutan Pengerjaan Kode

10. Tahap B: migrations + models + seeders
11. Tahap C: auth, role, middleware, command admin
12. Tahap D: layout admin + komponen
13. Tahap E: modul siswa/mahasiswa
14. Tahap F: penilaian + aspek + kategori + fix dobel
15. Tahap G: operator + log
16. Tahap H: analytics
17. Tahap I: export
18. Tahap J: halaman publik
19. Tahap K: hardening + test

Setiap tahap diserahkan sebagai: ringkasan, daftar file dibuat/diubah, full code tiap file, dan langkah test.

build apps
