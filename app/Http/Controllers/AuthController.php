<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function showLogin()
    {
        return view('auth.login');
    }

   public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required', 
        ], [
            'email.required'    => 'Email wajib Diisi!!',
            'email.email'       => 'Format email tidak Valid!!',
            'password.required' => 'Password Wajib Diisi!!'
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Akun ini tidak terdaftar dalam sistem.',
            ])->withInput();
        }

        if ($user->role !== 'admin') {
            $peserta = \App\Models\Peserta::where('email', $user->email)->first();
            
            if ($peserta && $peserta->status_verifikasi !== 'approved') {
                return back()->withErrors([
                    'email' => 'Akun Anda belum diverifikasi oleh Admin. Silakan menunggu proses verifikasi dokumen selesai.',
                ])->withInput();
            }
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Berhasil Login!');
        }

        return back()->withErrors([
            'email' => 'Email Atau Password yang anda masukan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda Berhasil Keluar.');
    }
    


    public function showRegister()
    {
        $skemas = \App\Models\Skema::all();
        return view('auth.register', compact('skemas'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'nik'      => 'required|string|max:20|unique:pesertas,nik',
            'nis'      => 'required|string|max:10|unique:pesertas,nis',
            'skema_id' => 'required|exists:skemas,id',
            'jk'       => 'required|in:Laki-laki,Perempuan',
            'telp'     => 'required|string|max:15',
            'alamat'   => 'required|string',
            'ktp'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'ijazah'   => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ], [
            'name.required'     => 'Nama lengkap wajib diisi!',
            'email.unique'      => 'Email sudah terdaftar!',
            'nik.unique'        => 'NIK sudah terdaftar!',
            'nis.unique'        => 'NIS sudah terdaftar!',
            'skema_id.required' => 'Pilih skema sertifikasi terlebih dahulu!',
            'ktp.required'      => 'Foto KTP wajib diunggah!',
            'ijazah.required'   => 'Scan/Foto Ijazah wajib diunggah!',
        ]);

        $ktpPath = $request->file('ktp')->store('dokumen/ktp', 'public');
        $ijazahPath = $request->file('ijazah')->store('dokumen/ijazah', 'public');

        $user = \App\Models\User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'user', 
        ]);

        \App\Models\Peserta::create([
            'nama'              => $request->name,
            'email'             => $request->email,
            'nik'               => $request->nik,
            'nis'               => $request->nis,
            'skema_id'          => $request->skema_id,
            'jk'                => $request->jk,
            'telp'              => $request->telp,
            'alamat'            => $request->alamat,
            'ktp'               => $ktpPath,
            'ijazah'            => $ijazahPath,
            'status_verifikasi' => 'pending', 
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Data dan dokumen Anda sedang dalam proses verifikasi oleh Admin.');
    }
}
