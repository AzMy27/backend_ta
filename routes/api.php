<?php

use App\Http\Controllers\ApiReportController;
use App\Http\Controllers\ApiLoginController;
use App\Http\Controllers\ApiDaiController;
use Illuminate\Http\Request;


    Route::post('reportsAPI', [ApiReportController::class, 'store']);

Route::post('loginAPI',[ApiLoginController::class,'loginAPI']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logoutAPI', [ApiLoginController::class, 'logoutAPI']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('reportsAPI', [ApiReportController::class, 'index']);
    Route::get('reportsAPI/{id}', [ApiReportController::class, 'show']);
    Route::put('reportsAPI/{id}', [ApiReportController::class, 'update']);
    Route::delete('reportsAPI/{id}', [ApiReportController::class, 'destroy']);
    Route::get('daiAPI/{id}', [ApiDaiController::class, 'show']);
});
