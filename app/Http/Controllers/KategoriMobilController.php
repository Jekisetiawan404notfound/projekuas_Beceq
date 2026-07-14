<?php

namespace App\Http\Controllers;

use App\Models\Kategori_mobil;
use Illuminate\Http\Request;

class KategoriMobilController extends Controller
{
    public function index()
    {
        $kategoris = Kategori_mobil::all();
        return view('kategori-mobils.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori-mobils.create');
    }

    public function store(Request $request)
    {
        Kategori_mobil::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect('/kategori-mobils');
    }

    public function edit($id)
    {
        $kategori = Kategori_mobil::findOrFail($id);
        return view('kategori-mobils.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori_mobil::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect('/kategori-mobils');
    }

    public function destroy($id)
    {
        $kategori = Kategori_mobil::findOrFail($id);
        $kategori->delete();

        return redirect('/kategori-mobils');
    }
}
