<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Assessment;
use App\Models\AssessmentAspect;
use App\Models\Department;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        \Illuminate\Support\Facades\DB::table('students')
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
        $this->expectException(\Illuminate\Database\QueryException::class);
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
        $response = $this->actingAs($operator, 'admin')->get('/admin/students/' . $student->id);
        $response->assertStatus(200);

        // Tampilkan halaman lembar nilai
        $response = $this->actingAs($operator, 'admin')->get('/admin/assessments/' . $assessment->id);
        $response->assertStatus(200);

        // Pastikan input penilaian kedua untuk siswa yang sama DITOLAK oleh controller dengan validation error
        $duplicateResponse = $this->actingAs($operator, 'admin')->post('/admin/assessments', $postData);
        $duplicateResponse->assertSessionHasErrors('student_id');
    }
}
