<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::middleware('throttle:login')->post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showStudentRegisterForm'])->name('register');
    Route::middleware('throttle:register')->post('/register', [AuthController::class, 'registerStudent'])->name('register.submit');

    Route::get('/staff/register', [AuthController::class, 'showStaffRegisterForm'])->name('staff.register');
    Route::middleware('throttle:register')->post('/staff/register', [AuthController::class, 'registerStaff'])->name('staff.submit');

    Route::get('/admin/register', [AuthController::class, 'showAdminRegisterForm'])->name('admin.register');
    Route::middleware('throttle:register')->post('/admin/register', [AuthController::class, 'registerAdmin'])->name('admin.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');