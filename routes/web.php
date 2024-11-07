<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DaiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return to_route('dai.index');
});



Route::get('/admin/dashboard',[DashboardController::class,'index'])->middleware('auth')->name('admin.dashboard');


Route::get('/login',[loginController::class,'index'])->name('login');
Route::post('/login',[loginController::class,'submit'])->name('login.submit');
Route::get('/logout',[loginController::class,'logout'])->middleware('auth')->name('logout');



Route::get('/register',[UserController::class,'index'])->name('register');
Route::post('/register',[UserController::class,'store'])->name('register.store');



Route::controller(DaiController::class)->group(function(){
    Route::get('/admin/dai', 'index')->middleware('auth')->name('dai.index');
    Route::get('/admin/dai/create', 'create')->name('dai.create');
    Route::post('/admin/dai/create', 'store')->name('dai.store');
    Route::get('/admin/dai/{dai}/edit', 'edit')->name('dai.edit');
    Route::get('/admin/dai/{dai}/show', 'show')->name('dai.show');
    Route::put('/admin/dai/{dai}/edit', 'update')->name('dai.update');
    Route::delete('/admin/dai/{dai}/destroy', 'destroy')->name('dai.destroy');
});

Route::controller(ReportController::class)->group(function(){
    Route::get('/admin/report', 'index')->middleware('auth')->name('report.index');
    Route::get('/admin/report/{report}/edit', 'edit')->name('report.edit');
    Route::get('/admin/report/{report}/show', 'show')->name('report.show');
    Route::put('/admin/report/{report}/edit', 'update')->name('report.update');
    Route::delete('/admin/report/{report}/destroy', 'destroy')->name('report.destroy');
});