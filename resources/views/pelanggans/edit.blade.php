@extends('layouts.app')

@section('title', 'Edit Pelanggan')
@section('page-title', 'Edit Pelanggan')
@section('page-subtitle', 'Perbarui data pelanggan')

@section('content')
<div class="card" style="max-width: 560px;">
    <div class="card-header">
        <span class="card-title">✏️ Form Edit Pelanggan</span>
        <a href="{{ route('pelanggans.index') }}" class="btn btn-outline btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <span>❌ {{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('pelanggans.update', $pelanggan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control"
                    value="{{ old('nama', $pelanggan->nama) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3"
                    required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">No. Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon" class="form-control"
                    value="{{ old('no_telepon', $pelanggan->no_telepon) }}" required>
            </div>
            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="btn btn-primary">💾 Update</button>
                <a href="{{ route('pelanggans.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
