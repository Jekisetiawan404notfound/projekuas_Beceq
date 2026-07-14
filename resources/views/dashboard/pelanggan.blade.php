<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pelanggan</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-box">
        <h3>Selamat datang, {{ auth('pelanggan')->user()->nama }}!</h3>
        <p style="text-align:center;">Anda login sebagai pelanggan.</p>

        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button class="btn" type="submit">Logout</button>
        </form>
    </div>
</body>
</html>
