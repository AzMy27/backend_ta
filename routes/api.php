<?php

use App\Http\Controllers\ApiReportController;
use App\Http\Controllers\ApiLoginController;
use Illuminate\Http\Request;

Route::post('login',[ApiLoginController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [ApiLoginController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('reports', ApiReportController::class);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
//     Route::post('logout', [ApiLoginController::class, 'logout']);
// });

// Route::apiResource('reports', ApiReportController::class);  

