<?php
use App\Http\Controllers\NotificationController;

use Illuminate\Support\Facades\Route;

Route::middleware('permission:notifications.view')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::get('/{notification}', [NotificationController::class, 'show'])->name('show');
});

Route::middleware('permission:notifications.mark-read')->group(function () {
    Route::patch('{notification}/read', [NotificationController::class, 'markAsRead'])->name('read');
});

Route::middleware('permission:notifications.mark-all-read')->group(function () {
    Route::patch('/read-all', [NotificationController::class, 'markAllRead'])->name('read-all');
});