<?php

use App\Http\Controllers\ApiReportController;
use App\Http\Controllers\ApiLoginController;

Route::apiResource('reports', ApiReportController::class);
Route::post('login',[ApiLoginController::class,'store']);

// Route::get('reports', [ApiReportController::class, 'index']);
// Route::post('reports', [ApiReportController::class, 'store']);
// Route::get('reports/{id}', [ApiReportController::class, 'show']);
// Route::put('reports/{id}', [ApiReportController::class, 'update']);
// Route::delete('reports/{id}', [ApiReportController::class, 'destroy']);

