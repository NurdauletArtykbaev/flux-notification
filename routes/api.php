<?php

use Raim\FluxNotify\Http\Controllers\DeviceTokenController;
use Raim\FluxNotify\Http\Controllers\NotificationController;
use Raim\FluxNotify\Http\Controllers\NotificationTypeController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function(){
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('device-token', [DeviceTokenController::class, 'store']);
        Route::delete('device-token', [DeviceTokenController::class, 'delete']);

        Route::group(['prefix' => 'notifications'], function () {
//            Route::get('', [NotificationController::class, 'getNotifications']);
            Route::get('unread', [NotificationController::class, 'getUnread']);
            Route::get('{slug}', [NotificationController::class, 'getUserNotifications']);
            Route::post('{slug}/unread', [NotificationController::class, 'updateUnread']);
            Route::delete('{id}', [NotificationController::class, 'destroy']);
        });
    });

    Route::apiResource('notification-types', NotificationTypeController::class)->only(['index']);
});