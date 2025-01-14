<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DaiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KecamatanController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\PasswordController;


Route::get('/', function () {
    return to_route('dai.index');
});
Route::get('/data-migrate', function () {
    Artisan::call('migrate');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/admin/dashboard',[DashboardController::class,'index'])->middleware('auth')->name('admin.dashboard');

Route::get('/login',[AuthController::class,'index'])->name('login');
Route::post('/login',[AuthController::class,'submit'])->name('login.submit');
Route::get('/logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');

Route::controller(PasswordController::class)->group(function(){
    Route::middleware('auth')->group(function() {
        Route::get('/change-password','changePage')->name('password.change');
        Route::post('/change-password','changePassword')->name('password.confirmed');
    });
    
    Route::middleware('guest')->group(function() {
        Route::get('/forgot-password', 'forgotPage')->name('password.request');
        Route::post('/forgot-password', 'forgotPassword')->name('password.email');
        Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
        Route::post('/reset-password', 'resetPassword')->name('password.update');
    });
});

Route::controller(DaiController::class)->middleware('auth')->group(function(){
    Route::get('/admin/dai', 'index')->name('dai.index');
    Route::get('/admin/dai/create', 'create')->name('dai.create');
    Route::post('/admin/dai/create', 'store')->name('dai.store');
    Route::get('/admin/dai/{dai}/edit', 'edit')->name('dai.edit');
    Route::get('/admin/dai/{dai}/show', 'show')->name('dai.show');
    Route::put('/admin/dai/{dai}/edit', 'update')->name('dai.update');
    Route::delete('/admin/dai/{dai}/destroy', 'destroy')->name('dai.destroy');
});

Route::controller(DesaController::class)->middleware('auth')->group(function(){
    Route::get('/admin/desa', 'index')->name('desa.index');
    Route::get('/admin/desa/create', 'create')->name('desa.create');
    Route::post('/admin/desa/create', 'store')->name('desa.store');
    Route::get('/admin/desa/{desa}/edit', 'edit')->name('desa.edit');
    Route::get('/admin/desa/{desa}/show', 'show')->name('desa.show');
    Route::put('/admin/desa/{desa}/edit', 'update')->name('desa.update');
    Route::delete('/admin/desa/{desa}/destroy', 'destroy')->name('desa.destroy');
});

Route::controller(KecamatanController::class)->middleware('auth')->group(function(){
    Route::get('/admin/kecamatan','index')->name('kecamatan.index');
    Route::get('/admin/kecamatan/create', 'create')->name('kecamatan.create');
    Route::post('/admin/kecamatan/create', 'store')->name('kecamatan.store');
});

Route::controller(ReportController::class)->middleware('auth')->group(function(){
    Route::get('/admin/report', 'index')->name('reports.index');
    Route::get('/admin/report/{id}/edit', 'edit')->name('reports.edit');
    Route::get('/admin/report/{id}/show', 'show')->name('reports.show');
    Route::put('/admin/report/{id}/edit', 'update')->name('reports.update');
    Route::delete('/admin/report/{id}/destroy', 'destroy')->name('reports.destroy');
    // Desa
    Route::post('admin/reports/{id}/approve/desa', 'desaApprove')->name('reports.desa.approve');
    Route::post('admin/reports/{id}/reject/desa', 'desaReject')->name('reports.desa.reject');
    Route::get('admin/reports/{id}/approve/comment/desa', 'desaApproveCommentGet')->name('reports.desa.approve.comment.get');
    Route::post('admin/reports/{id}/approve/comment/desa', 'desaApproveCommentPost')->name('reports.desa.approve.comment.post');
    Route::get('admin/reports/{id}/comment/desa','desaRejectCommentGet')->name('reports.desa.comment.get');
    Route::post('admin/reports/{id}/comment/desa','desaRejectCommentPost')->name('reports.desa.comment.post');
    // Kecamatan
    Route::post('admin/reports/{id}/approve/kecamatan', 'kecamatanApprove')->name('reports.kecamatan.approve');
    Route::post('admin/reports/{id}/reject/kecamatan', 'kecamatanReject')->name('reports.kecamatan.reject');
    Route::get('admin/reports/{id}/approve/comment/kecamatan', 'kecamatanApproveCommentGet')->name('reports.kecamatan.approve.comment.get');
    Route::post('admin/reports/{id}/approve/comment/kecamatan', 'kecamatanApproveCommentPost')->name('reports.kecamatan.approve.comment.post');
    Route::get('admin/reports/{id}/comment/kecamatan','kecamatanRejectCommentGet')->name('reports.kecamatan.comment.get');
    Route::post('admin/reports/{id}/comment/kecamatan','kecamatanRejectCommentPost')->name('reports.kecamatan.comment.post');
    // PDF
    Route::get('/reports/{id}/download/pdf',  'downloadPDF')->name('reports.download');
    Route::get('/reports/week/pdf', 'weekRecapPDF')->name('reports.week');
    Route::get('/reports/month/pdf', 'monthRecapPDF')->name('reports.month');
});
