@extends('layouts.app')

@section('title', 'Tambah Pelanggan')
@section('page-title', 'Tambah Pelanggan')
@section('page-subtitle', 'Daftarkan pelanggan baru')

@section('content')
<div class="card" style="max-width: 560px;">
    <div class="card-header">
        <span class="card-title">👥 Form Tambah Pelanggan</span>
        <a href="{{ route('pelanggans.index') }}" class="btn btn-outline btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <span>❌ {{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('pelanggans.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control"
                    placeholder="Masukkan nama lengkap" value="{{ old('nama') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3"
                    placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">No. Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon" class="form-control"
                    placeholder="Contoh: 08123456789" value="{{ old('no_telepon') }}" required>
            </div>
            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
                <a href="{{ route('pelanggans.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
