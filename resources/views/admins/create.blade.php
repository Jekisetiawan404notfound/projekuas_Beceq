@extends('layouts.app')

@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Admin')
@section('page-subtitle', 'Buat akun administrator baru')

@section('content')
<div class="card" style="max-width: 560px;">
    <div class="card-header">
        <span class="card-title">👤 Form Tambah Admin</span>
        <a href="{{ route('admins.index') }}" class="btn btn-outline btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <span>❌ {{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('admins.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control"
                    placeholder="Masukkan username" value="{{ old('username') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control"
                    placeholder="Masukkan password" required>
            </div>
            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
                <a href="{{ route('admins.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
