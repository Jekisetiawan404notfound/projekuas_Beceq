<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KategoriMobilController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;
use App\Models\Admin;
use App\Models\Pelanggan;
use App\Models\Mobil;
use App\Models\Transaksi;

Route::get('/', function () {
    $totalAdmins = Admin::count();
    $totalPelanggans = Pelanggan::count();
    $totalMobils = Mobil::count();
    $totalTransaksis = Transaksi::count();
    $totalPendapatan = Transaksi::sum('total_bayar');
    $recentTransaksis = Transaksi::with(['pelanggan', 'admin'])->latest()->take(5)->get();

    return view('dashboard', compact('totalAdmins', 'totalPelanggans', 'totalMobils', 'totalTransaksis', 'totalPendapatan', 'recentTransaksis'));
});

Route::resource('admins', AdminController::class);
Route::resource('pelanggans', PelangganController::class);
Route::resource('kategori-mobils', KategoriMobilController::class);
Route::resource('mobils', MobilController::class);
Route::resource('transaksis', TransaksiController::class);
Route::resource('detail-transaksis', DetailTransaksiController::class);
