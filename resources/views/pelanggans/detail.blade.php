@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi Sewa')
@section('page-subtitle', 'Rincian transaksi penyewaan Anda')

@section('content')
{{-- Menampilkan detail transaksi sewa pelanggan --}}

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

<div class="row justify-content-center">
    <div class="col-lg-9">
        
        <!-- Print Area -->
        <div class="card shadow mb-4" id="printableInvoice">
            
            <!-- Invoice Header -->
            <div class="card-header py-3 bg-gradient-primary text-white d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-file-invoice mr-2"></i>Bukti Penyewaan &mdash; #{{ $transaksi->id_transaksi ?? $transaksi->id }}
                </h6>
                <div class="d-print-none">
                    <button onclick="window.print()" class="btn btn-light btn-sm font-weight-bold mr-2 text-primary">
                        <i class="fas fa-print mr-1"></i> Cetak Bukti
                    </button>
                    <a href="{{ route('pelanggan.transaksi.riwayat') }}" class="btn btn-outline-light btn-sm font-weight-bold">
                        <i class="fas fa-history mr-1"></i> Riwayat Sewa
                    </a>
                </div>
            </div>
            
            <div class="card-body p-5">
                
                <!-- Brand and Invoice Details -->
                <div class="row mb-5">
                    <div class="col-sm-6">
                        <h3 class="font-weight-bold text-gray-900 mb-0">Beceq Rent</h3>
                        <p class="text-muted small">Sistem Rental Mobil Profesional</p>
                    </div>
                    <div class="col-sm-6 text-sm-right text-muted">
                        <h5 class="text-gray-800 font-weight-bold mb-1">TRANSAKSI</h5>
                        <p class="mb-0 small">No. Transaksi: <strong>#{{ $transaksi->id_transaksi ?? $transaksi->id }}</strong></p>
                        <p class="mb-0 small">Tanggal: <strong>{{ \Carbon\Carbon::parse($transaksi->tgl_transaksi)->translatedFormat('d F Y') }}</strong></p>
                    </div>
                </div>

                <!-- Customer and Admin Information -->
                <div class="row mb-5">
                    <div class="col-sm-6 mb-3">
                        <h6 class="font-weight-bold text-gray-800 border-bottom pb-2">Informasi Pelanggan:</h6>
                        <div class="small">
                            <h6 class="font-weight-bold text-gray-900 mb-1">{{ $transaksi->pelanggan->nama }}</h6>
                            <p class="text-muted mb-1"><i class="fas fa-phone mr-1"></i> {{ $transaksi->pelanggan->no_telepon }}</p>
                            <p class="text-muted mb-0"><i class="fas fa-map-marker-alt mr-1"></i> {{ $transaksi->pelanggan->alamat }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3 text-sm-right">
                        <h6 class="font-weight-bold text-gray-800 border-bottom pb-2">Informasi Tambahan:</h6>
                        <div class="small">
                            <p class="mb-1">Petugas Admin: <strong>{{ $transaksi->admin->username ?? 'Default Admin' }}</strong></p>
                            <p class="mb-1">Status Transaksi: <span class="badge badge-success px-2 py-1">Selesai</span></p>
                            <p class="mb-0">Metode: <strong>Pengambilan Kantor</strong></p>
                        </div>
                    </div>
                </div>

                <!-- Transaction Items Table -->
                <div class="table-responsive mb-5">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Deskripsi Unit Mobil</th>
                                <th class="text-right" width="150">Harga Satuan</th>
                                <th class="text-center" width="100">Jumlah</th>
                                <th class="text-right" width="180">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi->detail_transaksis as $index => $detail)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <!-- Simple Thumbnail -->
                                            <div class="mr-3 d-print-none" style="width: 80px; height: 50px; overflow: hidden; border-radius: 6px;">
                                                <img src="{{ getCarImage($detail->mobil->merek ?? '', $detail->mobil->model ?? '') }}" class="w-100 h-100" style="object-fit: cover;">
                                            </div>
                                            <div>
                                                <h6 class="font-weight-bold text-gray-900 mb-0">
                                                    {{ $detail->mobil->merek ?? 'Mobil dihapus' }}
                                                </h6>
                                                <small class="text-muted">{{ $detail->mobil->model ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right align-middle">
                                        Rp {{ number_format($detail->mobil->harga ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $detail->jumlah_beli }}
                                    </td>
                                    <td class="text-right align-middle font-weight-bold text-gray-900">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right font-weight-bold align-middle py-3">Total Pembayaran</td>
                                <td class="text-right font-weight-bold text-success align-middle py-3" style="font-size: 1.2rem;">
                                    Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Footer Terms -->
                <div class="p-3 bg-light rounded text-muted small border-left-primary">
                    <h6 class="font-weight-bold text-gray-800 mb-2"><i class="fas fa-exclamation-circle mr-1"></i> Syarat &amp; Ketentuan Pengambilan</h6>
                    <ul class="mb-0 pl-3">
                        <li>Harap membawa KTP / SIM asli saat melakukan pengambilan mobil.</li>
                        <li>Pembayaran sewa dapat diselesaikan langsung di kantor.</li>
                        <li>Mobil harus dikembalikan dalam kondisi bersih dan bahan bakar sesuai saat penyerahan.</li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printableInvoice, #printableInvoice * {
            visibility: visible;
        }
        #printableInvoice {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none !important;
            box-shadow: none !important;
        }
        .d-print-none {
            display: none !important;
        }
    }
</style>
@endpush

@endsection
