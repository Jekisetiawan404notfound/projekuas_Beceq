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
        $pelanggans = Pelanggan::all();
        $admins = Admin::all();
        $mobils = Mobil::where('stok', '>', 0)->get();
        return view('transaksis.create', compact('pelanggans', 'admins', 'mobils'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required',
            'admin_id' => 'required',
            'tgl_transaksi' => 'required|date',
            'mobil_id' => 'required',
            'jumlah_beli' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $mobil = Mobil::findOrFail($request->mobil_id);

                if ($mobil->stok < $request->jumlah_beli) {
                    throw new \Exception("Stok mobil tidak mencukupi.");
                }

                $subtotal = $mobil->harga * $request->jumlah_beli;

                // Deduct stock
                $mobil->stok -= $request->jumlah_beli;
                $mobil->save();

                // Create transaction
                $transaksi = Transaksi::create([
                    'pelanggan_id' => $request->pelanggan_id,
                    'admin_id' => $request->admin_id,
                    'tgl_transaksi' => $request->tgl_transaksi,
                    'total_bayar' => $subtotal,
                ]);

                // Create detail transaction
                Detail_transaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'mobil_id' => $request->mobil_id,
                    'jumlah_beli' => $request->jumlah_beli,
                    'subtotal' => $subtotal,
                ]);
            });

            return redirect('/transaksis')->with('success', 'Transaksi berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $pelanggans = Pelanggan::all();
        $admins = Admin::all();
        $mobils = Mobil::all();
        return view('transaksis.edit', compact('transaksi', 'pelanggans', 'admins', 'mobils'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pelanggan_id' => 'required',
            'admin_id' => 'required',
            'tgl_transaksi' => 'required|date',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'pelanggan_id' => $request->pelanggan_id,
            'admin_id' => $request->admin_id,
            'tgl_transaksi' => $request->tgl_transaksi,
        ]);

        return redirect('/transaksis');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        DB::transaction(function () use ($transaksi) {
            // Restore stock
            foreach ($transaksi->detail_transaksis as $detail) {
                $mobil = Mobil::find($detail->mobil_id);
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
