<?php

use App\Http\Controllers\ApiReportController;
use App\Http\Controllers\ApiReportsController;
use App\Http\Controllers\ApiLoginController;
use App\Http\Controllers\ApiDaiController;
use App\Http\Controllers\FCMTokenController;
use Illuminate\Http\Request;

Route::post('loginAPI',[ApiLoginController::class,'loginAPI'])->middleware('throttle:5,1');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('reportGet',[ApiReportsController::class,'index']);
    Route::post('reportPost',[ApiReportsController::class,'store']);
    Route::get('reportShow/{report}',[ApiReportsController::class,'show']);
    Route::post('reportPut/{report}',[ApiReportsController::class,'update']);
    Route::get('daiShow',[ApiDaiController::class,'show']);
    Route::post('daiUpdate',[ApiDaiController::class,'update']);
    Route::post('logoutAPI', [ApiLoginController::class, 'logoutAPI']);
    Route::post('saveToken',[FCMTokenController::class, 'saveFirebaseToken']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});