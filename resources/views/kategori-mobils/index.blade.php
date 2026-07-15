@extends('layouts.app')

@section('title', 'Kategori Mobil')
@section('page-title', 'Kategori Mobil')
@section('page-subtitle', 'Kelola kategori produk mobil')

@section('content')
{{-- Menampilkan daftar kategori mobil yang tersedia --}}
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-folder-open mr-2"></i>Daftar Kategori
        </h6>
        <a href="{{ route('kategori-mobils.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Kategori
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Kategori</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $index => $kategori)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="badge badge-primary" style="font-size:13px; padding:6px 12px;">
                                <i class="fas fa-folder mr-1"></i>{{ $kategori->nama_kategori }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('kategori-mobils.edit', $kategori->id_kategori) }}" class="btn btn-warning btn-sm mr-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('kategori-mobils.destroy', $kategori->id_kategori) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Yakin hapus kategori ini?')">
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
                        <td colspan="3" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Belum ada data kategori.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
