@extends('layouts.app')

@section('title', 'Tambah Detail Transaksi')
@section('page-title', 'Tambah Detail Transaksi')
@section('page-subtitle', 'Tambahkan item mobil ke dalam transaksi')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list-alt mr-2"></i>Form Tambah Detail Transaksi
                </h6>
                <a href="{{ route('detail-transaksis.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('detail-transaksis.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="transaksi_id" class="font-weight-bold small text-uppercase text-muted">Transaksi</label>
                        <select name="transaksi_id" id="transaksi_id" class="form-control" required>
                            <option value="">-- Pilih Transaksi --</option>
                            @foreach($transaksis as $transaksi)
                                <option value="{{ $transaksi->id_transaksi }}" {{ old('transaksi_id') == $transaksi->id_transaksi ? 'selected' : '' }}>
                                    #{{ $transaksi->id_transaksi }} — {{ $transaksi->pelanggan->nama ?? 'N/A' }}
                                    ({{ \Carbon\Carbon::parse($transaksi->tgl_transaksi)->format('d M Y') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mobil_id" class="font-weight-bold small text-uppercase text-muted">Pilih Mobil</label>
                        <select name="mobil_id" id="mobil_id" class="form-control" required onchange="hitungSubtotal()">
                            <option value="">-- Pilih Mobil --</option>
                            @foreach($mobils as $mobil)
                                <option value="{{ $mobil->id_mobil }}"
                                    data-harga="{{ $mobil->harga }}"
                                    data-stok="{{ $mobil->stok }}"
                                    {{ old('mobil_id') == $mobil->id_mobil ? 'selected' : '' }}>
                                    {{ $mobil->merek }} {{ $mobil->model }}
                                    — Rp {{ number_format($mobil->harga, 0, ',', '.') }}
                                    (Stok: {{ $mobil->stok }})
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
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <a href="{{ route('detail-transaksis.index') }}" class="btn btn-secondary ml-2">Batal</a>
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
