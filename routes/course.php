<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('/courses', [CourseController::class, 'index'])->name('index');
Route::get('/courses/create', [CourseController::class, 'create'])->middleware('role:admin')->name('create');
Route::post('/courses', [CourseController::class, 'store'])->middleware('role:admin')->name('store');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('show');
Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->middleware('role:admin')->name('edit');
Route::put('/courses/{course}', [CourseController::class, 'update'])->middleware('role:admin')->name('update');
Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->middleware('role:admin')->name('destroy');
Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->middleware('role:student')->name('enroll');
