@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('page-title', 'Data Pelanggan')
@section('page-subtitle', 'Kelola data pelanggan dan histori transaksi sewa')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-users mr-2"></i>Daftar Pelanggan
        </h6>
        <a href="{{ route('pelanggans.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Pelanggan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $index => $pelanggan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-primary mr-2" style="width:32px;height:32px;">
                                    <span class="text-white font-weight-bold small">
                                        {{ strtoupper(substr($pelanggan->nama, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="font-weight-bold">{{ $pelanggan->nama }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $pelanggan->alamat }}</td>
                        <td><span class="badge badge-success"><i class="fas fa-phone mr-1"></i>{{ $pelanggan->no_telepon }}</span></td>
                        <td>
                            <a href="{{ route('pelanggans.edit', $pelanggan->id_pelanggan) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('pelanggans.destroy', $pelanggan->id_pelanggan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
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
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Belum ada data pelanggan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
