@extends('layouts.app')

@section('title', 'Tambah Detail Transaksi')
@section('page-title', 'Tambah Detail Transaksi')
@section('page-subtitle', 'Tambahkan item mobil ke dalam transaksi')

@section('content')
<div class="card" style="max-width: 680px;">
    <div class="card-header">
        <span class="card-title">📋 Form Tambah Detail Transaksi</span>
        <a href="{{ route('detail-transaksis.index') }}" class="btn btn-outline btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <span>❌ {{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('detail-transaksis.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Transaksi</label>
                <select name="transaksi_id" id="transaksi_id" class="form-control" required>
                    <option value="">-- Pilih Transaksi --</option>
                    @foreach($transaksis as $transaksi)
                        <option value="{{ $transaksi->id }}" {{ old('transaksi_id') == $transaksi->id ? 'selected' : '' }}>
                            #{{ $transaksi->id }} — {{ $transaksi->pelanggan->nama ?? 'N/A' }}
                            ({{ \Carbon\Carbon::parse($transaksi->tgl_transaksi)->format('d M Y') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Pilih Mobil</label>
                <select name="mobil_id" id="mobil_id" class="form-control" required onchange="hitungSubtotal()">
                    <option value="">-- Pilih Mobil --</option>
                    @foreach($mobils as $mobil)
                        <option value="{{ $mobil->id }}"
                            data-harga="{{ $mobil->harga }}"
                            data-stok="{{ $mobil->stok }}"
                            {{ old('mobil_id') == $mobil->id ? 'selected' : '' }}>
                            {{ $mobil->merek }} {{ $mobil->model }}
                            — Rp {{ number_format($mobil->harga, 0, ',', '.') }}
                            (Stok: {{ $mobil->stok }})
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
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
                <a href="{{ route('detail-transaksis.index') }}" class="btn btn-outline">Batal</a>
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
