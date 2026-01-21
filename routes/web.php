<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CalonPelangganController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\RiwayatEmailController;
use App\Http\Controllers\JadwalAktivitasController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Auth::routes();


// Semua route di bawah ini memerlukan autentikasi
Route::middleware(['auth'])->group(function () {

    // Dashboard - Accessible by all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management - Admin only
    Route::resource('users', UserController::class);

    // Lead Management - Marketing1 & Admin only
    Route::middleware(['role:admin,marketing1'])->group(function () {
        Route::resource('leads', CalonPelangganController::class);
        Route::patch('leads/{lead}/status', [CalonPelangganController::class, 'updateStatus'])
            ->name('leads.update-status');
    });

    // Contact Management - Marketing2 & Admin only
    Route::middleware(['role:admin,marketing2'])->group(function () {
        Route::resource('pelanggan', PelangganController::class);
    });

    // Email Management - Marketing3 & Admin only
    Route::middleware(['role:admin,marketing3'])->group(function () {
        Route::resource('emails', RiwayatEmailController::class);
    });

    // Calendar & Activities - Marketing4 & Admin only
    Route::middleware(['role:admin,marketing4'])->group(function () {
        Route::resource('aktivitas', JadwalAktivitasController::class);
        Route::patch('aktivitas/{aktivitas}/status', [JadwalAktivitasController::class, 'updateStatus'])
            ->name('aktivitas.update-status');
    });
});
