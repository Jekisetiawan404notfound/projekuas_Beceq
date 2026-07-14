@extends('layouts.app')

@section('title', 'Edit Admin')
@section('page-title', 'Edit Admin')
@section('page-subtitle', 'Perbarui data administrator')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-edit mr-2"></i>Form Edit Admin
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

                <form action="{{ route('admins.update', $admin->id_admin) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="username" class="font-weight-bold small text-uppercase text-muted">Username</label>
                        <input type="text" name="username" id="username" class="form-control"
                            value="{{ old('username', $admin->username) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="font-weight-bold small text-uppercase text-muted">
                            Password Baru
                            <small class="text-muted font-weight-normal">(kosongkan jika tidak ingin mengubah)</small>
                        </label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukkan password baru">
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                    <a href="{{ route('admins.index') }}" class="btn btn-secondary ml-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
