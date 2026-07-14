<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pelanggan;
use App\Models\Mobil;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAdmins = Admin::count();
        $totalPelanggans = Pelanggan::count();
        $totalMobils = Mobil::count();
        $totalTransaksis = Transaksi::count();
        $totalPendapatan = Transaksi::sum('total_bayar');
        $recentTransaksis = Transaksi::with(['pelanggan', 'admin'])->orderBy('id_transaksi', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'totalAdmins',
            'totalPelanggans',
            'totalMobils',
            'totalTransaksis',
            'totalPendapatan',
            'recentTransaksis'
        ));
    }
}
