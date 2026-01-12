<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalonPelangganController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\RiwayatEmailController;
use App\Http\Controllers\JadwalAktivitasController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Lead Management - Marketing1
    Route::middleware(['role:marketing1'])->group(function () {
        Route::resource('leads', CalonPelangganController::class);
        Route::patch('leads/{lead}/status', [CalonPelangganController::class, 'updateStatus'])
            ->name('leads.update-status');
    });

    // Contact Management - Marketing2
    Route::middleware(['role:marketing2'])->group(function () {
        Route::resource('pelanggan', PelangganController::class);
    });

    // Email Management - Marketing3
    Route::middleware(['role:marketing3'])->group(function () {
        Route::resource('emails', RiwayatEmailController::class);
    });

    // Calendar & Activities - Marketing4
    Route::middleware(['role:marketing4'])->group(function () {
        Route::resource('aktivitas', JadwalAktivitasController::class);
        Route::patch('aktivitas/{aktivitas}/status', [JadwalAktivitasController::class, 'updateStatus'])
            ->name('aktivitas.update-status');
    });
});
