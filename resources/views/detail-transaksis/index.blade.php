@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', 'Kelola detail item setiap transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">📋 Daftar Detail Transaksi</span>
        <a href="{{ route('detail-transaksis.create') }}" class="btn btn-primary btn-sm">
            ➕ Tambah Detail
        </a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Mobil</th>
                    <th>Jumlah Beli</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <span class="badge badge-primary">
                            #{{ $detail->transaksi_id }}
                        </span>
                    </td>
                    <td style="font-weight:600;">
                        {{ $detail->transaksi->pelanggan->nama ?? '-' }}
                    </td>
                    <td>
                        <div>
                            <span style="font-weight:600;">{{ $detail->mobil->merek ?? '-' }}</span>
                            <span style="color:var(--text-muted);"> {{ $detail->mobil->model ?? '' }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-warning">{{ $detail->jumlah_beli }} unit</span>
                    </td>
                    <td style="font-weight:700; color:var(--success);">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </td>
                    <td>
                        <div style="display:flex; gap:8px;">
                            <a href="{{ route('detail-transaksis.edit', $detail->id) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                            <form action="{{ route('detail-transaksis.destroy', $detail->id) }}" method="POST" onsubmit="return confirm('Yakin hapus detail ini? Stok akan dikembalikan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:40px; color:var(--text-muted);">
                        Belum ada data detail transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
