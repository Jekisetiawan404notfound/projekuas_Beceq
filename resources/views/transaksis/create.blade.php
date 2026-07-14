@extends('layouts.app')

@section('title', 'Tambah Transaksi')
@section('page-title', 'Tambah Transaksi')
@section('page-subtitle', 'Buat transaksi penjualan baru')

@section('content')
<div class="card" style="max-width: 680px;">
    <div class="card-header">
        <span class="card-title">🧾 Form Tambah Transaksi</span>
        <a href="{{ route('transaksis.index') }}" class="btn btn-outline btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <span>❌ {{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('transaksis.store') }}" method="POST" id="formTransaksi">
            @csrf
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Pelanggan</label>
                    <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
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
                            <option value="{{ $admin->id }}" {{ old('admin_id') == $admin->id ? 'selected' : '' }}>
                                {{ $admin->username }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Transaksi</label>
                <input type="date" name="tgl_transaksi" id="tgl_transaksi" class="form-control"
                    value="{{ old('tgl_transaksi', date('Y-m-d')) }}" required>
            </div>

            <hr style="border:none;border-top:1px solid var(--border-color);margin:20px 0;">
            <p style="font-size:14px;font-weight:700;margin-bottom:16px;color:var(--text-main);">🚗 Detail Mobil</p>

            <div class="form-group">
                <label class="form-label">Pilih Mobil</label>
                <select name="mobil_id" id="mobil_id" class="form-control" required onchange="hitungSubtotal()">
                    <option value="">-- Pilih Mobil (Stok Tersedia) --</option>
                    @foreach($mobils as $mobil)
                        <option value="{{ $mobil->id }}"
                            data-harga="{{ $mobil->harga }}"
                            data-stok="{{ $mobil->stok }}"
                            {{ old('mobil_id') == $mobil->id ? 'selected' : '' }}>
                            {{ $mobil->merek }} {{ $mobil->model }} — Rp {{ number_format($mobil->harga, 0, ',', '.') }} (Stok: {{ $mobil->stok }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Jumlah Beli</label>
                    <input type="number" name="jumlah_beli" id="jumlah_beli" class="form-control"
                        placeholder="0" value="{{ old('jumlah_beli', 1) }}" min="1" required onchange="hitungSubtotal()">
                </div>
                <div class="form-group">
                    <label class="form-label">Estimasi Subtotal</label>
                    <input type="text" id="preview_subtotal" class="form-control"
                        value="Rp 0" readonly
                        style="background:#f8fafc; font-weight:700; color:var(--primary);">
                </div>
            </div>

            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="btn btn-primary">💾 Simpan Transaksi</button>
                <a href="{{ route('transaksis.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function hitungSubtotal() {
    const mobilSelect = document.getElementById('mobil_id');
    const jumlah = parseInt(document.getElementById('jumlah_beli').value) || 0;
    const selectedOption = mobilSelect.options[mobilSelect.selectedIndex];
    const harga = parseInt(selectedOption.dataset.harga) || 0;
    const subtotal = harga * jumlah;
    document.getElementById('preview_subtotal').value =
        'Rp ' + subtotal.toLocaleString('id-ID');
}
document.addEventListener('DOMContentLoaded', hitungSubtotal);
</script>
@endpush
@endsection
