<?php

use App\Http\Controllers\ApiReportController;
use App\Http\Controllers\ApiReportsController;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiDaiController;
use App\Http\Controllers\ApiPasswordController;
use App\Http\Controllers\FCMTokenController;
use Illuminate\Http\Request;

Route::post('loginAPI',[ApiAuthController::class,'loginAPI'])->middleware('throttle:5,1');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('reportGet',[ApiReportsController::class,'index']);
    Route::post('reportPost',[ApiReportsController::class,'store']);
    Route::get('reportShow/{report}',[ApiReportsController::class,'show']);
    Route::post('reportPut/{report}',[ApiReportsController::class,'update']);
    Route::get('daiShow',[ApiDaiController::class,'show']);
    Route::post('daiUpdate',[ApiDaiController::class,'update']);
    Route::post('logoutAPI', [ApiAuthController::class, 'logoutAPI']);
    Route::post('changePassword',[ApiPasswordController::class,'changePassword']);
    Route::post('forgotPassword', [ApiAuthController::class, 'forgotPassword']);
    Route::post('resetPassword', [ApiAuthController::class, 'resetPassword']);
    Route::post('saveToken',[FCMTokenController::class, 'saveFirebaseToken']);
});