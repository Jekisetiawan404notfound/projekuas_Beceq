@extends('layouts.app')

@section('title', 'Kategori Mobil')
@section('page-title', 'Kategori Mobil')
@section('page-subtitle', 'Kelola kategori produk mobil')

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">📂 Daftar Kategori</span>
        <a href="{{ route('kategori-mobils.create') }}" class="btn btn-primary btn-sm">
            ➕ Tambah Kategori
        </a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $index => $kategori)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <span class="badge badge-primary" style="font-size:13px; padding:6px 12px;">
                            📂 {{ $kategori->nama_kategori }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:8px;">
                            <a href="{{ route('kategori-mobils.edit', $kategori->id) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                            <form action="{{ route('kategori-mobils.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align:center; padding:40px; color:var(--text-muted);">
                        Belum ada data kategori.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
