<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('/courses', [CourseController::class, 'index'])->name('index');
Route::get('/courses/create', [CourseController::class, 'create'])->name('create');
Route::post('/courses', [CourseController::class, 'store'])->name('store');
Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('edit');
Route::put('/courses/{course}', [CourseController::class, 'update'])->name('update');
Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('destroy');
