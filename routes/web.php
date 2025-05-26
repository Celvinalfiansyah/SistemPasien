<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DaftarPasienController;
use App\Http\Controllers\RekamMedisController;


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('daftar-pasien', DaftarPasienController::class)
     ->parameters(['daftar-pasien' => 'pasien']);

     Route::prefix('pasien/{pasien}')->group(function () {
        Route::resource('rekam-medis', RekamMedisController::class);
    });

    Route::resource('daftar-pasien.rekam-medis', RekamMedisController::class)->shallow();

Route::resource('pasien.rekam-medis', RekamMedisController::class);
Route::get('/daftar_pasien/{id}', [DaftarPasienController::class, 'show'])->name('daftar_pasien.show');
Route::get('daftar-pasien/{pasien}/rekam-medis/{rekam_medis}/edit', [RekamMedisController::class, 'edit'])->name('pasien.rekam-medis.edit');
Route::put('daftar-pasien/{pasien}/rekam-medis/{rekam_medis}', [RekamMedisController::class, 'update'])->name('pasien.rekam-medis.update');
Route::delete('daftar-pasien/{pasien}/rekam-medis/{rekam_medis}', [DaftarPasienController::class, 'destroyRekamMedis'])->name('daftar-pasien.rekam-medis.destroy');