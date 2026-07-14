@extends('layouts.app')

@section('title', 'Data Mobil')
@section('page-title', 'Data Mobil')
@section('page-subtitle', 'Kelola inventaris kendaraan')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-car mr-2"></i>Daftar Mobil
        </h6>
        <a href="{{ route('mobils.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Mobil
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Kategori</th>
                        <th>Merek</th>
                        <th>Model</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mobils as $index => $mobil)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge badge-primary">{{ $mobil->kategori->nama_kategori ?? '-' }}</span></td>
                        <td class="font-weight-bold">{{ $mobil->merek }}</td>
                        <td>{{ $mobil->model }}</td>
                        <td class="font-weight-bold text-primary">
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
                            <a href="{{ route('mobils.edit', $mobil->id_mobil) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('mobils.destroy', $mobil->id_mobil) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus mobil ini?')">
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
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Belum ada data mobil.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
