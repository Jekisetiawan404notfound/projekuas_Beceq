<?php

namespace App\Http\Controllers;

use App\Models\Detail_transaksi;
use App\Models\Transaksi;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = Detail_transaksi::with(['transaksi', 'mobil'])->get();
        return response()->json([
            'success' => true,
            'data' => $details
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'mobil_id' => 'required|exists:mobils,id',
            'jumlah_beli' => 'required|integer|min:1',
        ]);

        try {
            $detail = DB::transaction(function () use ($validated) {
                $mobil = Mobil::find($validated['mobil_id']);

                if ($mobil->stok < $validated['jumlah_beli']) {
                    throw new \Exception("Stok tidak mencukupi.");
                }

                $subtotal = $mobil->harga * $validated['jumlah_beli'];

                // Deduct stock
                $mobil->stok -= $validated['jumlah_beli'];
                $mobil->save();

                // Create detail
                $detail = Detail_transaksi::create([
                    'transaksi_id' => $validated['transaksi_id'],
                    'mobil_id' => $validated['mobil_id'],
                    'jumlah_beli' => $validated['jumlah_beli'],
                    'subtotal' => $subtotal
                ]);

                // Update total_bayar in Transaksi
                $transaksi = Transaksi::find($validated['transaksi_id']);
                $transaksi->total_bayar += $subtotal;
                $transaksi->save();

                return $detail;
            });

            $detail->load(['transaksi', 'mobil']);

            return response()->json([
                'success' => true,
                'message' => 'Detail transaksi berhasil ditambahkan',
                'data' => $detail
            ], 210);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan detail transaksi: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detail = Detail_transaksi::with(['transaksi', 'mobil'])->find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Detail transaksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $detail
        ], 200);
    }

    /**
     * Remove the specified resource from storage (restores stock & updates transaction total).
     */
    public function destroy(string $id)
    {
        $detail = Detail_transaksi::find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Detail transaksi tidak ditemukan'
            ], 404);
        }

        try {
            DB::transaction(function () use ($detail) {
                // Restore stock
                $mobil = Mobil::find($detail->mobil_id);
                if ($mobil) {
                    $mobil->stok += $detail->jumlah_beli;
                    $mobil->save();
                }

                // Update transaction total_bayar
                $transaksi = Transaksi::find($detail->transaksi_id);
                if ($transaksi) {
                    $transaksi->total_bayar -= $detail->subtotal;
                    if ($transaksi->total_bayar < 0) {
                        $transaksi->total_bayar = 0;
                    }
                    $transaksi->save();
                }

                $detail->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Detail transaksi berhasil dihapus, stok dikembalikan, dan total bayar transaksi diperbarui'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus detail transaksi: ' . $e->getMessage()
            ], 400);
        }
    }
}
