<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalonPelangganController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\RiwayatEmailController;
use App\Http\Controllers\JadwalAktivitasController;
use App\Helpers\EmailHelper;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Auth::routes();

// ============================================
// DEBUG ROUTES - Only for development
// ============================================
if (config('app.debug')) {
    Route::get('/test-email-config', function () {
        return response()->json(EmailHelper::getEmailConfig(), 200, [], JSON_PRETTY_PRINT);
    })->name('test-email-config');

    Route::get('/test-smtp-connection', function () {
        $result = EmailHelper::testSmtpConnection();
        return response()->json($result, $result['status'] === 'SUCCESS' ? 200 : 500, [], JSON_PRETTY_PRINT);
    })->name('test-smtp-connection');

    Route::get('/test-send-email/{email}', function ($email) {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => 'FAILED',
                'error' => 'Invalid email address format'
            ], 400, [], JSON_PRETTY_PRINT);
        }

        $result = EmailHelper::sendTestEmail(
            $email,
            'Test Email dari CRM System',
            'Ini adalah test email untuk memverifikasi konfigurasi SMTP Anda. Jika email ini sampai, maka SMTP berhasil dikonfigurasi dengan benar!'
        );

        return response()->json($result, $result['status'] === 'SUCCESS' ? 200 : 500, [], JSON_PRETTY_PRINT);
    })->name('test-send-email');

    // Additional debug info
    Route::get('/debug-mail', function () {
        $config = EmailHelper::getEmailConfig();
        $smtpTest = EmailHelper::testSmtpConnection();

        return response()->json([
            'mail_driver' => config('mail.mailer'),
            'mail_from' => config('mail.from'),
            'configuration' => $config,
            'smtp_test' => $smtpTest,
            'debug_mode' => config('app.debug'),
            'log_file' => 'storage/logs/laravel.log',
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    })->name('debug-mail');
}

// Semua route di bawah ini memerlukan autentikasi
Route::middleware(['auth'])->group(function () {

    // Dashboard - Accessible by all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
        Route::post('emails/{email}/send', [RiwayatEmailController::class, 'send'])
            ->name('emails.send');
    });

    // Calendar & Activities - Marketing4 & Admin only
    Route::middleware(['role:admin,marketing4'])->group(function () {
        Route::resource('aktivitas', JadwalAktivitasController::class);
        Route::patch('aktivitas/{aktivitas}/status', [JadwalAktivitasController::class, 'updateStatus'])
            ->name('aktivitas.update-status');
    });
});
