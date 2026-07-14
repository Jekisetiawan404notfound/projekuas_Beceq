@extends('layouts.app')

@section('title', 'Edit Pelanggan')
@section('page-title', 'Edit Pelanggan')
@section('page-subtitle', 'Perbarui data pelanggan')

@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-edit mr-2"></i>Form Edit Pelanggan
                </h6>
                <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('pelanggans.update', $pelanggan->id_pelanggan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama" class="font-weight-bold small text-uppercase text-muted">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            value="{{ old('nama', $pelanggan->nama) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="font-weight-bold small text-uppercase text-muted">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3"
                            required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_telepon" class="font-weight-bold small text-uppercase text-muted">No. Telepon</label>
                        <input type="text" name="no_telepon" id="no_telepon" class="form-control"
                            value="{{ old('no_telepon', $pelanggan->no_telepon) }}" required>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                    <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary ml-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
