@extends('layouts.app')

@section('title', 'Data Mobil')
@section('page-title', 'Data Mobil')
@section('page-subtitle', 'Kelola inventaris kendaraan')

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">🚗 Daftar Mobil</span>
        <a href="{{ route('mobils.create') }}" class="btn btn-primary btn-sm">
            ➕ Tambah Mobil
        </a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kategori</th>
                    <th>Merek</th>
                    <th>Model</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mobils as $index => $mobil)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><span class="badge badge-primary">{{ $mobil->kategori->nama_kategori ?? '-' }}</span></td>
                    <td style="font-weight:600;">{{ $mobil->merek }}</td>
                    <td>{{ $mobil->model }}</td>
                    <td style="font-weight:600; color:var(--primary);">
                        Rp {{ number_format($mobil->harga, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($mobil->stok > 5)
                            <span class="badge badge-success">{{ $mobil->stok }} unit</span>
                        @elseif($mobil->stok > 0)
                            <span class="badge badge-warning">{{ $mobil->stok }} unit</span>
                        @else
                            <span class="badge badge-danger">Habis</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:8px;">
                            <a href="{{ route('mobils.edit', $mobil->id) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                            <form action="{{ route('mobils.destroy', $mobil->id) }}" method="POST" onsubmit="return confirm('Yakin hapus mobil ini?')">
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
                        Belum ada data mobil.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
