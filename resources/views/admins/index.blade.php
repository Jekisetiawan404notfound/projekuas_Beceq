@extends('layouts.app')

@section('title', 'Data Admin')
@section('page-title', 'Data Admin')
@section('page-subtitle', 'Kelola akun administrator sistem')

@section('content')
{{-- Menampilkan daftar admin yang tersedia dalam sistem --}}
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-user-cog mr-2"></i>Daftar Admin
        </h6>
        <a href="{{ route('admins.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Admin
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $index => $admin)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-primary mr-2" style="width:32px;height:32px;">
                                    <span class="text-white font-weight-bold small">
                                        {{ strtoupper(substr($admin->username, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="font-weight-bold">{{ $admin->username }}</span>
                            </div>
                        </td>
                        <td>
                            @if($admin->role == 'super_admin')
                                <span class="badge badge-danger"><i class="fas fa-crown mr-1"></i>Super Admin</span>
                            @else
                                <span class="badge badge-primary"><i class="fas fa-user mr-1"></i>Admin</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-info">
                                <i class="fas fa-calendar mr-1"></i>{{ $admin->created_at?->format('d M Y') ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('admins.edit', $admin->id_admin) }}" class="btn btn-warning btn-sm mr-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admins.destroy', $admin->id_admin) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Yakin hapus admin ini?')">
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
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Belum ada data admin.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
