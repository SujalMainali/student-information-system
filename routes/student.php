<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware('permission:students.restore')->group(function () {
    Route::patch('/students/{student}/restore', [StudentController::class, 'restore'])->withTrashed()->name('restore');
    Route::get('/students/trashed', [StudentController::class, 'trashed'])->name('trashed');
});

Route::middleware('permission:students.view')->group(function () {
    Route::get('/students', [StudentController::class, 'index'])->name('index');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('show');
    Route::get('/students/{student}/courses', [StudentController::class, 'courses'])->name('courses');
});

Route::middleware('permission:students.assign-courses')->group(function () {
    Route::patch('/students/{student}/courses', [StudentController::class, 'updateCourses'])->middleware('permission:students.assign-courses')->name('courses.update');
});

Route::middleware('permission:students.create')->group(function () {
    Route::get('/students/create', [StudentController::class, 'create'])->name('create');
    Route::post('/students', [StudentController::class, 'store'])->name('store');
});

Route::middleware('permission:students.update')->group(function () {
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('update');
});

Route::middleware('permission:students.delete')->group(function () {
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('archieve');
    Route::delete('/students/{student}/force', [StudentController::class, 'forceDestroy'])->withTrashed()->name('force-destroy');
});