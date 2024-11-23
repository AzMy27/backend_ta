<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DaiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DesaController;

Route::get('/', function () {
    return to_route('dai.index');
});

Route::get('/admin/dashboard',[DashboardController::class,'index'])->middleware('auth')->name('admin.dashboard');

Route::get('/login',[loginController::class,'index'])->name('login');
Route::post('/login',[loginController::class,'submit'])->name('login.submit');
Route::get('/logout',[loginController::class,'logout'])->middleware('auth')->name('logout');

Route::get('/register',[UserController::class,'index'])->name('register');
Route::post('/register',[UserController::class,'store'])->name('register.store');
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

Route::controller(ReportController::class)->middleware('auth')->group(function(){
    Route::get('/admin/report', 'index')->name('reports.index');
    Route::get('/admin/report/{laporan}/edit', 'edit')->name('reports.edit');
    Route::get('/admin/report/{laporan}/show', 'show')->name('reports.show');
    Route::put('/admin/report/{laporan}/edit', 'update')->name('reports.update');
    Route::delete('/admin/report/{laporan}/destroy', 'destroy')->name('reports.destroy');
});

Route::get('/reports/{id}/download', [ReportController::class, 'downloadPDF'])->name('reports.download');
