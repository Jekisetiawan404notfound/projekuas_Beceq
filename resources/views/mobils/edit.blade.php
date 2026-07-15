@extends('layouts.app')

@section('title', 'Edit Mobil')
@section('page-title', 'Edit Mobil')
@section('page-subtitle', 'Perbarui data kendaraan')

@section('content')
{{-- Menampilkan form edit mobil untuk memperbarui data kendaraan --}}
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-edit mr-2"></i>Form Edit Mobil
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

                <form action="{{ route('mobils.update', $mobil->id_mobil) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="kategori_id" class="font-weight-bold small text-uppercase text-muted">Kategori</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id_kategori }}"
                                    {{ old('kategori_id', $mobil->kategori_id) == $kategori->id_kategori ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="merek" class="font-weight-bold small text-uppercase text-muted">Merek</label>
                            <input type="text" name="merek" id="merek" class="form-control"
                                value="{{ old('merek', $mobil->merek) }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="model" class="font-weight-bold small text-uppercase text-muted">Model</label>
                            <input type="text" name="model" id="model" class="form-control"
                                value="{{ old('model', $mobil->model) }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="harga" class="font-weight-bold small text-uppercase text-muted">Harga (Rp)</label>
                            <input type="number" name="harga" id="harga" class="form-control"
                                value="{{ old('harga', $mobil->harga) }}" min="0" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="stok" class="font-weight-bold small text-uppercase text-muted">Stok</label>
                            <input type="number" name="stok" id="stok" class="form-control"
                                value="{{ old('stok', $mobil->stok) }}" min="0" required>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                    <a href="{{ route('mobils.index') }}" class="btn btn-secondary ml-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
