<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use Illuminate\Http\Request;

class SkemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data skema dari database
        $skemas = Skema::latest()->paginate(10);
        
        // Tampilkan view resources/views/skema/index.blade.php
        return view('skema.index', compact('skemas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tampilkan form tambah di resources/views/skema/create.blade.php
        return view('skema.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'kd_skema' => 'required|unique:skemas,kd_skema',
            'nm_skema' => 'required',
        ], [
            'kd_skema.required' => 'Kode Skema wajib diisi!',
            'kd_skema.unique'   => 'Kode Skema sudah digunakan!',
            'nm_skema.required' => 'Nama Skema wajib diisi!',
        ]);

        // Simpan data ke database
        Skema::create($request->all());

        return redirect()->route('skema.index')->with('success', 'Data Skema berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Tidak dipakai untuk skema
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skema $skema)
    {
        // Tampilkan form edit
        return view('skema.edit', compact('skema'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skema $skema)
    {
        // Validasi Input
        $request->validate([
            'kd_skema' => 'required|unique:skemas,kd_skema,' . $skema->id,
            'nm_skema' => 'required',
        ]);

        // Update data di database
        $skema->update($request->all());

        return redirect()->route('skema.index')->with('success', 'Data Skema berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(int $id)
{
    $skema = Skema::findOrFail($id);

    // Cek apakah skema masih terikat dengan data peserta
    if ($skema->pesertas()->count() > 0) {
        return redirect()->route('skema.index')
            ->with('error', 'Gagal menghapus! Skema ini masih digunakan oleh data peserta.');
    }

    $skema->delete();

    return redirect()->route('skema.index')
        ->with('success', 'Data Skema berhasil dihapus!');
}
}