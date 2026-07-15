@extends('layouts.app')

@section('title', 'Tambah Mobil')
@section('page-title', 'Tambah Mobil')
@section('page-subtitle', 'Tambahkan data kendaraan baru ke inventaris')

@section('content')
{{-- Menampilkan form tambah mobil baru --}}
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-car mr-2"></i>Form Tambah Mobil
                </h6>
                <a href="{{ route('mobils.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('mobils.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="kategori_id" class="font-weight-bold small text-uppercase text-muted">Kategori</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id_kategori }}" {{ old('kategori_id') == $kategori->id_kategori ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="merek" class="font-weight-bold small text-uppercase text-muted">Merek</label>
                            <input type="text" name="merek" id="merek" class="form-control"
                                placeholder="Toyota, Honda, dll." value="{{ old('merek') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="model" class="font-weight-bold small text-uppercase text-muted">Model</label>
                            <input type="text" name="model" id="model" class="form-control"
                                placeholder="Avanza, Civic, dll." value="{{ old('model') }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="harga" class="font-weight-bold small text-uppercase text-muted">Harga (Rp)</label>
                            <input type="number" name="harga" id="harga" class="form-control"
                                placeholder="0" value="{{ old('harga') }}" min="0" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="stok" class="font-weight-bold small text-uppercase text-muted">Stok</label>
                            <input type="number" name="stok" id="stok" class="form-control"
                                placeholder="0" value="{{ old('stok') }}" min="0" required>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <a href="{{ route('mobils.index') }}" class="btn btn-secondary ml-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
