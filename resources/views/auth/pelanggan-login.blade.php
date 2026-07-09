<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Pelanggan</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-box">
        <h3>Login Pelanggan</h3>

        @if (session('success'))
            <p class="success-text">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <p class="error-text">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" value="{{ old('username') }}">

            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password">

            <button class="btn" type="submit">Login</button>
        </form>

        <div class="auth-link">
            Belum punya akun? <a href="{{ url('/register') }}">Daftar</a>
        </div>
        <div class="auth-link">
            Login sebagai admin? <a href="{{ url('/admin/login') }}">Klik di sini</a>
        </div>
    </div>
</body>
</html>
