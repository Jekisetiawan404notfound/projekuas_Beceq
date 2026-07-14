@extends('layouts.app')

@section('title', 'Data Transaksi')
@section('page-title', 'Data Transaksi')
@section('page-subtitle', 'Kelola semua transaksi penjualan mobil')

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">🧾 Daftar Transaksi</span>
        <a href="{{ route('transaksis.create') }}" class="btn btn-primary btn-sm">
            ➕ Tambah Transaksi
        </a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Admin</th>
                    <th>Total Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $index => $transaksi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <span class="badge badge-primary">
                            📅 {{ \Carbon\Carbon::parse($transaksi->tgl_transaksi)->format('d M Y') }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div class="avatar" style="width:28px;height:28px;font-size:12px;background:#d1fae5;color:#065f46;">
                                {{ strtoupper(substr($transaksi->pelanggan->nama ?? 'P', 0, 1)) }}
                            </div>
                            <span style="font-weight:600;">{{ $transaksi->pelanggan->nama ?? '-' }}</span>
                        </div>
                    </td>
                    <td style="color:var(--text-muted);">{{ $transaksi->admin->username ?? '-' }}</td>
                    <td style="font-weight:700; color:var(--success);">
                        Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                    </td>
                    <td>
                        <div style="display:flex; gap:8px;">
                            <a href="{{ route('transaksis.edit', $transaksi->id) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                            <form action="{{ route('transaksis.destroy', $transaksi->id) }}" method="POST" onsubmit="return confirm('Yakin hapus transaksi ini? Stok akan dikembalikan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:40px; color:var(--text-muted);">
                        Belum ada data transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
