@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', 'Kelola detail item setiap transaksi')

@section('content')
{{-- Menampilkan daftar detail transaksi yang tersimpan --}}
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-list-alt mr-2"></i>Daftar Detail Transaksi
        </h6>
        <a href="{{ route('detail-transaksis.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Detail
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Mobil</th>
                        <th>Jumlah Beli</th>
                        <th>Subtotal</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($details as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="badge badge-primary">
                                <i class="fas fa-hashtag mr-1"></i>{{ $detail->transaksi_id }}
                            </span>
                        </td>
                        <td class="font-weight-bold">
                            {{ $detail->transaksi->pelanggan->nama ?? '-' }}
                        </td>
                        <td>
                            <span class="font-weight-bold">{{ $detail->mobil->merek ?? '-' }}</span>
                            <span class="text-muted">{{ $detail->mobil->model ?? '' }}</span>
                        </td>
                        <td>
                            <span class="badge badge-warning">{{ $detail->jumlah_beli }} unit</span>
                        </td>
                        <td class="font-weight-bold text-success">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('detail-transaksis.edit', $detail->id_detail) }}" class="btn btn-warning btn-sm mr-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('detail-transaksis.destroy', $detail->id_detail) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Yakin hapus detail ini? Stok akan dikembalikan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Belum ada data detail transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
