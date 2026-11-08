<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AssessmentAspectController;
use App\Http\Controllers\Admin\AssessmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\OperatorController;
use App\Http\Controllers\Admin\PerformanceCategoryController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\StudentPhotoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicAnalyticsController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\PublicStudentController;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $totalStudents = Student::count();
    $activeStudents = Student::where('status', 'active')->count();

    return view('welcome', [
        'totalStudents' => $totalStudents,
        'activeStudents' => $activeStudents,
    ]);
})->name('home');

Route::get('/students', [PublicStudentController::class, 'index'])->name('students.index');
Route::get('/analytics', [PublicAnalyticsController::class, 'index'])->name('analytics.index');
Route::get('/profile', [PublicProfileController::class, 'index'])->name('profile.index');

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Protected Area (Auth Guard Admin)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.page');

    // Siswa & Mahasiswa
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [AdminStudentController::class, 'create'])->name('students.create');
    Route::post('/students', [AdminStudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}', [AdminStudentController::class, 'show'])->name('students.show');
    Route::get('/students/{student}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [AdminStudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [AdminStudentController::class, 'destroy'])->name('students.destroy');
    Route::get('/students/{student}/photo', [StudentPhotoController::class, 'show'])->name('students.photo');

    // Penilaian (Assessments)
    Route::get('/assessments', [AssessmentController::class, 'index'])->name('assessments.index');
    Route::get('/assessments/create', [AssessmentController::class, 'create'])->name('assessments.create');
    Route::post('/assessments', [AssessmentController::class, 'store'])->name('assessments.store');
    Route::get('/assessments/{assessment}', [AssessmentController::class, 'show'])->name('assessments.show');
    Route::get('/assessments/{assessment}/edit', [AssessmentController::class, 'edit'])->name('assessments.edit');
    Route::put('/assessments/{assessment}', [AssessmentController::class, 'update'])->name('assessments.update');
    Route::delete('/assessments/{assessment}', [AssessmentController::class, 'destroy'])->name('assessments.destroy');

    // Aspek Penilaian Dinamis
    Route::get('/aspects', [AssessmentAspectController::class, 'index'])->name('aspects.index');
    Route::post('/aspects', [AssessmentAspectController::class, 'store'])->name('aspects.store');
    Route::put('/aspects/{aspect}', [AssessmentAspectController::class, 'update'])->name('aspects.update');
    Route::delete('/aspects/{aspect}', [AssessmentAspectController::class, 'destroy'])->name('aspects.destroy');

    // Kategori Nilai & Performa
    Route::get('/categories', [PerformanceCategoryController::class, 'index'])->name('categories.index');
    Route::put('/categories', [PerformanceCategoryController::class, 'update'])->name('categories.update');

    // Analitik Admin
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Ekspor Excel
    Route::get('/export', [ExportController::class, 'index'])->name('export.index');
    Route::post('/export/download', [ExportController::class, 'export'])->name('export.download');

    // Profil Akun Sendiri
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | Khusus Administrator (Kasta Tertinggi)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:administrator')->group(function () {
        // Manajemen Akun Operator
        Route::get('/operators', [OperatorController::class, 'index'])->name('operators.index');
        Route::get('/operators/create', [OperatorController::class, 'create'])->name('operators.create');
        Route::post('/operators', [OperatorController::class, 'store'])->name('operators.store');
        Route::get('/operators/{operator}/edit', [OperatorController::class, 'edit'])->name('operators.edit');
        Route::put('/operators/{operator}', [OperatorController::class, 'update'])->name('operators.update');
        Route::delete('/operators/{operator}', [OperatorController::class, 'destroy'])->name('operators.destroy');

        // Log Aktivitas / Audit Trail
        Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
        Route::get('/logs/{log}', [ActivityLogController::class, 'show'])->name('logs.show');
    });
});