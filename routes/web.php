<?php

use App\Models\Student;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AssessmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicStudentController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Public

Route::get('/', function () {
    $totalStudents = Student::count();

    $activeStudents = Student::where('status', 'active')->count();

    return view('welcome', [
        'totalStudents' => $totalStudents,
        'activeStudents' => $activeStudents,
    ]);
})->name('home');


Route::get(
    '/students',
    [PublicStudentController::class, 'index']
)->name('students.index');

Route::get(
    '/students/{student}',
    [PublicStudentController::class, 'show']
)->name('students.show');

// Admin

Route::middleware('admin')->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard.page');

    Route::get('/students', [AdminStudentController::class, 'index'])
        ->name('admin.students.index');

    Route::get('/students/create', [AdminStudentController::class, 'create'])
        ->name('admin.students.create');

    Route::post('/students', [AdminStudentController::class, 'store'])
        ->name('admin.students.store');

    Route::get('/students/{student}/edit', [AdminStudentController::class, 'edit'])
        ->name('admin.students.edit');

    Route::put('/students/{student}', [AdminStudentController::class, 'update'])
        ->name('admin.students.update');

    Route::delete('/students/{student}', [AdminStudentController::class, 'destroy'])
        ->name('admin.students.destroy');

    Route::get('/assessments', [AssessmentController::class, 'index'])
        ->name('admin.assessments.index');

    Route::get('/assessments/create', [AssessmentController::class, 'create'])
        ->name('admin.assessments.create');

    Route::post('/assessments', [AssessmentController::class, 'store'])
        ->name('admin.assessments.store');

    Route::get('/assessments/{assessment}/edit', [AssessmentController::class, 'edit'])
        ->name('admin.assessments.edit');

    Route::put('/assessments/{assessment}', [AssessmentController::class, 'update'])
        ->name('admin.assessments.update');

    Route::delete('/assessments/{assessment}', [AssessmentController::class, 'destroy'])
        ->name('admin.assessments.destroy');

    Route::get('/analytics', [AnalyticsController::class, 'index'])
        ->name('admin.analytics.index');
    
    Route::get('/analytics/students/{student}', [AnalyticsController::class, 'student'])
        ->name('admin.analytics.student');
});

// Admin Auth

Route::get('/admin/login', [AdminController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AdminController::class, 'logout'])
    ->name('admin.logout');