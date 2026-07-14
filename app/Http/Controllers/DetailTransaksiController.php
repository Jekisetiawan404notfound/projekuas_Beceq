<?php

namespace App\Http\Controllers;

use App\Models\Detail_transaksi;
use App\Models\Transaksi;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailTransaksiController extends Controller
{
    public function index()
    {
        $details = Detail_transaksi::with(['transaksi.pelanggan', 'mobil'])->get();
        return view('detail-transaksis.index', compact('details'));
    }

    public function create()
    {
        $transaksis = Transaksi::all();
        $mobils = Mobil::all();
        return view('detail-transaksis.create', compact('transaksis', 'mobils'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required',
            'mobil_id' => 'required',
            'jumlah_beli' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $mobil = Mobil::findOrFail($request->mobil_id);

                if ($mobil->stok < $request->jumlah_beli) {
                    throw new \Exception("Stok tidak mencukupi.");
                }

                $subtotal = $mobil->harga * $request->jumlah_beli;

                // Deduct stock
                $mobil->stok -= $request->jumlah_beli;
                $mobil->save();

                // Create detail
                Detail_transaksi::create([
                    'transaksi_id' => $request->transaksi_id,
                    'mobil_id' => $request->mobil_id,
                    'jumlah_beli' => $request->jumlah_beli,
                    'subtotal' => $subtotal,
                ]);

                // Update total_bayar in Transaksi
                $transaksi = Transaksi::findOrFail($request->transaksi_id);
                $transaksi->total_bayar += $subtotal;
                $transaksi->save();
            });

            return redirect('/detail-transaksis');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $detail = Detail_transaksi::findOrFail($id);
        $transaksis = Transaksi::all();
        $mobils = Mobil::all();
        return view('detail-transaksis.edit', compact('detail', 'transaksis', 'mobils'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'transaksi_id' => 'required',
            'mobil_id' => 'required',
            'jumlah_beli' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $detail = Detail_transaksi::findOrFail($id);
                $mobilBaru = Mobil::findOrFail($request->mobil_id);
                $mobilLama = Mobil::find($detail->mobil_id);

                // Kembalikan stok mobil lama
                if ($mobilLama) {
                    $mobilLama->stok += $detail->jumlah_beli;
                    $mobilLama->save();
                }

                // Cek stok mobil baru
                if ($mobilBaru->stok < $request->jumlah_beli) {
                    throw new \Exception("Stok tidak mencukupi.");
                }

                // Kurangi stok mobil baru
                $mobilBaru->stok -= $request->jumlah_beli;
                $mobilBaru->save();

                $subtotalBaru = $mobilBaru->harga * $request->jumlah_beli;
                $selisih = $subtotalBaru - $detail->subtotal;

                // Update detail
                $detail->update([
                    'transaksi_id' => $request->transaksi_id,
                    'mobil_id' => $request->mobil_id,
                    'jumlah_beli' => $request->jumlah_beli,
                    'subtotal' => $subtotalBaru,
                ]);

                // Update total_bayar di Transaksi
                $transaksi = Transaksi::findOrFail($request->transaksi_id);
                $transaksi->total_bayar += $selisih;
                $transaksi->save();
            });

            return redirect('/detail-transaksis');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $detail = Detail_transaksi::findOrFail($id);

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

        return redirect('/detail-transaksis');
    }
}
