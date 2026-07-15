<!DOCTYPE html>
<html lang="id">
<head>
{{-- Menampilkan halaman login admin untuk akses panel administrator --}}
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-box">
        <h3>Login Admin</h3>

        @if ($errors->any())
            <p class="error-text">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ url('/admin/login') }}">
            @csrf

            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" value="{{ old('username') }}">

            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password">

            <button class="btn" type="submit">Login</button>
        </form>

        <div class="auth-link">
            Login sebagai pelanggan? <a href="{{ url('/login') }}">Klik di sini</a>
        </div>
    </div>
</body>
</html>
