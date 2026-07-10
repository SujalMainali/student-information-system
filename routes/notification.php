<?php
use App\Http\Controllers\NotificationController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware('permission:notifications.view')->name('index'); 

Route::get('/{notification}', [NotificationController::class, 'show'])->middleware('permission:notifications.view')->name('show');

Route::patch('{notification}/read', [NotificationController::class, 'markAsRead'])->middleware('permission:notifications.mark-read')->name('read');