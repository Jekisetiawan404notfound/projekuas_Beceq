@extends('layouts.app')

@section('title', 'Sewa Mobil')
@section('page-title', 'Form Sewa Mobil')
@section('page-subtitle', 'Silakan tentukan jumlah unit dan tanggal transaksi')

@section('content')
{{-- Menampilkan form penyewaan mobil untuk pelanggan --}}

@php
    function getCarImage($merek, $model) {
        $merek = strtolower($merek);
        $model = strtolower($model);
        
        if (str_contains($merek, 'toyota') && str_contains($model, 'avanza')) {
            return 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?auto=format&fit=crop&q=80&w=600';
        }
        if (str_contains($merek, 'toyota') && str_contains($model, 'zenix')) {
            return 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&q=80&w=600';
        }
        if (str_contains($merek, 'toyota') && str_contains($model, 'yaris')) {
            return 'https://images.unsplash.com/photo-1619767886558-efdc259cde1a?auto=format&fit=crop&q=80&w=600';
        }
        if (str_contains($merek, 'honda') && str_contains($model, 'hr-v')) {
            return 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&q=80&w=600';
        }
        if (str_contains($merek, 'honda') && str_contains($model, 'civic')) {
            return 'https://images.unsplash.com/photo-1606016159991-dfe4f2746ad5?auto=format&fit=crop&q=80&w=600';
        }
        if (str_contains($merek, 'mitsubishi')) {
            return 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&q=80&w=600';
        }
        if (str_contains($merek, 'suzuki')) {
            return 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&q=80&w=600';
        }
        if (str_contains($merek, 'daihatsu')) {
            return 'https://images.unsplash.com/photo-1525609004556-c46c7d6cf0a3?auto=format&fit=crop&q=80&w=600';
        }
        return 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&q=80&w=600';
    }
@endphp

<div class="row">
    <!-- Left Column: Form -->
    <div class="col-lg-7 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-file-invoice-dollar mr-2"></i>Formulir Penyewaan
                </h6>
                <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('pelanggan.transaksi.store') }}" method="POST" id="formSewa">
                    @csrf
                    <input type="hidden" name="id_mobil" value="{{ $mobil->id_mobil }}">

                    <!-- Info Pelanggan -->
                    <div class="p-3 mb-4 rounded border bg-light">
                        <h6 class="font-weight-bold text-gray-800 mb-2">
                            <i class="fas fa-user-circle text-primary mr-1"></i> Data Penyewa
                        </h6>
                        <div class="row text-muted small">
                            <div class="col-sm-4 font-weight-bold">Nama Lengkap:</div>
                            <div class="col-sm-8 mb-1">{{ $pelanggan->nama }}</div>
                            <div class="col-sm-4 font-weight-bold">Nomor Telepon:</div>
                            <div class="col-sm-8 mb-1">{{ $pelanggan->no_telepon }}</div>
                            <div class="col-sm-4 font-weight-bold">Alamat:</div>
                            <div class="col-sm-8">{{ $pelanggan->alamat }}</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tgl_transaksi" class="font-weight-bold small text-uppercase text-muted">Tanggal Mulai Sewa</label>
                        <input type="date" name="tgl_transaksi" id="tgl_transaksi" class="form-control"
                            value="{{ old('tgl_transaksi', date('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="jumlah_beli" class="font-weight-bold small text-uppercase text-muted">Jumlah Unit</label>
                        <div class="input-group">
                            <input type="number" name="jumlah_beli" id="jumlah_beli" class="form-control"
                                placeholder="0" value="{{ old('jumlah_beli', 1) }}" min="1" max="{{ $mobil->stok }}" required onchange="hitungSubtotal()" onkeyup="hitungSubtotal()">
                            <div class="input-group-append">
                                <span class="input-group-text">Unit</span>
                            </div>
                        </div>
                        <small class="form-text text-muted">Maksimal penyewaan: <strong>{{ $mobil->stok }} unit</strong> (sesuai stok yang tersedia).</small>
                    </div>

                    <hr class="my-4">

                    <!-- Subtotal Preview -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="font-weight-bold text-gray-800 mb-0">Total Estimasi Pembayaran</h6>
                            <small class="text-muted">Dihitung otomatis berdasarkan unit</small>
                        </div>
                        <h4 class="font-weight-bold text-success mb-0" id="preview_subtotal">
                            Rp 0
                        </h4>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg font-weight-bold">
                        <i class="fas fa-check mr-2"></i> Konfirmasi &amp; Sewa Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Mobil Details Summary -->
    <div class="col-lg-5 mb-4">
        <div class="card shadow border-0 overflow-hidden">
            <div class="bg-gray-100" style="height: 240px; overflow: hidden; position: relative;">
                <img src="{{ getCarImage($mobil->merek, $mobil->model) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $mobil->merek }} {{ $mobil->model }}">
                <span class="badge badge-success px-3 py-2 text-uppercase font-weight-bold shadow-sm" style="position: absolute; bottom: 16px; left: 16px; border-radius: 20px; font-size: 11px;">
                    {{ $mobil->kategori->nama_kategori ?? 'Mobil' }}
                </span>
            </div>
            <div class="card-body p-4">
                <h4 class="font-weight-bold text-gray-900 mb-1">{{ $mobil->merek }}</h4>
                <p class="text-muted mb-4">{{ $mobil->model }}</p>

                <div class="border-top border-bottom py-3 my-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Harga Sewa / Unit</span>
                        <span class="font-weight-bold text-gray-800">
                            Rp {{ number_format($mobil->harga, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Stok Ready</span>
                        <span class="badge badge-success px-2 py-1">
                            {{ $mobil->stok }} Unit
                        </span>
                    </div>
                </div>

                <div class="p-3 bg-light rounded text-muted small">
                    <h6 class="font-weight-bold text-gray-800 mb-1"><i class="fas fa-info-circle mr-1"></i> Informasi Rental</h6>
                    Transaksi akan langsung tercatat di sistem admin kami. Silakan selesaikan pembayaran dan ambil kunci di kantor Beceq Rent dengan menunjukkan bukti transaksi sewa ini.
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const hargaMobil = {{ $mobil->harga }};
    
    function hitungSubtotal() {
        const jumlahInput = document.getElementById('jumlah_beli');
        let jumlah = parseInt(jumlahInput.value) || 0;
        
        // Jaga agar nilai tidak melebihi stok atau kurang dari 1
        const maxStok = parseInt(jumlahInput.getAttribute('max')) || 1;
        if (jumlah > maxStok) {
            jumlah = maxStok;
            jumlahInput.value = maxStok;
        } else if (jumlah < 1) {
            jumlah = 1;
            jumlahInput.value = 1;
        }

        const total = hargaMobil * jumlah;
        document.getElementById('preview_subtotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
    
    document.addEventListener('DOMContentLoaded', hitungSubtotal);
</script>
@endpush
