<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SkemaController;
use Illuminate\Support\Facades\Route;

// 1. Halaman Welcome (Pertama kali dibuka)
Route::get('/', function () {
    return view('welcome');
});

// 2. Route Guest (Hanya untuk yang belum login: Login & Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 3. Route Auth (Hanya untuk yang sudah login)
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route Skema (Aman karena pengamannya sudah kita pasang di dalam SkemaController melalui konstruktor atau kita filter langsung di Controller)
    Route::resource('skema', SkemaController::class);

    // Route Peserta
    Route::resource('peserta', PesertaController::class);
});