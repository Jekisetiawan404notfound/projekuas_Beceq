<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KategoriMobilController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\PelangganAuthController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['admin'])->group(function () {
    Route::resource('admins', AdminController::class);
    Route::resource('pelanggans', PelangganController::class);
    Route::resource('kategori-mobils', KategoriMobilController::class);
    Route::resource('mobils', MobilController::class);
    Route::resource('transaksis', TransaksiController::class);
    Route::resource('detail-transaksis', DetailTransaksiController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard');
});

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

Route::middleware(['pelanggan'])->group(function () {
    Route::get('/dashboard/pelanggan', function () {
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
