<?php
use App\Http\Controllers\NotificationController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('/{notification}', [NotificationController::class, 'show'])->name('show');

Route::patch('{notification}/read', [NotificationController::class, 'markAsRead'])->name('read');