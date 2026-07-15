@extends('layouts.app')

@section('title', 'Riwayat Sewa')
@section('page-title', 'Riwayat Penyewaan Saya')
@section('page-subtitle', 'Daftar semua transaksi sewa mobil Anda')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-history mr-2"></i>Daftar Transaksi Saya
        </h6>
        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-car mr-1"></i> Sewa Mobil Baru
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="50">#</th>
                        <th>No. Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Mobil Yang Disewa</th>
                        <th>Jumlah Unit</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $index => $transaksi)
                        @php
                            // Get details
                            $detail = $transaksi->detail_transaksis->first();
                            $mobil = $detail->mobil ?? null;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="font-weight-bold text-primary">
                                    #{{ $transaksi->id_transaksi ?? $transaksi->id }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-secondary py-1 px-2">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    {{ \Carbon\Carbon::parse($transaksi->tgl_transaksi)->translatedFormat('d M Y') }}
                                </span>
                            </td>
                            <td>
                                @if($mobil)
                                    <div class="font-weight-bold text-gray-800">
                                        {{ $mobil->merek }}
                                    </div>
                                    <small class="text-muted">{{ $mobil->model }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-warning">
                                    {{ $detail->jumlah_beli ?? 0 }} Unit
                                </span>
                            </td>
                            <td class="font-weight-bold text-success">
                                Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge badge-success px-2 py-1">Selesai</span>
                            </td>
                            <td>
                                <a href="{{ route('pelanggan.transaksi.detail', $transaksi->id_transaksi ?? $transaksi->id) }}" class="btn btn-info btn-sm btn-block font-weight-bold">
                                    <i class="fas fa-info-circle mr-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                <h5>Belum ada riwayat transaksi sewa.</h5>
                                <p>Silakan sewa armada mobil kami di halaman katalog.</p>
                                <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-primary btn-sm mt-2">
                                    Lihat Katalog Mobil
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
