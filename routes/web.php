<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SkemaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware('guest')->group(function(){
    Route::get('/login',[AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware('auth')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard',function(){
        return view('dashboard');
    })->name('dashboard');

// Route peserta dan skema
Route::resource('skema', SkemaController::class);
Route::resource('peserta', PesertaController::class);
});
