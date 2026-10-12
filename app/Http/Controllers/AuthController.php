<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Ini untuk menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // memproses login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required', 
        ], [
            'email.required' => 'Email wajib Diisi!!',
            'email.email'    => 'Format email tidak Valid!!',
            'password.required' => 'Password Wajib Diisi!!'

        ]);

        // Cek Credentials ke database (Auth::attempt otomatis mencocokan otomatis password yang di-hash)
        if(Auth::attempt($credentials)){
            $request ->session()->regenerate();

            return redirect()->intended('/dashboard')->with('success', 'Berhasil Login!');
        }

        // Jika Login gagal (Akses ditolak dan tampil pesan)
        return back()->withErrors([
            'email' => 'Email Atau Password yang anda masukan salah.',
        ])->onlyInput('email');
    }

    // 3.Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda Berhasil Keluar.');
    }
}
