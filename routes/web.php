<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KategoriMobilController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('admins', AdminController::class);
Route::apiResource('pelanggans', PelangganController::class);
Route::apiResource('kategori-mobils', KategoriMobilController::class);
Route::apiResource('mobils', MobilController::class);
Route::apiResource('transaksis', TransaksiController::class);
Route::apiResource('detail-transaksis', DetailTransaksiController::class);
