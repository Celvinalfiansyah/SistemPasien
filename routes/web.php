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

Route::resource('pasien.rekam-medi  s', RekamMedisController::class);

