<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DaftarPasienController;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // logika autentikasi dummy
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('/', DaftarPasienController::class);
Route::get('daftar-pasien', function () {
    return redirect('/daftar-pasien');
});