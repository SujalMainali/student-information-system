<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::middleware('permission:courses.view')->group(function () {
    Route::get('/courses', [CourseController::class, 'index'])->name('index');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('show');
});

Route::middleware('permission:courses.create')->group(function () {
    Route::get('/courses/create', [CourseController::class, 'create'])->name('create');
    Route::post('/courses', [CourseController::class, 'store'])->name('store');
});
Route::middleware('permission:courses.update')->group(function () {
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('update');
});
Route::middleware('permission:courses.delete')->group(function () {
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('destroy');
});
Route::middleware('permission:enrollment-requests.create')->group(function () {
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('enroll');
});
