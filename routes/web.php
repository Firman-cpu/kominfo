<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Public

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students', [StudentController::class, 'index'])
    ->name('students.index');

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
});

// Admin Auth

Route::get('/admin/login', [AdminController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AdminController::class, 'logout'])
    ->name('admin.logout');