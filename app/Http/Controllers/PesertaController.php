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
    // kini dilakukan secara mandiri lewat proses Register & Edit/melengkapi Profil.

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

       $oldEmail = $peserta->email;

       if ($user->role !== 'admin') {
            $data['email'] = $user->email;
        } else {

            \App\Models\User::where('email', $oldEmail)->update([
                'email' => $request->email,
                'name'  => $request->nama
            ]);
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

    public function updateStatus(Request $request, int $id)
    {
        $user = Auth::user();
        
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Admin yang dapat mengubah status.');
        }

        $request->validate([
            'status' => 'required|in:Proses,Kompeten,Belum Kompeten',
        ]);

        $peserta = Peserta::findOrFail($id);
        $peserta->update([
            'status' => $request->status
        ]);

        return redirect()->route('peserta.index')->with('success', 'Status kelulusan peserta berhasil diperbarui!');
    }


    public function verifikasi(int $id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $peserta = Peserta::findOrFail($id);
        $peserta->update([
            'status_verifikasi' => 'approved'
        ]);

        return redirect()->route('peserta.index')->with('success', 'Akun dan dokumen peserta berhasil diverifikasi! Peserta kini dapat login.');
    }

        
}