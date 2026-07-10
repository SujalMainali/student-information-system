<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->middleware(['web', 'auth','permission:dashboard.view'])->name('dashboard');

Route::get('/manage', function () {
    return view('manage');
})->middleware(['web', 'auth','permission:manage.view'])->name('manage');

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/me', [UserController::class, 'show'])->name('me.show');
    Route::get('/me/courses', [UserController::class, 'get_courses'])->name('me.courses');
});

