@extends('layouts.app')

@section('title', 'Edit Transaksi')
@section('page-title', 'Edit Transaksi')
@section('page-subtitle', 'Perbarui data transaksi')

@section('content')
<div class="card" style="max-width: 640px;">
    <div class="card-header">
        <span class="card-title">✏️ Form Edit Transaksi</span>
        <a href="{{ route('transaksis.index') }}" class="btn btn-outline btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <span>❌ {{ $errors->first() }}</span>
            </div>
        @endif

        <div class="alert alert-success" style="margin-bottom:20px;">
            <span>💡 Edit hanya mengubah data pelanggan, admin, dan tanggal. Untuk mengubah detail mobil, kelola di menu Detail Transaksi.</span>
        </div>

        <form action="{{ route('transaksis.update', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Pelanggan</label>
                    <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}"
                                {{ old('pelanggan_id', $transaksi->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                                {{ $pelanggan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Admin</label>
                    <select name="admin_id" id="admin_id" class="form-control" required>
                        <option value="">-- Pilih Admin --</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}"
                                {{ old('admin_id', $transaksi->admin_id) == $admin->id ? 'selected' : '' }}>
                                {{ $admin->username }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Transaksi</label>
                <input type="date" name="tgl_transaksi" id="tgl_transaksi" class="form-control"
                    value="{{ old('tgl_transaksi', $transaksi->tgl_transaksi) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Total Bayar (info)</label>
                <input type="text" class="form-control"
                    value="Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}"
                    readonly style="background:#f8fafc; font-weight:700; color:var(--success);">
            </div>
            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="btn btn-primary">💾 Update</button>
                <a href="{{ route('transaksis.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
