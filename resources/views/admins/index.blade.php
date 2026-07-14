@extends('layouts.app')

@section('title', 'Data Admin')
@section('page-title', 'Data Admin')
@section('page-subtitle', 'Kelola akun administrator sistem')

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">👤 Daftar Admin</span>
        <a href="{{ route('admins.create') }}" class="btn btn-primary btn-sm">
            ➕ Tambah Admin
        </a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $index => $admin)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="avatar" style="width:32px;height:32px;font-size:13px;background:var(--primary-light);color:var(--primary);">
                                {{ strtoupper(substr($admin->username, 0, 1)) }}
                            </div>
                            <span style="font-weight:600;">{{ $admin->username }}</span>
                        </div>
                    </td>
                    <td><span class="badge badge-primary">{{ $admin->created_at->format('d M Y') }}</span></td>
                    <td>
                        <div style="display:flex; gap:8px;">
                            <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                            <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Yakin hapus admin ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:40px; color:var(--text-muted);">
                        Belum ada data admin.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
