<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poli;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::orderBy('nama_poli')->paginate(10);

        return view('admin.poli.index', compact('polis'));
    }

    public function create()
    {
        return view('admin.poli.create');
    }

    public function store(Request $request)
    {
         $data = $request->validate([
            'nama_poli' => ['required', 'string', 'max:255'],
             'loket'     => ['nullable', 'string', 'max:20'],
        ]);

        Poli::create($data);

        return redirect()
            ->route('admin.poli.index')
            ->with('success', 'Poli berhasil ditambahkan.');
    }
      public function edit(Poli $poli)
    {
        return view('admin.poli.edit', compact('poli'));
    }

    public function update(Request $request, Poli $poli)
    {
        $data = $request->validate([
            'nama_poli' => ['required', 'string', 'max:255'],
             'loket'     => ['nullable', 'string', 'max:20'],
        ]);

        $poli->update($data);

        return redirect()
            ->route('admin.poli.index')
            ->with('success', 'Poli berhasil diperbarui.');
    }

    public function destroy(Poli $poli)
    {
        // optional: kalau mau cegah hapus kalau masih dipakai di antrian,
        // bisa tambahin pengecekan di sini.

        $poli->delete();

        return redirect()
            ->route('admin.poli.index')
            ->with('success', 'Poli berhasil dihapus.');
    }
}
