<?php

use App\Http\Controllers\ApiReportController;
use App\Http\Controllers\ApiLoginController;
use Illuminate\Http\Request;

Route::post('loginAPI',[ApiLoginController::class,'loginAPI']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logoutAPI', [ApiLoginController::class, 'logoutAPI']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('reportsAPI', ApiReportController::class);
});
