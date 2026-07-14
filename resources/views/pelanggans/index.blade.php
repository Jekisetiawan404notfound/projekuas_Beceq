@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('page-title', 'Data Pelanggan')
@section('page-subtitle', 'Kelola data pelanggan')

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">👥 Daftar Pelanggan</span>
        <a href="{{ route('pelanggans.create') }}" class="btn btn-primary btn-sm">
            ➕ Tambah Pelanggan
        </a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggans as $index => $pelanggan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="avatar" style="width:32px;height:32px;font-size:13px;background:#d1fae5;color:#065f46;">
                                {{ strtoupper(substr($pelanggan->nama, 0, 1)) }}
                            </div>
                            <span style="font-weight:600;">{{ $pelanggan->nama }}</span>
                        </div>
                    </td>
                    <td style="color:var(--text-muted); max-width:200px;">{{ $pelanggan->alamat }}</td>
                    <td><span class="badge badge-success">📞 {{ $pelanggan->no_telepon }}</span></td>
                    <td>
                        <div style="display:flex; gap:8px;">
                            <a href="{{ route('pelanggans.edit', $pelanggan->id) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                            <form action="{{ route('pelanggans.destroy', $pelanggan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:40px; color:var(--text-muted);">
                        Belum ada data pelanggan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
