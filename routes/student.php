<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware('permission:students.view')->group(function () {
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/{student}/courses', [StudentController::class, 'courses'])->name('students.courses');
});

Route::middleware('permission:students.assign-courses')->group(function () {
    Route::patch('/students/{student}/courses', [StudentController::class, 'updateCourses'])->middleware('permission:students.assign-courses')->name('courses.update');
});

Route::middleware('permission:students.create')->group(function () {
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
});

Route::middleware('permission:students.update')->group(function () {
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
});

Route::middleware('permission:students.delete')->group(function () {
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
});