<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KategoriMobilController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\DashboardController;
Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index']);

Route::resource('admins', AdminController::class);
Route::resource('pelanggans', PelangganController::class);
Route::resource('kategori-mobils', KategoriMobilController::class);
Route::resource('mobils', MobilController::class);
Route::resource('transaksis', TransaksiController::class);
Route::resource('detail-transaksis', DetailTransaksiController::class);
