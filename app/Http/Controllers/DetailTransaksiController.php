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
        return view('detail-transaksis.create', [
            'transaksis' => Transaksi::all(),
            'mobils'     => Mobil::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_transaksi' => 'required',
            'id_mobil'     => 'required',
            'jumlah_beli'  => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $mobil = Mobil::findOrFail($request->id_mobil);

                if ($mobil->stok < $request->jumlah_beli) {
                    throw new \Exception("Stok tidak mencukupi.");
                }

                $subtotal    = $mobil->harga * $request->jumlah_beli;
                $mobil->stok -= $request->jumlah_beli;
                $mobil->save();

                Detail_transaksi::create([
                    'id_transaksi' => $request->id_transaksi,
                    'id_mobil'     => $request->id_mobil,
                    'jumlah_beli'  => $request->jumlah_beli,
                    'subtotal'     => $subtotal,
                ]);

                $transaksi = Transaksi::findOrFail($request->id_transaksi);
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
        return view('detail-transaksis.edit', [
            'detail'     => Detail_transaksi::findOrFail($id),
            'transaksis' => Transaksi::all(),
            'mobils'     => Mobil::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_transaksi' => 'required',
            'id_mobil'     => 'required',
            'jumlah_beli'  => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $detail    = Detail_transaksi::findOrFail($id);
                $mobilBaru = Mobil::findOrFail($request->id_mobil);
                $mobilLama = Mobil::find($detail->id_mobil);

                if ($mobilLama) {
                    $mobilLama->stok += $detail->jumlah_beli;
                    $mobilLama->save();
                }

                if ($mobilBaru->stok < $request->jumlah_beli) {
                    throw new \Exception("Stok tidak mencukupi.");
                }

                $mobilBaru->stok -= $request->jumlah_beli;
                $mobilBaru->save();

                $subtotalBaru = $mobilBaru->harga * $request->jumlah_beli;
                $selisih      = $subtotalBaru - $detail->subtotal;

                $detail->update([
                    'id_transaksi' => $request->id_transaksi,
                    'id_mobil'     => $request->id_mobil,
                    'jumlah_beli'  => $request->jumlah_beli,
                    'subtotal'     => $subtotalBaru,
                ]);

                $transaksi = Transaksi::findOrFail($request->id_transaksi);
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
            $mobil = Mobil::find($detail->id_mobil);
            if ($mobil) {
                $mobil->stok += $detail->jumlah_beli;
                $mobil->save();
            }

            $transaksi = Transaksi::find($detail->id_transaksi);
            if ($transaksi) {
                $transaksi->total_bayar = max(0, $transaksi->total_bayar - $detail->subtotal);
                $transaksi->save();
            }

            $detail->delete();
        });

        return redirect('/detail-transaksis');
    }
}
