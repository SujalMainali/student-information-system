<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->middleware(['web', 'auth'])->name('dashboard');

Route::get('/manage', function () {
    return view('manage');
})->middleware(['web', 'auth','role:admin,staff'])->name('manage');

Route::get('/me', [UserController::class, 'show'])
    ->middleware(['web', 'auth'])
    ->name('me.show');
