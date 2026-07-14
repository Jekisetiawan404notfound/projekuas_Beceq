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
    <!-- Chart.js for interactive analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* ── THEME DESIGN SYSTEM ── */
        :root {
            /* Light Mode Variables */
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --bg-sidebar: #ffffff;
            --bg-topbar: #ffffff;
            --border-color: #e2e8f0;
            
            --primary: #4f46e5;
            --primary-light: #e0e7ff;
            --primary-hover: #4338ca;
            
            --success: #10b981;
            --success-light: #d1fae5;
            --success-text: #065f46;
            
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --warning-text: #92400e;
            
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --danger-text: #991b1b;
            
            --text-main: #0f172a;
            --text-muted: #64748b;
            --sidebar-width: 260px;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(15, 23, 42, 0.05), 0 4px 6px -4px rgba(15, 23, 42, 0.05);
            --transition-speed: 0.25s;
        }

        [data-theme="dark"] {
            /* Dark Mode Variables */
            --bg-body: #090d16;
            --bg-card: #111827;
            --bg-sidebar: #111827;
            --bg-topbar: #111827;
            --border-color: #1f2937;
            
            --primary: #6366f1;
            --primary-light: rgba(99, 102, 241, 0.15);
            --primary-hover: #4f46e5;
            
            --success: #10b981;
            --success-light: rgba(16, 185, 129, 0.15);
            --success-text: #34d399;
            
            --warning: #fbbf24;
            --warning-light: rgba(251, 191, 36, 0.15);
            --warning-text: #fbbf24;
            
            --danger: #f87171;
            --danger-light: rgba(248, 113, 113, 0.15);
            --danger-text: #f87171;
            
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.5);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.5);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: background-color var(--transition-speed) ease, border-color var(--transition-speed) ease;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-body);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            transition: transform var(--transition-speed) ease, background-color var(--transition-speed) ease;
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
            background: linear-gradient(135deg, var(--primary), #818cf8);
            color: #ffffff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .brand-name {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
            background: linear-gradient(to right, var(--text-main), var(--text-muted));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-menu {
            padding: 20px 16px;
            flex: 1;
            overflow-y: auto;
        }

        .menu-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-top: 20px;
            margin-bottom: 8px;
            padding-left: 12px;
        }

        .menu-label:first-of-type {
            margin-top: 0;
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
            border-radius: 10px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 4px;
        }

        .menu-item:hover {
            background-color: var(--primary-light);
            color: var(--primary);
            transform: translateX(4px);
        }

        .menu-item.active {
            background-color: var(--primary);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }

        .menu-item.active:hover {
            background-color: var(--primary-hover);
            color: #ffffff;
            transform: none;
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
            width: calc(100% - var(--sidebar-width));
            transition: margin-left var(--transition-speed) ease, width var(--transition-speed) ease;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: var(--bg-topbar);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 90;
            backdrop-filter: blur(10px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* Toggle Sidebar Button */
        .toggle-sidebar-btn {
            display: none;
            background: none;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            align-items: center;
            justify-content: center;
        }

        .page-title h1 {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-main);
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

        /* Search input */
        .search-wrapper {
            position: relative;
            display: none;
        }
        @media(min-width: 768px) {
            .search-wrapper {
                display: block;
            }
        }
        .search-input {
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            padding: 8px 16px 8px 36px;
            border-radius: 20px;
            font-size: 13px;
            color: var(--text-main);
            outline: none;
            width: 200px;
            transition: all 0.2s ease;
        }
        .search-input:focus {
            width: 260px;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }
        .search-icon-pos {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
            pointer-events: none;
        }

        /* Dark Mode Button */
        .theme-toggle-btn {
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            cursor: pointer;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            position: relative;
            transition: all 0.2s ease;
        }
        .theme-toggle-btn:hover {
            transform: scale(1.05);
            background: var(--border-color);
        }

        /* Notifications Bell */
        .notification-bell {
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            cursor: pointer;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            position: relative;
            transition: all 0.2s ease;
        }
        .notification-bell:hover {
            transform: scale(1.05);
            background: var(--border-color);
        }
        .bell-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 14px;
            height: 14px;
            background-color: var(--danger);
            border: 2px solid var(--bg-topbar);
            border-radius: 50%;
            display: none;
        }

        /* Notifications Dropdown */
        .notification-dropdown {
            position: absolute;
            top: 55px;
            right: 0;
            width: 320px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            display: none;
            flex-direction: column;
            overflow: hidden;
            z-index: 120;
            animation: slideDown 0.2s ease;
        }
        .notification-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            font-size: 14px;
        }
        .notification-list {
            max-height: 250px;
            overflow-y: auto;
        }
        .notification-item {
            padding: 12px 18px;
            border-bottom: 1px solid var(--border-color);
            font-size: 13px;
            cursor: pointer;
            transition: background 0.2s ease;
            display: flex;
            gap: 12px;
        }
        .notification-item:hover {
            background: var(--bg-body);
        }
        .notification-item:last-child {
            border-bottom: none;
        }
        .notification-footer {
            padding: 10px;
            text-align: center;
            background: var(--bg-body);
            border-top: 1px solid var(--border-color);
        }
        .notification-footer a {
            font-size: 12px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 4px 12px 4px 6px;
            border-radius: 20px;
            transition: background 0.2s ease;
        }
        .user-profile:hover {
            background: var(--bg-body);
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #ffffff;
            font-size: 14px;
        }

        /* ── PAGE CONTENT ── */
        .content {
            padding: 32px;
            flex: 1;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── CARDS & SECTIONS ── */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 24px;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.02);
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-body {
            padding: 24px;
        }

        /* ── STATS CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 4px; height: 100%;
            background: var(--primary);
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-info .label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info .value {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-main);
            margin-top: 6px;
            letter-spacing: -1px;
        }

        .stat-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: var(--primary-light);
            color: var(--primary);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover .stat-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
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
            background: var(--bg-body);
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
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

        tr:hover td {
            background: rgba(79, 70, 229, 0.02);
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
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
            outline: none;
        }

        .btn-primary {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.3);
        }

        .btn-warning {
            background: var(--warning-light);
            border-color: rgba(251, 191, 36, 0.2);
            color: var(--warning-text);
        }

        .btn-warning:hover {
            background: var(--warning);
            color: #ffffff;
        }

        .btn-danger {
            background: var(--danger-light);
            border-color: rgba(248, 113, 113, 0.2);
            color: var(--danger-text);
        }

        .btn-danger:hover {
            background: var(--danger);
            color: #ffffff;
        }

        .btn-outline {
            background: transparent;
            border-color: var(--border-color);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background: var(--border-color);
            color: var(--text-main);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 8px;
        }

        /* ── ALERTS ── */
        .alert {
            padding: 16px 20px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease;
        }

        .alert-success {
            background: var(--success-light);
            color: var(--success-text);
            border-left: 4px solid var(--success);
        }

        .alert-danger {
            background: var(--danger-light);
            color: var(--danger-text);
            border-left: 4px solid var(--danger);
        }

        /* ── BADGES ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .badge-primary { background: var(--primary-light); color: var(--primary); }
        .badge-success { background: var(--success-light); color: var(--success-text); }
        .badge-warning { background: var(--warning-light); color: var(--warning-text); }
        .badge-danger { background: var(--danger-light); color: var(--danger-text); }

        /* ── FORMS ── */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 10px 16px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
            color: var(--text-main);
            outline: none;
            background: var(--bg-card);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* ── TOAST CONTAINER ── */
        #toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 350px;
            width: 100%;
        }

        .toast {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-left: 4px solid var(--primary);
            border-radius: 12px;
            padding: 16px;
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            gap: 4px;
            animation: slideInRight 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        @keyframes slideInRight {
            from { transform: translateX(110%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .toast-header {
            font-weight: 700;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .toast-close {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 16px;
        }
        .toast-body {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* ── FOOTER ── */
        .footer {
            padding: 24px 32px;
            background: var(--bg-card);
            border-top: 1px solid var(--border-color);
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            margin-top: auto;
        }

        /* ── RESPONSIVENESS ── */
        @media(max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main {
                margin-left: 0;
                width: 100%;
            }
            .toggle-sidebar-btn {
                display: flex;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- ── TOAST NOTIFICATION CONTAINER ── -->
    <div id="toast-container"></div>

    <!-- ── SIDEBAR ── -->
    <aside class="sidebar" id="app-sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">🚗</div>
            <div class="brand-name">Beceq Rent</div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-label">Navigasi Utama</div>
            <a href="{{ url('/') }}" class="menu-item {{ request()->is('/') ? 'active' : '' }}">
                <span class="menu-icon">📊</span> Dashboard
            </a>

            <div class="menu-label">Katalog Kendaraan</div>
            <a href="{{ route('kategori-mobils.index') }}" class="menu-item {{ request()->routeIs('kategori-mobils.*') ? 'active' : '' }}">
                <span class="menu-icon">📂</span> Kategori Mobil
            </a>
            <a href="{{ route('mobils.index') }}" class="menu-item {{ request()->routeIs('mobils.*') ? 'active' : '' }}">
                <span class="menu-icon">🚗</span> Daftar Mobil
            </a>

            <div class="menu-label">Penyewaan & Pelanggan</div>
            <a href="{{ route('pelanggans.index') }}" class="menu-item {{ request()->routeIs('pelanggans.*') ? 'active' : '' }}">
                <span class="menu-icon">👥</span> Pelanggan
            </a>
            <a href="{{ route('transaksis.index') }}" class="menu-item {{ request()->routeIs('transaksis.*') ? 'active' : '' }}">
                <span class="menu-icon">🧾</span> Transaksi Sewa
            </a>
            <a href="{{ route('detail-transaksis.index') }}" class="menu-item {{ request()->routeIs('detail-transaksis.*') ? 'active' : '' }}">
                <span class="menu-icon">📋</span> Detail Transaksi
            </a>

            <div class="menu-label">Pengaturan</div>
            <a href="{{ route('admins.index') }}" class="menu-item {{ request()->routeIs('admins.*') ? 'active' : '' }}">
                <span class="menu-icon">👤</span> Manajemen Admin
            </a>
        </nav>
    </aside>

    <!-- ── MAIN CONTENT AREA ── -->
    <div class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button class="toggle-sidebar-btn" id="sidebar-toggle-btn">☰</button>
                <div class="page-title">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                    <p>@yield('page-subtitle', 'Pantau performa rental mobil Beceq Rent')</p>
                </div>
            </div>
            
            <div class="topbar-actions">
                <!-- Search input -->
                <div class="search-wrapper">
                    <span class="search-icon-pos">🔍</span>
                    <input type="text" class="search-input" placeholder="Cari data...">
                </div>

                <!-- Theme Toggle Button -->
                <button class="theme-toggle-btn" id="theme-toggle" title="Ganti Tema">
                    🌙
                </button>

                <!-- Notifications Center -->
                <div style="position: relative;">
                    <button class="notification-bell" id="bell-btn" title="Notifikasi">
                        🔔
                        <span class="bell-badge" id="bell-badge-indicator"></span>
                    </button>
                    <!-- Notification Dropdown -->
                    <div class="notification-dropdown" id="notification-dropdown-menu">
                        <div class="notification-header">
                            <span>Pemberitahuan</span>
                            <span class="badge badge-primary" style="padding: 2px 6px; font-size: 10px;" id="notif-count-badge">0 Baru</span>
                        </div>
                        <div class="notification-list" id="notif-list-container">
                            <div style="padding: 20px; text-align: center; color: var(--text-muted); font-size: 13px;" id="no-notif-msg">
                                Tidak ada notifikasi baru.
                            </div>
                        </div>
                        <div class="notification-footer">
                            <a href="#" onclick="clearAllNotifications(); return false;">Tandai semua dibaca</a>
                        </div>
                    </div>
                </div>

                <!-- User Profile Info -->
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
            &copy; {{ date('Y') }} Beceq Rent System. Built with ❤️ and Modern UI Aesthetics.
        </footer>
    </div>

    <!-- Theme & Dropdown Interactive JavaScript -->
    <script>
        // --- 1. DARK MODE MANAGER ---
        const themeToggleBtn = document.getElementById('theme-toggle');
        const currentTheme = localStorage.getItem('theme') || 'light';

        if (currentTheme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
            themeToggleBtn.textContent = '☀️';
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
            themeToggleBtn.textContent = '🌙';
        }

        themeToggleBtn.addEventListener('click', () => {
            let theme = document.documentElement.getAttribute('data-theme');
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
                themeToggleBtn.textContent = '🌙';
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                themeToggleBtn.textContent = '☀️';
            }
        });

        // --- 2. SIDEBAR RESPONSIVE TOGGLER ---
        const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
        const appSidebar = document.getElementById('app-sidebar');

        if(sidebarToggleBtn && appSidebar) {
            sidebarToggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                appSidebar.classList.toggle('active');
            });
            document.addEventListener('click', (e) => {
                if(appSidebar.classList.contains('active') && !appSidebar.contains(e.target) && e.target !== sidebarToggleBtn) {
                    appSidebar.classList.remove('active');
                }
            });
        }

        // --- 3. NOTIFICATION SYSTEM ---
        const bellBtn = document.getElementById('bell-btn');
        const notifDropdown = document.getElementById('notification-dropdown-menu');
        const bellBadge = document.getElementById('bell-badge-indicator');
        const notifCountBadge = document.getElementById('notif-count-badge');
        const notifListContainer = document.getElementById('notif-list-container');
        const noNotifMsg = document.getElementById('no-notif-msg');

        let notifications = JSON.parse(localStorage.getItem('notif_list')) || [];

        function updateNotifUI() {
            if(notifications.length > 0) {
                bellBadge.style.display = 'block';
                notifCountBadge.textContent = `${notifications.length} Baru`;
                if(noNotifMsg) noNotifMsg.style.display = 'none';
                
                notifListContainer.innerHTML = '';
                notifications.forEach((item, index) => {
                    const el = document.createElement('div');
                    el.className = 'notification-item';
                    el.innerHTML = `
                        <span style="font-size:18px;">${item.icon || '🔔'}</span>
                        <div style="flex:1;">
                            <div style="font-weight:700; color:var(--text-main); margin-bottom:2px;">${item.title}</div>
                            <div style="color:var(--text-muted); font-size:11px;">${item.time}</div>
                        </div>
                    `;
                    notifListContainer.appendChild(el);
                });
            } else {
                bellBadge.style.display = 'none';
                notifCountBadge.textContent = `0 Baru`;
                notifListContainer.innerHTML = `
                    <div style="padding: 20px; text-align: center; color: var(--text-muted); font-size: 13px;" id="no-notif-msg">
                        Tidak ada notifikasi baru.
                    </div>
                `;
            }
        }

        bellBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notifDropdown.style.display = notifDropdown.style.display === 'flex' ? 'none' : 'flex';
        });

        document.addEventListener('click', () => {
            notifDropdown.style.display = 'none';
        });

        notifDropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });

        window.clearAllNotifications = function() {
            notifications = [];
            localStorage.setItem('notif_list', JSON.stringify(notifications));
            updateNotifUI();
            showToast('Notifikasi', 'Semua notifikasi telah dibaca.');
        }

        // --- 4. TOAST EMITTER SYSTEM ---
        window.showToast = function(title, message, icon = 'ℹ️') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = `
                <div class="toast-header">
                    <span>${icon} <strong>${title}</strong></span>
                    <button class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            `;
            container.appendChild(toast);
            
            // Auto remove toast after 4s
            setTimeout(() => {
                toast.style.animation = 'slideInRight 0.3s ease reverse';
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 4000);
        }

        // Initialize UI
        updateNotifUI();

        // Listen for internal notifications trigger
        window.triggerNewOrderNotification = function(title, message, icon = '🛍️') {
            const now = new Date();
            const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + ' - Hari ini';
            
            notifications.unshift({ title, time: timeStr, icon });
            localStorage.setItem('notif_list', JSON.stringify(notifications));
            updateNotifUI();
            showToast(title, message, icon);
        }
    </script>

    @stack('scripts')
</body>
</html>