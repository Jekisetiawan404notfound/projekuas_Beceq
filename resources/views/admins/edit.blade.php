@extends('layouts.app')

@section('title', 'Edit Admin')
@section('page-title', 'Edit Admin')
@section('page-subtitle', 'Perbarui data administrator')

@section('content')
<div class="card" style="max-width: 560px;">
    <div class="card-header">
        <span class="card-title">✏️ Form Edit Admin</span>
        <a href="{{ route('admins.index') }}" class="btn btn-outline btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <span>❌ {{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('admins.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control"
                    value="{{ old('username', $admin->username) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password Baru <span style="color:var(--text-muted); font-weight:400;">(kosongkan jika tidak ingin mengubah)</span></label>
                <input type="password" name="password" id="password" class="form-control"
                    placeholder="Masukkan password baru">
            </div>
            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="btn btn-primary">💾 Update</button>
                <a href="{{ route('admins.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
