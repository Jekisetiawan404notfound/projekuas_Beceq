<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-box">
        <h3>Selamat datang, {{ auth('admin')->user()->username }}!</h3>
        <p style="text-align:center;">Anda login sebagai admin.</p>

        <form method="POST" action="{{ url('/admin/logout') }}">
            @csrf
            <button class="btn" type="submit">Logout</button>
        </form>
    </div>
</body>
</html>
