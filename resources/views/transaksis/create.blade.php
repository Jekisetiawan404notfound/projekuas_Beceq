@extends('layouts.app')

@section('title', 'Tambah Transaksi')
@section('page-title', 'Tambah Transaksi')
@section('page-subtitle', 'Buat transaksi penjualan baru')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-file-invoice-dollar mr-2"></i>Form Tambah Transaksi
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

                <form action="{{ route('transaksis.store') }}" method="POST" id="formTransaksi">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pelanggan_id" class="font-weight-bold small text-uppercase text-muted">Pelanggan</label>
                            <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id_pelanggan }}" {{ old('pelanggan_id') == $pelanggan->id_pelanggan ? 'selected' : '' }}>
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
                                    <option value="{{ $admin->id_admin }}" {{ old('admin_id') == $admin->id_admin ? 'selected' : '' }}>
                                        {{ $admin->username }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_transaksi" class="font-weight-bold small text-uppercase text-muted">Tanggal Transaksi</label>
                        <input type="date" name="tgl_transaksi" id="tgl_transaksi" class="form-control"
                            value="{{ old('tgl_transaksi', date('Y-m-d')) }}" required>
                    </div>

                    <hr>
                    <p class="font-weight-bold text-primary mb-3">
                        <i class="fas fa-car mr-1"></i> Detail Mobil
                    </p>

                    <div class="form-group">
                        <label for="mobil_id" class="font-weight-bold small text-uppercase text-muted">Pilih Mobil</label>
                        <select name="mobil_id" id="mobil_id" class="form-control" required onchange="hitungSubtotal()">
                            <option value="">-- Pilih Mobil (Stok Tersedia) --</option>
                            @foreach($mobils as $mobil)
                                <option value="{{ $mobil->id_mobil }}"
                                    data-harga="{{ $mobil->harga }}"
                                    data-stok="{{ $mobil->stok }}"
                                    {{ old('mobil_id') == $mobil->id_mobil ? 'selected' : '' }}>
                                    {{ $mobil->merek }} {{ $mobil->model }} — Rp {{ number_format($mobil->harga, 0, ',', '.') }} (Stok: {{ $mobil->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="jumlah_beli" class="font-weight-bold small text-uppercase text-muted">Jumlah Beli</label>
                            <input type="number" name="jumlah_beli" id="jumlah_beli" class="form-control"
                                placeholder="0" value="{{ old('jumlah_beli', 1) }}" min="1" required onchange="hitungSubtotal()">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold small text-uppercase text-muted">Estimasi Subtotal</label>
                            <input type="text" id="preview_subtotal" class="form-control font-weight-bold text-primary"
                                value="Rp 0" readonly style="background:#f8f9fc;">
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Transaksi
                    </button>
                    <a href="{{ route('transaksis.index') }}" class="btn btn-secondary ml-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function hitungSubtotal() {
    const mobilSelect = document.getElementById('mobil_id');
    const jumlah = parseInt(document.getElementById('jumlah_beli').value) || 0;
    const selectedOption = mobilSelect.options[mobilSelect.selectedIndex];
    const harga = parseInt(selectedOption.dataset.harga) || 0;
    const subtotal = harga * jumlah;
    document.getElementById('preview_subtotal').value = 'Rp ' + subtotal.toLocaleString('id-ID');
}
document.addEventListener('DOMContentLoaded', hitungSubtotal);
</script>
@endpush
