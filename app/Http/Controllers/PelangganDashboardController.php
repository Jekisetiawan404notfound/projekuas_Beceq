<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Transaksi;
use App\Models\Detail_transaksi;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelangganDashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $kategori = $request->query('kategori');
        
        $query = Mobil::with('kategori');
        
        // Search berdasarkan nama merek, model, atau kategori
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('merek', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%');
            });
        }
        
        // Filter berdasarkan kategori
        if ($kategori) {
            $query->where('id_kategori', $kategori);
        }
        
        $mobils = $query->get();
        $kategoris = \App\Models\Kategori_mobil::all();
        
        return view('pelanggans.dashboard', compact('mobils', 'kategoris', 'search', 'kategori'));
    }

    public function createTransaksi($id_mobil)
    {
        $admin = Admin::first();

        if (!$admin) {
            return redirect()->back()->with('error', 'Sistem tidak dapat memproses transaksi karena belum ada data Admin.');
        }

        return view('pelanggans.sewa', [
            'mobil'     => Mobil::with('kategori')->findOrFail($id_mobil),
            'pelanggan' => Auth::guard('pelanggan')->user(),
            'admin'     => $admin,
        ]);
    }

    public function storeTransaksi(Request $request)
    {
        $request->validate([
            'id_mobil'      => 'required',
            'jumlah_beli'   => 'required|integer|min:1',
            'tgl_transaksi' => 'required|date',
        ]);

        try {
            $transaksiId = DB::transaction(function () use ($request) {
                $mobil     = Mobil::findOrFail($request->id_mobil);
                $pelanggan = Auth::guard('pelanggan')->user();
                $admin     = Admin::first();

                if ($mobil->stok < $request->jumlah_beli) {
                    throw new \Exception("Stok mobil tidak mencukupi.");
                }

                if (!$admin) {
                    throw new \Exception("Data Admin tidak ditemukan.");
                }

                $subtotal    = $mobil->harga * $request->jumlah_beli;
                $mobil->stok -= $request->jumlah_beli;
                $mobil->save();

                $transaksi = Transaksi::create([
                    'id_pelanggan'  => $pelanggan->id_pelanggan,
                    'id_admin'      => $admin->id_admin,
                    'tgl_transaksi' => $request->tgl_transaksi,
                    'total_bayar'   => $subtotal,
                ]);

                Detail_transaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_mobil'     => $request->id_mobil,
                    'jumlah_beli'  => $request->jumlah_beli,
                    'subtotal'     => $subtotal,
                ]);

                return $transaksi->id_transaksi;
            });

            return redirect()->route('pelanggan.transaksi.detail', $transaksiId)
                             ->with('success', 'Transaksi sewa berhasil diajukan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function riwayatTransaksi()
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $transaksis = Transaksi::with(['admin', 'detail_transaksis.mobil'])
            ->where('id_pelanggan', $pelanggan->id_pelanggan)
            ->orderByDesc('id_transaksi')
            ->get();

        return view('pelanggans.riwayat', compact('transaksis'));
    }

    public function detailTransaksi($id_transaksi)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $transaksi = Transaksi::with(['admin', 'detail_transaksis.mobil'])
            ->where('id_pelanggan', $pelanggan->id_pelanggan)
            ->where('id_transaksi', $id_transaksi)
            ->firstOrFail();

        return view('pelanggans.detail', compact('transaksi'));
    }
}
