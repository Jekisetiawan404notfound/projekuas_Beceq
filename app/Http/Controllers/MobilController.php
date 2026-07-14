<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Kategori_mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::with('kategori')->get();
        return view('mobils.index', compact('mobils'));
    }

    public function create()
    {
        $kategoris = Kategori_mobil::all();
        return view('mobils.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        Mobil::create([
            'kategori_id' => $request->kategori_id,
            'merek' => $request->merek,
            'model' => $request->model,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return redirect('/mobils');
    }

    public function edit($id)
    {
        $mobil = Mobil::findOrFail($id);
        $kategoris = Kategori_mobil::all();
        return view('mobils.edit', compact('mobil', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $mobil = Mobil::findOrFail($id);
        $mobil->update([
            'kategori_id' => $request->kategori_id,
            'merek' => $request->merek,
            'model' => $request->model,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return redirect('/mobils');
    }

    public function destroy($id)
    {
        $mobil = Mobil::findOrFail($id);
        $mobil->delete();

        return redirect('/mobils');
    }
}
