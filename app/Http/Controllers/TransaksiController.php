<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Detail_transaksi;
use App\Models\Mobil;
use App\Models\Pelanggan;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['pelanggan', 'admin', 'detail_transaksis.mobil'])->get();
        return view('transaksis.index', compact('transaksis'));
    }

    public function create()
    {
        return view('transaksis.create', [
            'pelanggans' => Pelanggan::all(),
            'admins'     => Admin::all(),
            'mobils'     => Mobil::where('stok', '>', 0)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan'  => 'required',
            'id_admin'      => 'required',
            'tgl_transaksi' => 'required|date',
            'id_mobil'      => 'required',
            'jumlah_beli'   => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $mobil = Mobil::findOrFail($request->id_mobil);

                if ($mobil->stok < $request->jumlah_beli) {
                    throw new \Exception("Stok mobil tidak mencukupi.");
                }

                $subtotal    = $mobil->harga * $request->jumlah_beli;
                $mobil->stok -= $request->jumlah_beli;
                $mobil->save();

                $transaksi = Transaksi::create([
                    'id_pelanggan'  => $request->id_pelanggan,
                    'id_admin'      => $request->id_admin,
                    'tgl_transaksi' => $request->tgl_transaksi,
                    'total_bayar'   => $subtotal,
                ]);

                Detail_transaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_mobil'     => $request->id_mobil,
                    'jumlah_beli'  => $request->jumlah_beli,
                    'subtotal'     => $subtotal,
                ]);
            });

            return redirect('/transaksis')->with('success', 'Transaksi berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        return view('transaksis.edit', [
            'transaksi'  => Transaksi::findOrFail($id),
            'pelanggans' => Pelanggan::all(),
            'admins'     => Admin::all(),
            'mobils'     => Mobil::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pelanggan'  => 'required',
            'id_admin'      => 'required',
            'tgl_transaksi' => 'required|date',
        ]);

        Transaksi::findOrFail($id)->update([
            'id_pelanggan'  => $request->id_pelanggan,
            'id_admin'      => $request->id_admin,
            'tgl_transaksi' => $request->tgl_transaksi,
        ]);

        return redirect('/transaksis');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        DB::transaction(function () use ($transaksi) {
            foreach ($transaksi->detail_transaksis as $detail) {
                $mobil = Mobil::find($detail->id_mobil);
                if ($mobil) {
                    $mobil->stok += $detail->jumlah_beli;
                    $mobil->save();
                }
            }
            $transaksi->delete();
        });

        return redirect('/transaksis');
    }
}
