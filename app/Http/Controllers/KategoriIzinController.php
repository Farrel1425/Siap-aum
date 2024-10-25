<?php

namespace App\Http\Controllers;

use App\Models\KategoriIzin;
use Illuminate\Http\Request;

class KategoriIzinController extends Controller
{
    public function index()
    {
        $kategori_izin = KategoriIzin::all();
        return view('pages.master-data.kategori-izin.index', compact('kategori_izin'));
    }

    public function create()
    {
        return view('pages.master-data.kategori-izin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        KategoriIzin::create($request->only('nama'));
        return redirect()->route('kategori-izin.index')->with('success', 'Kategori Izin berhasil ditambahkan');
    }

    public function edit(KategoriIzin $kategori_izin)
    {
        return view('pages.master-data.kategori-izin.edit', compact('kategori_izin'));
    }

    public function update(Request $request, KategoriIzin $kategori_izin)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $kategori_izin->update($request->only('nama'));
        return redirect()->route('kategori-izin.index')->with('success', 'Kategori Izin berhasil diubah');
    }
}
