<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Skema;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fitur Pencarian Nama Peserta & Filter Pagination
        $pesertas = Peserta::with('skema')
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                             ->orWhere('no_peserta', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('peserta.index', compact('pesertas', 'search'));
    }

    public function create()
    {
        // Ngambil data skema untuk dropdown pilihan
        $skemas = Skema::all();
        return view('peserta.create', compact('skemas'));
    }

   public function store(Request $request)
{
    $request->validate([
        'skema_id'   => 'required|exists:skemas,id',
        'no_peserta' => 'required|unique:pesertas,no_peserta',
        'nama'       => 'required',
        'email'      => 'required|email|unique:pesertas,email',
        'alamat'     => 'required',
    ]);

    Peserta::create($request->all());

    return redirect()->route('peserta.index')->with('success', 'Data Peserta berhasil ditambahkan!');
}

    public function show(int $id)
{
    $peserta = Peserta::findOrFail($id);
    return view('peserta.show', compact('peserta'));
}

    public function edit(int $id)
    {
    $peserta = Peserta::findOrFail($id);
    $skemas = Skema::all();
    return view('peserta.edit', compact('peserta', 'skemas'));
    }

public function update(Request $request, int $id)
{
    $peserta = Peserta::findOrFail($id);

    $request->validate([
        'skema_id'   => 'required|exists:skemas,id',
        'no_peserta' => 'required|unique:pesertas,no_peserta,' . $peserta->id,
        'nama'       => 'required',
        'email'      => 'required|email|unique:pesertas,email,' . $peserta->id,
        'alamat'     => 'required',
    ]);

    $peserta->update($request->all());

    return redirect()->route('peserta.index')->with('success', 'Data Peserta berhasil diperbarui!');
}

    public function destroy(int $id)
{
    $peserta = Peserta::findOrFail($id);
    $peserta->delete();

    return redirect()->route('peserta.index')->with('success', 'Data Peserta berhasil dihapus!');
}
}