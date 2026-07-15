<!DOCTYPE html>
<html lang="id">
<head>
{{-- Menampilkan halaman registrasi pelanggan untuk membuat akun baru --}}
    <meta charset="UTF-8">
    <title>Register Pelanggan</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-box">
        <h3>Register Pelanggan</h3>

        @if ($errors->any())
            <p class="error-text">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf

            <label>Nama</label>
            <input type="text" name="nama" placeholder="Masukkan nama" value="{{ old('nama') }}">

            <label>Alamat</label>
            <input type="text" name="alamat" placeholder="Masukkan alamat" value="{{ old('alamat') }}">

            <label>No. Telepon</label>
            <input type="text" name="no_telepon" placeholder="Masukkan no. telepon" value="{{ old('no_telepon') }}">

            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" value="{{ old('username') }}">

            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password">

            <label>Konfirmasi Password</label>
            <input type="password" name="password2" placeholder="Ulangi password">

            <button class="btn" type="submit">Daftar</button>
        </form>

        <div class="auth-link">
            Sudah punya akun? <a href="{{ url('/login') }}">Login</a>
        </div>
    </div>
</body>
</html>
