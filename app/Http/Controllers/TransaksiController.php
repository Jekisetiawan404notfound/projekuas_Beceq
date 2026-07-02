<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Detail_transaksi;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::with(['pelanggan', 'admin', 'detailTransaksis.mobil'])->get();
        return response()->json([
            'success' => true,
            'data' => $transaksis
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'admin_id' => 'required|exists:admins,id',
            'tgl_transaksi' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.mobil_id' => 'required|exists:mobils,id',
            'details.*.jumlah_beli' => 'required|integer|min:1',
        ]);

        try {
            $transaksi = DB::transaction(function () use ($validated) {
                // 1. Create the Transaction first with a placeholder total_bayar
                $transaksi = Transaksi::create([
                    'pelanggan_id' => $validated['pelanggan_id'],
                    'admin_id' => $validated['admin_id'],
                    'tgl_transaksi' => $validated['tgl_transaksi'],
                    'total_bayar' => 0 // will update after calculating details
                ]);

                $totalBayar = 0;

                // 2. Loop through details to save them & update stock
                foreach ($validated['details'] as $detail) {
                    $mobil = Mobil::find($detail['mobil_id']);

                    // Check if stock is sufficient
                    if ($mobil->stok < $detail['jumlah_beli']) {
                        throw new \Exception("Stok mobil {$mobil->merek} {$mobil->model} tidak mencukupi. Sisa stok: {$mobil->stok}.");
                    }

                    // Calculate subtotal
                    $subtotal = $mobil->harga * $detail['jumlah_beli'];
                    $totalBayar += $subtotal;

                    // Deduct stock
                    $mobil->stok -= $detail['jumlah_beli'];
                    $mobil->save();

                    // Create detail transaction
                    Detail_transaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'mobil_id' => $detail['mobil_id'],
                        'jumlah_beli' => $detail['jumlah_beli'],
                        'subtotal' => $subtotal
                    ]);
                }

                // 3. Update total_bayar
                $transaksi->total_bayar = $totalBayar;
                $transaksi->save();

                return $transaksi;
            });

            $transaksi->load(['pelanggan', 'admin', 'detailTransaksis.mobil']);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'data' => $transaksi
            ], 210);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'admin', 'detailTransaksis.mobil'])->find($id);

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $transaksi
        ], 200);
    }

    /**
     * Remove the specified resource from storage (with restoring stock).
     */
    public function destroy(string $id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        try {
            DB::transaction(function () use ($transaksi) {
                // Restore stock for all detailed items
                $details = Detail_transaksi::where('transaksi_id', $transaksi->id)->get();
                foreach ($details as $detail) {
                    $mobil = Mobil::find($detail->mobil_id);
                    if ($mobil) {
                        $mobil->stok += $detail->jumlah_beli;
                        $mobil->save();
                    }
                }

                // Details will be automatically deleted on cascade due to foreign key setup
                $transaksi->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus dan stok mobil dikembalikan'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus transaksi: ' . $e->getMessage()
            ], 400);
        }
    }
}
