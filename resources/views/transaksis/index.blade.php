@extends('layouts.app')

@section('title', 'Data Transaksi')
@section('page-title', 'Data Transaksi')
@section('page-subtitle', 'Kelola semua transaksi penjualan mobil')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-file-invoice-dollar mr-2"></i>Daftar Transaksi
        </h6>
        <a href="{{ route('transaksis.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Transaksi
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Admin</th>
                        <th>Total Bayar</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $index => $transaksi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="badge badge-primary">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ \Carbon\Carbon::parse($transaksi->tgl_transaksi)->format('d M Y') }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-success mr-2" style="width:28px;height:28px;">
                                    <span class="text-white font-weight-bold" style="font-size:11px;">
                                        {{ strtoupper(substr($transaksi->pelanggan->nama ?? 'P', 0, 1)) }}
                                    </span>
                                </div>
                                <span class="font-weight-bold">{{ $transaksi->pelanggan->nama ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="text-muted small">
                            <i class="fas fa-user mr-1"></i>{{ $transaksi->admin->username ?? '-' }}
                        </td>
                        <td class="font-weight-bold text-success">
                            Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                        </td>
                        <td>
                            <a href="{{ route('transaksis.edit', $transaksi->id_transaksi) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('transaksis.destroy', $transaksi->id_transaksi) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus transaksi ini? Stok akan dikembalikan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Belum ada data transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
