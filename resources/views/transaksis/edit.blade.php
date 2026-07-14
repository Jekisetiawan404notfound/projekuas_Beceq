@extends('layouts.app')

@section('title', 'Edit Transaksi')
@section('page-title', 'Edit Transaksi')
@section('page-subtitle', 'Perbarui data transaksi')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-edit mr-2"></i>Form Edit Transaksi
                </h6>
                <a href="{{ route('transaksis.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    Edit hanya mengubah data pelanggan, admin, dan tanggal. Untuk mengubah detail mobil, kelola di menu <strong>Detail Transaksi</strong>.
                </div>

                <form action="{{ route('transaksis.update', $transaksi->id_transaksi) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pelanggan_id" class="font-weight-bold small text-uppercase text-muted">Pelanggan</label>
                            <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id_pelanggan }}"
                                        {{ old('pelanggan_id', $transaksi->pelanggan_id) == $pelanggan->id_pelanggan ? 'selected' : '' }}>
                                        {{ $pelanggan->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="admin_id" class="font-weight-bold small text-uppercase text-muted">Admin</label>
                            <select name="admin_id" id="admin_id" class="form-control" required>
                                <option value="">-- Pilih Admin --</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id_admin }}"
                                        {{ old('admin_id', $transaksi->admin_id) == $admin->id_admin ? 'selected' : '' }}>
                                        {{ $admin->username }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_transaksi" class="font-weight-bold small text-uppercase text-muted">Tanggal Transaksi</label>
                        <input type="date" name="tgl_transaksi" id="tgl_transaksi" class="form-control"
                            value="{{ old('tgl_transaksi', $transaksi->tgl_transaksi) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold small text-uppercase text-muted">Total Bayar (Info)</label>
                        <input type="text" class="form-control font-weight-bold text-success"
                            value="Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}"
                            readonly style="background:#f8f9fc;">
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                    <a href="{{ route('transaksis.index') }}" class="btn btn-secondary ml-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
