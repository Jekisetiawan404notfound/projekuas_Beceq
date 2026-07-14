@extends('layouts.app')

@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Admin')
@section('page-subtitle', 'Buat akun administrator baru')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-plus mr-2"></i>Form Tambah Admin
                </h6>
                <a href="{{ route('admins.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('admins.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username" class="font-weight-bold small text-uppercase text-muted">Username</label>
                        <input type="text" name="username" id="username" class="form-control"
                            placeholder="Masukkan username" value="{{ old('username') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="font-weight-bold small text-uppercase text-muted">Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukkan password" required>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <a href="{{ route('admins.index') }}" class="btn btn-secondary ml-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
