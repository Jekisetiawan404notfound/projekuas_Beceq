@extends('layouts.app')

@section('title', 'Katalog Mobil')
@section('page-title', 'Katalog Armada Mobil')
@section('page-subtitle', 'Pilih mobil impian Anda dan lakukan penyewaan dengan mudah')

@section('content')

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

@push('styles')
<style>
    .car-card {
        transition: all 0.3s ease-in-out;
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }
    .car-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15) !important;
    }
    .car-img-wrapper {
        position: relative;
        height: 200px;
        overflow: hidden;
        background-color: #eaecf4;
    }
    .car-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .car-card:hover .car-img {
        transform: scale(1.08);
    }
    .category-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 10;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    .price-tag {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1cc88a;
    }
</style>
@endpush

<div class="row">
    @forelse($mobils as $mobil)
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm car-card">
            <!-- Image Wrapper -->
            <div class="car-img-wrapper">
                <span class="badge badge-primary category-badge">
                    <i class="fas fa-tag mr-1"></i>
                    {{ $mobil->kategori->nama_kategori ?? 'Umum' }}
                </span>
                <img class="car-img" src="{{ getCarImage($mobil->merek, $mobil->model) }}" alt="{{ $mobil->merek }} {{ $mobil->model }}">
            </div>
            
            <!-- Card Body -->
            <div class="card-body d-flex flex-column justify-content-between p-4">
                <div>
                    <h5 class="font-weight-bold text-gray-900 mb-1">
                        {{ $mobil->merek }}
                    </h5>
                    <p class="text-muted mb-3">{{ $mobil->model }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="price-tag">
                            Rp {{ number_format($mobil->harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3 small">
                        <span class="font-weight-bold text-gray-700">Ketersediaan Stok</span>
                        @if($mobil->stok > 0)
                            <span class="badge badge-success-soft text-success px-2 py-1">
                                <i class="fas fa-check-circle mr-1"></i> {{ $mobil->stok }} Tersedia
                            </span>
                        @else
                            <span class="badge badge-danger-soft text-danger px-2 py-1">
                                <i class="fas fa-times-circle mr-1"></i> Habis
                            </span>
                        @endif
                    </div>
                    
                    @if($mobil->stok > 0)
                        <a href="{{ route('pelanggan.transaksi.create', $mobil->id_mobil) }}" class="btn btn-primary btn-block font-weight-bold py-2 rounded-lg">
                            <i class="fas fa-key mr-2"></i>Sewa Sekarang
                        </a>
                    @else
                        <button class="btn btn-secondary btn-block font-weight-bold py-2 rounded-lg" disabled>
                            <i class="fas fa-ban mr-2"></i>Stok Kosong
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 text-muted">
        <i class="fas fa-car-crash fa-3x mb-3 d-block"></i>
        <h4>Armada mobil tidak tersedia.</h4>
        <p>Silakan hubungi admin kami untuk informasi lebih lanjut.</p>
    </div>
    @endforelse
</div>

@endsection
