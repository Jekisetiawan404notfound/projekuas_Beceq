<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KategoriMobilController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\PelangganAuthController;

Route::get('/', function () {
    return redirect('/login');
});

Route::apiResource('admins', AdminController::class);
Route::apiResource('pelanggans', PelangganController::class);
Route::apiResource('kategori-mobils', KategoriMobilController::class);
Route::apiResource('mobils', MobilController::class);
Route::apiResource('transaksis', TransaksiController::class);
Route::apiResource('detail-transaksis', DetailTransaksiController::class);

/*
|--------------------------------------------------------------------------
| Auth Routes - Pelanggan
|--------------------------------------------------------------------------
*/
Route::get('/register', [PelangganAuthController::class, 'showRegisterForm'])->name('pelanggan.register');
Route::post('/register', [PelangganAuthController::class, 'register']);

Route::get('/login', [PelangganAuthController::class, 'showLoginForm'])->name('pelanggan.login');
Route::post('/login', [PelangganAuthController::class, 'login']);

Route::post('/logout', [PelangganAuthController::class, 'logout'])->name('pelanggan.logout');

Route::middleware('auth:pelanggan')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.pelanggan');
    })->name('pelanggan.dashboard');
});

/*
|--------------------------------------------------------------------------
| Auth Routes - Admin
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard');
});
