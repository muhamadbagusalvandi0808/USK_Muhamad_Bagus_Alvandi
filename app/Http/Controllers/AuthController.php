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

        // Cek Credentials ke database (Auth::attempt otomatis, mencocokan otomatis password yang di-hash)
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
    


    public function showRegister()
    {
        return view('auth.register');
    }

    
    public function register(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // butuh input konfirmasi password
        ], [
            'name.required' => 'Nama lengkap wajib diisi!',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain!',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal harus 6 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
        ]);

        
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user', 
        ]);

        
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login menggunakan akun Anda.');
    }
}
