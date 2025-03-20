<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::post('store-device-token', [NotificationController::class, 'storeDeviceToken']);
Route::post('send-notification', [NotificationController::class, 'sendNotification']);
Route::post('send-notification-to-all-users', [NotificationController::class, 'sendNotificationToAllUsers']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-mobile', [AuthController::class, 'verifyMobile']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['jwt.verify', 'jwt.auth'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/delivery/nearby', [DeliveryController::class, 'getNearbyDeliveryReps']);

});
