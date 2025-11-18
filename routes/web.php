<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\AdminAntrianController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', [AntrianController::class, 'create'])->name('antrian.form');
Route::post('/daftar', [AntrianController::class, 'store'])->name('antrian.store');

Route::get('/cek-antrian', [AntrianController::class, 'cekForm'])->name('antrian.cek.form');
Route::post('/cek-antrian', [AntrianController::class, 'cek'])->name('antrian.cek');

Route::get('/login', [AuthController::class, 'showloginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.attempt')
    ->middleware('guest');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');
// Route::middleware(['auth', 'isAdmin'])->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
//     Route::resource('poli', PoliController::class);
//     Route::resource('antrian', AdminAntrianController::class);
// });
Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // dashboard bisa nanti kamu bikin, sementara redirect ke antrian
         Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // antrian
        Route::get('/antrian', [AdminAntrianController::class, 'index'])->name('antrian.index');
        Route::post('/antrian/{antrian}/panggil', [AdminAntrianController::class, 'panggil'])->name('antrian.panggil');
        Route::post('/antrian/{antrian}/selesai', [AdminAntrianController::class, 'selesai'])->name('antrian.selesai');
        Route::resource('poli', PoliController::class);
    });
