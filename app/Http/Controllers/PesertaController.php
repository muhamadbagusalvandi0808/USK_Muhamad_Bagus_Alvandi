<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user = Auth::user();

        // Query dasar dengan relasi skema
        $query = Peserta::with('skema');

        // Jika yang login BUKAN admin, filter hanya data miliknya sendiri berdasarkan email
        if ($user->role !== 'admin') {
            $query->where('email', $user->email);
        }

        // Fitur Pencarian Nama Peserta & Filter Pagination
        $pesertas = $query->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                             ->orWhere('no_peserta', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('peserta.index', compact('pesertas', 'search'));
    }

    public function create()
    {
        // HANYA ADMIN yang boleh mengakses form tambah peserta
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Admin yang dapat menambah data peserta.');
        }

        $skemas = Skema::all();
        return view('peserta.create', compact('skemas'));
    }

    public function store(Request $request)
    {
        // HANYA ADMIN yang boleh menyimpan data peserta baru
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Admin yang dapat menambah data peserta.');
        }

        $request->validate([
            'skema_id'   => 'required|exists:skemas,id',
            'no_peserta' => 'required|unique:pesertas,no_peserta',
            'nama'       => 'required',
            'email'      => 'required|email|unique:pesertas,email',
            'alamat'     => 'required',
        ]);

        Peserta::create($request->all());

        return redirect()->route('peserta.index')->with('success', 'Data Peserta berhasil ditambahkan oleh Admin!');
    }

    public function show(int $id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = Auth::user();

        // Keamanan: User biasa hanya boleh melihat data miliknya sendiri
        if ($user->role !== 'admin' && $peserta->email !== $user->email) {
            abort(403, 'Akses ditolak.');
        }

        return view('peserta.show', compact('peserta'));
    }

    public function edit(int $id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = Auth::user();

        // Keamanan: Jika bukan admin DAN data bukan milik user tersebut, tolak akses
        if ($user->role !== 'admin' && $peserta->email !== $user->email) {
            abort(403, 'Akses ditolak. Anda hanya dapat mengedit data milik sendiri.');
        }

        $skemas = Skema::all();
        return view('peserta.edit', compact('peserta', 'skemas'));
    }

    public function update(Request $request, int $id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = Auth::user();

        // Keamanan: Cek hak akses edit
        if ($user->role !== 'admin' && $peserta->email !== $user->email) {
            abort(403, 'Akses ditolak. Anda hanya dapat memperbarui data milik sendiri.');
        }

        $request->validate([
            'skema_id'   => 'required|exists:skemas,id',
            'no_peserta' => 'required|unique:pesertas,no_peserta,' . $peserta->id,
            'nama'       => 'required',
            'email'      => 'required|email|unique:pesertas,email,' . $peserta->id,
            'alamat'     => 'required',
        ]);

        $data = $request->all();

        // Jika yang mengedit adalah user biasa, pastikan emailnya terkunci tidak berubah ke email lain
        if ($user->role !== 'admin') {
            $data['email'] = $user->email;
        }

        $peserta->update($data);

        return redirect()->route('peserta.index')->with('success', 'Data Peserta berhasil diperbarui!');
    }

    public function destroy(int $id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = Auth::user();

        // Keamanan: Hanya admin yang boleh menghapus data peserta
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Admin yang dapat menghapus data peserta.');
        }

        $peserta->delete();

        return redirect()->route('peserta.index')->with('success', 'Data Peserta berhasil dihapus!');
    }
}