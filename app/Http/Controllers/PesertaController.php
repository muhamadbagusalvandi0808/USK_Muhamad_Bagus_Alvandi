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

        $query = Peserta::with('skema');

        // Jika user biasa, hanya tampilkan data peserta miliknya sendiri
        if ($user->role !== 'admin') {
            $query->where('email', $user->email);
        }

        $pesertas = $query->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                             ->orWhere('nis', 'like', "%{$search}%")
                             ->orWhere('nik', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('peserta.index', compact('pesertas', 'search'));
    }

    // Fungsi create dan store dikosongkan/dihapus karena pendaftaran peserta 
    // kini dilakukan secara mandiri lewat proses Register & Edit Profil.

    public function show(int $id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'admin' && $peserta->email !== $user->email) {
            abort(403, 'Akses ditolak.');
        }

        return view('peserta.show', compact('peserta'));
    }

    public function edit(int $id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = Auth::user();

        // Keamanan: Pastikan user hanya bisa mengedit datanya sendiri (kecuali admin)
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

        if ($user->role !== 'admin' && $peserta->email !== $user->email) {
            abort(403, 'Akses ditolak. Anda hanya dapat memperbarui data milik sendiri.');
        }

        // Validasi kelengkapan profil peserta
        $request->validate([
            'nik'        => 'required|max:20|unique:pesertas,nik,' . $peserta->id,
            'nis'        => 'required|min:4|max:10|unique:pesertas,nis,' . $peserta->id,
            'nama'       => 'required',
            'jk'         => 'required',
            'skema_id'   => 'required|exists:skemas,id',
            'telp'       => 'required|max:15',
            'alamat'     => 'required',
            'email'      => 'required|email|unique:pesertas,email,' . $peserta->id,
        ]);

        $data = $request->all();

        // Jika yang mengedit adalah user biasa, kunci emailnya agar tidak bisa diubah
        if ($user->role !== 'admin') {
            $data['email'] = $user->email;
        }

        $peserta->update($data);

        return redirect()->route('peserta.index')->with('success', 'Data Profil Peserta berhasil dilengkapi dan diperbarui!');
    }

    public function destroy(int $id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Admin yang dapat menghapus data peserta.');
        }

        \App\Models\User::where('email', $peserta->email)->delete();

        $peserta->delete();

        return redirect()->route('peserta.index')->with('success', 'Data Peserta beserta akun loginnya berhasil dihapus!');
    }
}