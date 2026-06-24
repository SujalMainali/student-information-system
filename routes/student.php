<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/students', [StudentController::class, 'index'])->name('index');
Route::get('/students/create', [StudentController::class, 'create'])->name('create');
Route::post('/students', [StudentController::class, 'store'])->name('store');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('edit');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('update');
Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('destroy');
Route::get('/students/{student}/courses', [StudentController::class, 'courses'])->name('courses');
Route::patch('/students/{student}/courses', [StudentController::class, 'updateCourses'])->name('courses.update');
