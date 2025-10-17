<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DaftarPasienController;
<<<<<<< HEAD
use App\Http\Controllers\PasienController;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    return redirect('/dashboard');
=======
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\RekamMedisRawatJalanController;
use App\Http\Controllers\RekamMedisBayiAnakController;
use App\Http\Controllers\RekamMedisKbController;
use App\Http\Controllers\Auth\LoginController;

// Route untuk autentikasi (login dan logout)
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
>>>>>>> 79b4b19c5a7c91e4699dc0a34cfcca96b8bb1cda
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

<<<<<<< HEAD

<<<<<<< HEAD
Route::resource('daftar-pasien', DaftarPasienController::class)
     ->parameters(['daftar-pasien' => 'pasien']);
// Route::resource('daftar-pasien', PasienController::class);

Route::resource('pasien', PasienController::class);
Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');

// Route::get('/daftar-pasien', function () {
//     return view('daftar_pasien.index');
// })->name('daftar.pasien');
// Route::get('/daftar-pasien/create', function () {
//     return view('daftar_pasien.create');
// })->name('pasien.create');


// Route::resource('pasien', PasienController::class);
// Route::resource('daftar-pasien', PasienController::class);
// Route::get('/daftar-pasien', [PasienController::class, 'index'])->name('daftar.pasien');
// Route::get('/daftar-pasien/create', [PasienController::class, 'create'])->name('pasien.create');
// Route::post('/daftar-pasien', [PasienController::class, 'store'])->name('pasien.store');
// Route::get('/daftar-pasien/{id}/edit', [PasienController::class, 'edit'])->name('pasien.edit');
// Route::put('/daftar-pasien/{id}', [PasienController::class, 'update'])->name('pasien.update');
// Route::delete('/daftar-pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');


=======
=======
>>>>>>> 2f5cf8d9d2b8875d2e7903ebddc691a7b01a5853
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
<<<<<<< HEAD
>>>>>>> 79b4b19c5a7c91e4699dc0a34cfcca96b8bb1cda
=======
>>>>>>> 2f5cf8d9d2b8875d2e7903ebddc691a7b01a5853
