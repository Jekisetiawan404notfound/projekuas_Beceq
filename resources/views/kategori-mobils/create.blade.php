@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')
@section('page-subtitle', 'Tambahkan kategori produk mobil baru')

@section('content')
<div class="card" style="max-width: 500px;">
    <div class="card-header">
        <span class="card-title">📂 Form Tambah Kategori</span>
        <a href="{{ route('kategori-mobils.index') }}" class="btn btn-outline btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <span>❌ {{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('kategori-mobils.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control"
                    placeholder="Contoh: SUV, Sedan, MPV..." value="{{ old('nama_kategori') }}" required>
            </div>
            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
                <a href="{{ route('kategori-mobils.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
