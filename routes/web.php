<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard — overview saja, tanpa logika pencarian
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Halaman form analisis (baru)
    Route::get('/analysis', [DashboardController::class, 'analysisForm'])
        ->name('analysis.form');

    // Hasil rekomendasi — ini yang dulu /getRecommendation, TIDAK DIUBAH logikanya
    Route::get('/getRecommendation', [DashboardController::class, 'getRecommendation'])
        ->name('recommendation');

    // Daftar karir (baru)
    Route::get('/careers', [DashboardController::class, 'careers'])
        ->name('careers.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/jalankan-migrasi-rahasia', function () {
    try {
        // Menyuruh Laravel menjalankan php artisan migrate --force secara internal
        Artisan::call('migrate', ['--force' => true]);
        
        return '<h1>Sihir Berhasil! ✨</h1><pre>' . Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return '<h1>Waduh Gagal:</h1><pre>' . $e->getMessage() . '</pre>';
    }
});

require __DIR__.'/auth.php';