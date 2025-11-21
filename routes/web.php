<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DaftarPasienController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\RekamMedisRawatJalanController;
use App\Http\Controllers\RekamMedisBayiAnakController;
use App\Http\Controllers\RekamMedisKbController;
use App\Http\Controllers\Auth\LoginController;

// Route untuk autentikasi (login dan logout)
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Akses data pasien (untuk semua user yang sudah login)
    Route::resource('daftar-pasien', DaftarPasienController::class)
        ->parameters(['daftar-pasien' => 'pasien']);

    // Route khusus untuk bidan
    Route::middleware('role:bidan')->group(function () {
        // Cetak rekam medis umum
        Route::get('/pasien/{id}/rekam-medis/cetak', [RekamMedisController::class, 'cetak'])
            ->name('rekam-medis.cetak');

        // ============================
        //  ROUTE REKAM MEDIS KHUSUS
        // ============================
        // Rawat Jalan
        Route::resource('pasien.rekam-medis-rawat-jalan', RekamMedisRawatJalanController::class)
            ->parameters(['rekam-medis-rawat-jalan' => 'rekam_medis_rawat_jalan']);

        // Bayi / Anak
        Route::resource('pasien.rekam-medis-bayi-anak', RekamMedisBayiAnakController::class)
            ->parameters(['rekam-medis-bayi-anak' => 'rekam_medis_bayi_anak']);

        // KB
        Route::resource('pasien.rekam-medis-kb', RekamMedisKbController::class)
            ->parameters(['rekam-medis-kb' => 'rekam_medis_kb']);

        // Masih pertahankan rekam medis lama (jika ada data terdahulu)
        Route::resource('pasien.rekam-medis', RekamMedisController::class)
            ->parameters(['rekam-medis' => 'rekam_medis']);
    });
});
//