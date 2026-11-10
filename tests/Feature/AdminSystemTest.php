<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Assessment;
use App\Models\AssessmentAspect;
use App\Models\Department;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/students');
        $response->assertStatus(200);

        $response = $this->get('/analytics');
        $response->assertStatus(200);

        $response = $this->get('/profile');
        $response->assertStatus(200);
    }

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }

    public function test_administrator_can_access_dashboard_operators_and_logs(): void
    {
        $admin = Admin::create([
            'name' => 'Super Administrator',
            'username' => 'superadmin',
            'password' => Hash::make('password123'),
            'role' => 'administrator',
            'is_primary' => true,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin/dashboard');
        $response->assertStatus(200);

        $response = $this->actingAs($admin, 'admin')->get('/admin/operators');
        $response->assertStatus(200);

        $response = $this->actingAs($admin, 'admin')->get('/admin/logs');
        $response->assertStatus(200);
    }

    public function test_operator_is_forbidden_from_operators_and_logs(): void
    {
        $operator = Admin::create([
            'name' => 'Staff Operator',
            'username' => 'operator1',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'is_primary' => false,
            'is_active' => true,
        ]);

        $response = $this->actingAs($operator, 'admin')->get('/admin/dashboard');
        $response->assertStatus(200);

        $response = $this->actingAs($operator, 'admin')->get('/admin/operators');
        $response->assertStatus(403);

        $response = $this->actingAs($operator, 'admin')->get('/admin/logs');
        $response->assertStatus(403);
    }

    public function test_status_sync_command_updates_expired_students(): void
    {
        $dept = Department::first();

        $activeStudent = Student::create([
            'type' => 'prakerin',
            'identity_number' => '11111',
            'name' => 'Siswa Aktif',
            'institution' => 'SMKN 1 Pacitan',
            'major' => 'RPL',
            'department_id' => $dept->id,
            'start_date' => Carbon::today()->subMonths(2),
            'end_date' => Carbon::today()->addMonth(),
            'status' => 'active',
        ]);

        $expiredStudent = Student::create([
            'type' => 'magang',
            'identity_number' => '22222',
            'name' => 'Mahasiswa Selesai',
            'institution' => 'Universitas Pacitan',
            'major' => 'Informatika',
            'department_id' => $dept->id,
            'start_date' => Carbon::today()->subMonths(4),
            'end_date' => Carbon::today()->subDay(),
        ]);

        // Simulasikan status masih 'active' di database sebelum command dijalankan
        DB::table('students')
            ->where('id', $expiredStudent->id)
            ->update(['status' => 'active']);

        $this->artisan('students:sync-status')
            ->expectsOutputToContain('Berhasil sinkronisasi status: 1 peserta diperbarui menjadi Selesai (completed).')
            ->assertSuccessful();

        $this->assertEquals('active', $activeStudent->fresh()->status);
        $this->assertEquals('completed', $expiredStudent->fresh()->status);
    }

    public function test_assessment_must_be_unique_per_student(): void
    {
        $dept = Department::first();

        $student = Student::create([
            'type' => 'prakerin',
            'identity_number' => '33333',
            'name' => 'Siswa Bintang',
            'institution' => 'SMKN 1',
            'major' => 'RPL',
            'department_id' => $dept->id,
            'start_date' => Carbon::today()->subMonth(),
            'end_date' => Carbon::today()->addMonth(),
            'status' => 'active',
        ]);

        // Nilai pertama berhasil
        $assessment1 = Assessment::create([
            'student_id' => $student->id,
            'assessment_date' => Carbon::today(),
            'notes' => 'Catatan 1',
        ]);
        $this->assertNotNull($assessment1->id);

        // Nilai kedua untuk siswa yang sama harus gagal karena unique constraint
        $this->expectException(QueryException::class);
        Assessment::create([
            'student_id' => $student->id,
            'assessment_date' => Carbon::today(),
            'notes' => 'Catatan 2',
        ]);
    }

    public function test_cannot_create_more_than_two_administrators(): void
    {
        // Buat admin ke-1 dan ke-2
        Admin::create([
            'name' => 'Admin Satu',
            'username' => 'admin1',
            'password' => Hash::make('secret123'),
            'role' => 'administrator',
            'is_primary' => true,
        ]);

        Admin::create([
            'name' => 'Admin Dua',
            'username' => 'admin2',
            'password' => Hash::make('secret123'),
            'role' => 'administrator',
            'is_primary' => false,
        ]);

        // Coba jalankan command admin:create-administrator untuk akun ke-3 -> harus ditolak
        $this->artisan('admin:create-administrator')
            ->expectsOutputToContain('Gagal: Sistem hanya mengizinkan maksimal tepat 2 akun Administrator')
            ->assertFailed();
    }

    public function test_export_excel_endpoint_works(): void
    {
        $admin = Admin::create([
            'name' => 'Admin Utama',
            'username' => 'admin_export',
            'password' => Hash::make('secret123'),
            'role' => 'administrator',
            'is_primary' => true,
        ]);

        $response = $this->actingAs($admin, 'admin')->post('/admin/export/download', [
            'dataset' => 'both',
        ]);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_can_view_student_index_and_create_pages(): void
    {
        $operator = Admin::create([
            'name' => 'Operator Data',
            'username' => 'op_data',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'is_primary' => false,
            'is_active' => true,
        ]);

        $response = $this->actingAs($operator, 'admin')->get('/admin/students');
        $response->assertStatus(200);

        $response = $this->actingAs($operator, 'admin')->get('/admin/students/create');
        $response->assertStatus(200);
    }

    public function test_can_create_prakerin_and_magang_students(): void
    {
        $operator = Admin::create([
            'name' => 'Operator Data',
            'username' => 'op_create',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'is_primary' => false,
            'is_active' => true,
        ]);

        $dept = Department::first();

        // 1. Siswa Prakerin (SMK)
        $prakerinData = [
            'type' => 'prakerin',
            'identity_number' => 'NIS-998877',
            'name' => 'Ahmad Santoso',
            'institution' => 'SMKN 1 Pacitan',
            'major' => 'Rekayasa Perangkat Lunak',
            'class' => 'XII RPL 1',
            'department_id' => $dept->id,
            'start_date' => Carbon::today()->format('Y-m-d'),
            'end_date' => Carbon::today()->addMonths(3)->format('Y-m-d'),
        ];

        $response = $this->actingAs($operator, 'admin')->post('/admin/students', $prakerinData);
        $response->assertRedirect('/admin/students');
        $this->assertDatabaseHas('students', [
            'identity_number' => 'NIS-998877',
            'type' => 'prakerin',
            'status' => 'active',
        ]);

        // 2. Mahasiswa Magang (Universitas)
        $magangData = [
            'type' => 'magang',
            'identity_number' => 'NIM-210987',
            'name' => 'Citra Lestari',
            'institution' => 'Universitas Gadjah Mada',
            'major' => 'Sistem Informasi',
            'faculty' => 'Fakultas MIPA',
            'department_id' => $dept->id,
            'start_date' => Carbon::today()->subMonths(1)->format('Y-m-d'),
            'end_date' => Carbon::today()->addMonths(2)->format('Y-m-d'),
        ];

        $response = $this->actingAs($operator, 'admin')->post('/admin/students', $magangData);
        $response->assertRedirect('/admin/students');
        $this->assertDatabaseHas('students', [
            'identity_number' => 'NIM-210987',
            'type' => 'magang',
            'status' => 'active',
        ]);
    }

    public function test_can_view_assessments_and_create_assessment_with_scores(): void
    {
        $operator = Admin::create([
            'name' => 'Operator Penilai',
            'username' => 'op_assess',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'is_primary' => false,
            'is_active' => true,
        ]);

        $dept = Department::first();

        $student = Student::create([
            'type' => 'prakerin',
            'identity_number' => 'NIS-554433',
            'name' => 'Doni Wahyudi',
            'institution' => 'SMKN 2 Pacitan',
            'major' => 'TKJ',
            'department_id' => $dept->id,
            'start_date' => Carbon::today()->subMonths(2),
            'end_date' => Carbon::today()->addMonth(),
            'status' => 'active',
        ]);

        // Akses daftar penilaian
        $response = $this->actingAs($operator, 'admin')->get('/admin/assessments');
        $response->assertStatus(200);

        // Akses form input penilaian
        $response = $this->actingAs($operator, 'admin')->get('/admin/assessments/create');
        $response->assertStatus(200);

        $aspects = AssessmentAspect::where('is_active', true)->get();
        $scores = [];
        foreach ($aspects as $aspect) {
            $scores[$aspect->id] = 88;
        }

        // Simpan penilaian
        $postData = [
            'student_id' => $student->id,
            'assessment_date' => Carbon::today()->format('Y-m-d'),
            'scores' => $scores,
            'notes' => 'Sangat rajin dan berprestasi',
        ];

        $response = $this->actingAs($operator, 'admin')->post('/admin/assessments', $postData);
        $response->assertRedirect('/admin/assessments');

        // Pastikan tersimpan dan rata-rata terhitung
        $assessment = Assessment::where('student_id', $student->id)->first();
        $this->assertNotNull($assessment);
        $this->assertEquals(88.0, $assessment->average_score);
        $this->assertEquals('Baik', $assessment->category->name);

        // Tampilkan halaman detail siswa yang sudah dinilai
        $response = $this->actingAs($operator, 'admin')->get('/admin/students/'.$student->id);
        $response->assertStatus(200);

        // Tampilkan halaman lembar nilai
        $response = $this->actingAs($operator, 'admin')->get('/admin/assessments/'.$assessment->id);
        $response->assertStatus(200);

        // Pastikan input penilaian kedua untuk siswa yang sama DITOLAK oleh controller dengan validation error
        $duplicateResponse = $this->actingAs($operator, 'admin')->post('/admin/assessments', $postData);
        $duplicateResponse->assertSessionHasErrors('student_id');
    }

    // ─────────────────────────────────────────────
    // FOTO PROFIL — ADMINISTRATOR
    // ─────────────────────────────────────────────

    public function test_administrator_can_upload_profile_photo(): void
    {
        $admin = Admin::create([
            'name' => 'Admin Foto',
            'username' => 'adminfoto',
            'password' => Hash::make('password123'),
            'role' => 'administrator',
            'is_primary' => true,
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->image('avatar.jpg', 200, 200);

        $response = $this->actingAs($admin, 'admin')->put('/admin/profile', [
            'name' => $admin->name,
            'username' => $admin->username,
            'photo' => $file,
        ]);

        $response->assertRedirect('/admin/profile');

        // Verifikasi blob tersimpan
        $rawData = $admin->fresh()->getAttributes()['photo_data'];
        $this->assertNotNull($rawData);
        $this->assertNotEmpty($rawData);
    }

    public function test_admin_profile_photo_served_from_db(): void
    {
        $fakeImage = UploadedFile::fake()->image('test.jpg', 100, 100);
        $bytes = file_get_contents($fakeImage->getRealPath());

        $admin = Admin::create([
            'name' => 'Admin Serve',
            'username' => 'adminserve',
            'password' => Hash::make('password123'),
            'role' => 'administrator',
            'is_primary' => false,
            'is_active' => true,
            'photo_data' => $bytes,
            'photo_mime' => 'image/jpeg',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->get('/admin/profile/photo/'.$admin->id);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/jpeg');
    }

    // ─────────────────────────────────────────────
    // FOTO PROFIL — OPERATOR
    // ─────────────────────────────────────────────

    public function test_administrator_can_create_operator_with_photo(): void
    {
        $admin = Admin::create([
            'name' => 'Admin Photo Test',
            'username' => 'adminphototest',
            'password' => Hash::make('password123'),
            'role' => 'administrator',
            'is_primary' => true,
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->image('operator.png', 150, 150);

        $response = $this->actingAs($admin, 'admin')->post('/admin/operators', [
            'name' => 'Operator Baru',
            'username' => 'op_foto',
            'password' => 'password123',
            'is_active' => '1',
            'photo' => $file,
        ]);

        $response->assertRedirect('/admin/operators');

        $operator = Admin::where('username', 'op_foto')->first();
        $this->assertNotNull($operator);
        $rawData = $operator->getAttributes()['photo_data'];
        $this->assertNotNull($rawData);
        $this->assertEquals('image/png', $operator->photo_mime);
    }

    public function test_administrator_can_update_operator_photo(): void
    {
        $admin = Admin::create([
            'name' => 'Admin Update Photo',
            'username' => 'adminupdatephoto',
            'password' => Hash::make('password123'),
            'role' => 'administrator',
            'is_primary' => true,
            'is_active' => true,
        ]);

        $operator = Admin::create([
            'name' => 'Operator No Photo',
            'username' => 'op_nophoto',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->image('new_avatar.jpg', 200, 200);

        $response = $this->actingAs($admin, 'admin')->put('/admin/operators/'.$operator->id, [
            'name' => $operator->name,
            'username' => $operator->username,
            'photo' => $file,
        ]);

        $response->assertRedirect('/admin/operators');
        $rawData = $operator->fresh()->getAttributes()['photo_data'];
        $this->assertNotNull($rawData);
        $this->assertEquals('image/jpeg', $operator->fresh()->photo_mime);
    }

    // ─────────────────────────────────────────────
    // FOTO SISWA — SERVE DARI DB BLOB
    // ─────────────────────────────────────────────

    public function test_student_photo_served_from_db_blob(): void
    {
        $admin = Admin::create([
            'name' => 'Admin Student Photo',
            'username' => 'adminstphoto',
            'password' => Hash::make('password123'),
            'role' => 'administrator',
            'is_primary' => true,
            'is_active' => true,
        ]);

        $fakeImage = UploadedFile::fake()->image('siswa.jpg', 100, 100);
        $bytes = file_get_contents($fakeImage->getRealPath());

        $dept = Department::first() ?? Department::create(['name' => 'TI', 'code' => 'TI', 'description' => null]);

        $student = Student::create([
            'type' => 'prakerin',
            'identity_number' => '1234567890',
            'name' => 'Siswa Foto',
            'major' => 'RPL',
            'institution' => 'SMKN 1 Test',
            'department_id' => $dept->id,
            'start_date' => Carbon::today()->toDateString(),
            'end_date' => Carbon::today()->addMonths(3)->toDateString(),
            'status' => 'active',
            'photo_data' => $bytes,
            'photo_mime' => 'image/jpeg',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->get('/admin/students/'.$student->id.'/photo');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/jpeg');
    }

    // ─────────────────────────────────────────────
    // QUICK SEARCH API
    // ─────────────────────────────────────────────

    public function test_admin_quick_search_returns_features_and_schools(): void
    {
        $admin = Admin::create([
            'name' => 'Admin Search',
            'username' => 'adminsearch',
            'password' => Hash::make('password123'),
            'role' => 'administrator',
            'is_primary' => true,
            'is_active' => true,
        ]);

        $dept = Department::first() ?? Department::create(['name' => 'TI', 'code' => 'TI', 'description' => null]);

        Student::create([
            'type' => 'prakerin',
            'identity_number' => 'NIS001',
            'name' => 'Budi Santoso',
            'major' => 'RPL',
            'institution' => 'SMKN 1 Pacitan',
            'department_id' => $dept->id,
            'start_date' => Carbon::today()->toDateString(),
            'end_date' => Carbon::today()->addMonths(3)->toDateString(),
            'status' => 'active',
        ]);

        // Default empty query: returns popular features and registered institutions
        $response = $this->actingAs($admin, 'admin')->getJson('/admin/quick-search');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'query',
            'features',
            'institutions',
            'students',
        ]);
        $response->assertJsonFragment(['name' => 'SMKN 1 Pacitan']);

        // Query by school name
        $response = $this->actingAs($admin, 'admin')->getJson('/admin/quick-search?q=Pacitan');
        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('institutions'));
        $this->assertNotEmpty($response->json('students'));
        $this->assertEquals('SMKN 1 Pacitan', $response->json('institutions.0.name'));
        $this->assertEquals('Budi Santoso', $response->json('students.0.name'));

        // Query by dashboard feature keyword
        $response = $this->actingAs($admin, 'admin')->getJson('/admin/quick-search?q=penilaian');
        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('features'));
    }
}
