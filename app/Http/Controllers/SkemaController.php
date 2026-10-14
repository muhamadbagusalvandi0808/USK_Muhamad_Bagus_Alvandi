<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class SkemaController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Administrator.');
        }

        $skemas = Skema::latest()->paginate(10);
        return view('skema.index', compact('skemas'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        return view('skema.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'kd_skema' => 'required|unique:skemas,kd_skema',
            'nm_skema' => 'required',
        ]);

        Skema::create($request->all());
        return redirect()->route('skema.index')->with('success', 'Data Skema berhasil ditambahkan!');
    }

    public function edit(Skema $skema)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        return view('skema.edit', compact('skema'));
    }

    public function update(Request $request, Skema $skema)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'kd_skema' => 'required|unique:skemas,kd_skema,' . $skema->id,
            'nm_skema' => 'required',
        ]);

        $skema->update($request->all());
        return redirect()->route('skema.index')->with('success', 'Data Skema berhasil diperbarui!');
    }

    public function destroy(int $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $skema = Skema::findOrFail($id);
        if ($skema->pesertas()->count() > 0) {
            return redirect()->route('skema.index')
                ->with('error', 'Gagal menghapus! Skema ini masih digunakan oleh data peserta.');
        }
        $skema->delete();
        return redirect()->route('skema.index')->with('success', 'Data Skema berhasil dihapus!');
    }
}