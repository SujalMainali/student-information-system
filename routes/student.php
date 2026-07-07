<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/students', [StudentController::class, 'index'])->middleware('role:admin,staff')->name('index');
Route::get('/students/create', [StudentController::class, 'create'])->middleware('role:admin')->name('create');
Route::post('/students', [StudentController::class, 'store'])->middleware('role:admin')->name('store');
Route::get('/students/{student}', [StudentController::class, 'show'])->name('show');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('edit');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('update');
Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('destroy');
Route::get('/students/{student}/courses', [StudentController::class, 'courses'])->middleware('role:admin')->name('courses');
Route::patch('/students/{student}/courses', [StudentController::class, 'updateCourses'])->middleware('role:admin')->name('courses.update');
