<?php

namespace App\Http\Controllers;

use App\Models\Kategori_mobil;
use Illuminate\Http\Request;

class KategoriMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori_mobil::all();
        return response()->json([
            'success' => true,
            'data' => $kategori
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_mobils,nama_kategori',
        ]);

        $kategori = Kategori_mobil::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategori mobil berhasil ditambahkan',
            'data' => $kategori
        ], 210);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori_mobil::with('mobils')->find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori mobil tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $kategori
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = Kategori_mobil::find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori mobil tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_mobils,nama_kategori,' . $id,
        ]);

        $kategori->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategori mobil berhasil diperbarui',
            'data' => $kategori
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori_mobil::find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori mobil tidak ditemukan'
            ], 404);
        }

        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori mobil berhasil dihapus'
        ], 200);
    }
}
