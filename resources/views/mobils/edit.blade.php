@extends('layouts.app')

@section('title', 'Edit Mobil')
@section('page-title', 'Edit Mobil')
@section('page-subtitle', 'Perbarui data kendaraan')

@section('content')
<div class="card" style="max-width: 640px;">
    <div class="card-header">
        <span class="card-title">✏️ Form Edit Mobil</span>
        <a href="{{ route('mobils.index') }}" class="btn btn-outline btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <span>❌ {{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('mobils.update', $mobil->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ old('kategori_id', $mobil->kategori_id) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Merek</label>
                    <input type="text" name="merek" id="merek" class="form-control"
                        value="{{ old('merek', $mobil->merek) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Model</label>
                    <input type="text" name="model" id="model" class="form-control"
                        value="{{ old('model', $mobil->model) }}" required>
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" class="form-control"
                        value="{{ old('harga', $mobil->harga) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control"
                        value="{{ old('stok', $mobil->stok) }}" min="0" required>
                </div>
            </div>
            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="btn btn-primary">💾 Update</button>
                <a href="{{ route('mobils.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
