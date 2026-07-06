<?php

use Illuminate\Http\Request;

use App\Http\Controllers\ApiController;

use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;

Route::post('/login', [ApiController::class, 'login'])->middleware('throttle:login');
Route::post('/logout', [ApiController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::middleware('role:admin')->get('/courses', [CourseController::class, 'index'])->name('index');
    Route::middleware('role:admin')->get('/courses/{course}', [CourseController::class, 'show'])->name('show');
    Route::middleware('role:admin')->post('/courses', [CourseController::class, 'store'])->name('store');
    Route::middleware('role:admin')->put('/courses/{course}', [CourseController::class, 'update'])->name('update');
    Route::middleware('role:admin')->delete('/courses/{course}', [CourseController::class, 'destroy'])->name('destroy');

    Route::middleware('role:admin,staff')->get('/students', [StudentController::class, 'index'])->name('index');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('show');
    Route::middleware('role:admin')->delete('/students/{student}', [StudentController::class, 'destroy'])->name('destroy');
    Route::middleware('role:admin,staff')->put('/students/{student}', [StudentController::class, 'update'])->name('update');
    Route::middleware('role:admin,staff')->post('/students', [StudentController::class, 'store'])->name('store');

    Route::get('/user', function (Request $request) {
        return response()->json([
            'user' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'role' => $request->user()->role ?? null,
            ],
        ]);
    });
    
});