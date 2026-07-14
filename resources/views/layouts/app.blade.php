<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="E-Commerce Admin Dashboard">
    <title>E-Shop Dashboard &mdash; @yield('title', 'Admin')</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            
            --primary: #4f46e5;
            --primary-light: #e0e7ff;
            --primary-hover: #4338ca;
            
            --success: #10b981;
            --success-light: #d1fae5;
            
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            
            --danger: #ef4444;
            --danger-light: #fee2e2;
            
            --text-main: #0f172a;
            --text-muted: #64748b;
            --sidebar-width: 260px;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-width);
            background: #ffffff;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background: var(--primary);
            color: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }

        .sidebar-menu {
            padding: 20px 16px;
            flex: 1;
            overflow-y: auto;
        }

        .menu-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            margin-bottom: 12px;
            padding-left: 8px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
            margin-bottom: 4px;
        }

        .menu-item:hover {
            background-color: #f1f5f9;
            color: var(--text-main);
        }

        .menu-item.active {
            background-color: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
        }

        .menu-icon {
            font-size: 16px;
        }

        /* ── MAIN CONTENT ── */
        .main {
            margin-left: var(--sidebar-width);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .page-title h1 {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .page-title p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--text-main);
        }

        /* ── PAGE CONTENT ── */
        .content {
            padding: 32px;
            flex: 1;
        }

        /* ── CARDS & SECTIONS ── */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
        }

        .card-body {
            padding: 24px;
        }

        /* ── STATS CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-sm);
        }

        .stat-info .label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
        }

        .stat-info .value {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-main);
            margin-top: 6px;
            letter-spacing: -1px;
        }

        .stat-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* ── TABLES ── */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #f8fafc;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 16px 24px;
            font-size: 14px;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: var(--primary);
            color: #ffffff;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .btn-warning {
            background: #fffbeb;
            border-color: #fde68a;
            color: #b45309;
        }

        .btn-warning:hover {
            background: #fef3c7;
        }

        .btn-danger {
            background: #fef2f2;
            border-color: #fecaca;
            color: #b91c1c;
        }

        .btn-danger:hover {
            background: #fee2e2;
        }

        .btn-outline {
            background: transparent;
            border-color: var(--border-color);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background: #f8fafc;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 6px;
        }

        /* ── ALERTS ── */
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: var(--success-light);
            color: #065f46;
        }

        .alert-danger {
            background: var(--danger-light);
            color: #991b1b;
        }

        /* ── BADGES ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-primary { background: var(--primary-light); color: var(--primary); }
        .badge-success { background: var(--success-light); color: #065f46; }
        .badge-warning { background: var(--warning-light); color: #92400e; }
        .badge-danger { background: var(--danger-light); color: #991b1b; }

        /* ── FORMS ── */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            color: var(--text-main);
            outline: none;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* ── FOOTER ── */
        .footer {
            padding: 24px 32px;
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            margin-top: auto;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- ── SIDEBAR ── -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">🛍️</div>
            <div class="brand-name">E-Shop Admin</div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-label">Navigasi</div>
            <a href="{{ url('/') }}" class="menu-item {{ request()->is('/') ? 'active' : '' }}">
                <span class="menu-icon">📊</span> Dashboard
            </a>

            <div class="menu-label">Katalog Produk</div>
            <a href="{{ route('kategori-mobils.index') }}" class="menu-item {{ request()->routeIs('kategori-mobils.*') ? 'active' : '' }}">
                <span class="menu-icon">📂</span> Kategori Produk
            </a>
            <a href="{{ route('mobils.index') }}" class="menu-item {{ request()->routeIs('mobils.*') ? 'active' : '' }}">
                <span class="menu-icon">🚗</span> Daftar Mobil
            </a>

            <div class="menu-label">Penjualan</div>
            <a href="{{ route('pelanggans.index') }}" class="menu-item {{ request()->routeIs('pelanggans.*') ? 'active' : '' }}">
                <span class="menu-icon">👥</span> Pelanggan
            </a>
            <a href="{{ route('transaksis.index') }}" class="menu-item {{ request()->routeIs('transaksis.*') ? 'active' : '' }}">
                <span class="menu-icon">🧾</span> Transaksi
            </a>
            <a href="{{ route('detail-transaksis.index') }}" class="menu-item {{ request()->routeIs('detail-transaksis.*') ? 'active' : '' }}">
                <span class="menu-icon">📋</span> Detail Transaksi
            </a>

            <div class="menu-label">Pengaturan</div>
            <a href="{{ route('admins.index') }}" class="menu-item {{ request()->routeIs('admins.*') ? 'active' : '' }}">
                <span class="menu-icon">👤</span> Admin
            </a>
        </nav>
    </aside>

    <!-- ── MAIN ── -->
    <div class="main">
        <header class="topbar">
            <div class="page-title">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>@yield('page-subtitle', 'Pantau performa penjualan E-Shop')</p>
            </div>
            <div class="topbar-actions">
                <div class="user-profile">
                    <div class="avatar">A</div>
                    <span style="font-size: 14px; font-weight: 600;">Administrator</span>
                </div>
            </div>
        </header>

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <span>✅ {{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <span>❌ {{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="footer">
            &copy; {{ date('Y') }} E-Shop System. All rights reserved.
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
