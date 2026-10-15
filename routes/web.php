<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SkemaController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::put('/peserta/{id}/status', [App\Http\Controllers\PesertaController::class, 'updateStatus'])->name('peserta.updateStatus')->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/peserta/{id}/verifikasi', [PesertaController::class, 'verifikasi'])->name('peserta.verifikasi');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route Skema (udah Aman karena pengamannya sudah dipasang didalam SkemaController melalui konstruktor atau di filter langsung di Controller)
    Route::resource('skema', SkemaController::class);

    Route::resource('peserta', PesertaController::class);
});