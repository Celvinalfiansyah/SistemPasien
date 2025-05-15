<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DaftarPasienController;

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
// Route::resource('daftar-pasien', PasienController::class);

Route::resource('pasien', PasienController::class);
Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');
Route::resource('daftar-pasien', DaftarPasienController::class);
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


