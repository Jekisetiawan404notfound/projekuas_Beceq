<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Beceq Rent - Sistem Manajemen Rental Mobil">
    <meta name="author" content="Beceq Rent">

    <title>Beceq Rent &mdash; @yield('title', 'Dashboard')</title>

    <!-- Custom fonts for this template -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-car"></i>
                </div>
                <div class="sidebar-brand-text mx-3"> McQueen Rent</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            @if(Auth::guard('admin')->check())
                @php
                    $adminUser = Auth::guard('admin')->user();
                    $isSuperAdmin = $adminUser && $adminUser->role === 'super_admin';
                @endphp

                <li class="nav-item {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading: Katalog Kendaraan -->
                <div class="sidebar-heading">
                    Katalog Kendaraan
                </div>

                <!-- Nav Item - Kategori Mobil -->
                <li class="nav-item {{ request()->routeIs('kategori-mobils.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('kategori-mobils.index') }}">
                        <i class="fas fa-fw fa-folder-open"></i>
                        <span>Kategori Mobil</span>
                    </a>
                </li>

                <!-- Nav Item - Daftar Mobil -->
                <li class="nav-item {{ request()->routeIs('mobils.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('mobils.index') }}">
                        <i class="fas fa-fw fa-car"></i>
                        <span>Daftar Mobil</span>
                    </a>
                </li>

                @if($isSuperAdmin)
                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- Heading: Penyewaan & Pelanggan -->
                    <div class="sidebar-heading">
                        Penyewaan &amp; Pelanggan
                    </div>

                    <!-- Nav Item - Pelanggan -->
                    <li class="nav-item {{ request()->routeIs('pelanggans.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('pelanggans.index') }}">
                            <i class="fas fa-fw fa-users"></i>
                            <span>Pelanggan</span>
                        </a>
                    </li>

                    <!-- Nav Item - Transaksi -->
                    <li class="nav-item {{ request()->routeIs('transaksis.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('transaksis.index') }}">
                            <i class="fas fa-fw fa-file-invoice-dollar"></i>
                            <span>Transaksi Sewa</span>
                        </a>
                    </li>

                    <!-- Nav Item - Detail Transaksi -->
                    <li class="nav-item {{ request()->routeIs('detail-transaksis.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('detail-transaksis.index') }}">
                            <i class="fas fa-fw fa-list-alt"></i>
                            <span>Detail Transaksi</span>
                        </a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- Heading: Pengaturan -->
                    <div class="sidebar-heading">
                        Pengaturan
                    </div>

                    <!-- Nav Item - Admin -->
                    <li class="nav-item {{ request()->routeIs('admins.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admins.index') }}">
                            <i class="fas fa-fw fa-user-cog"></i>
                            <span>Manajemen Admin</span>
                        </a>
                    </li>
                @endif
            @elseif(Auth::guard('pelanggan')->check())
                <li class="nav-item {{ request()->routeIs('pelanggan.dashboard') || request()->routeIs('pelanggan.transaksi.create') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pelanggan.dashboard') }}">
                        <i class="fas fa-fw fa-car"></i>
                        <span>Katalog Mobil</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading: Transaksi Pelanggan -->
                <div class="sidebar-heading">
                    Transaksi Saya
                </div>

                <!-- Nav Item - Riwayat Transaksi -->
                <li class="nav-item {{ request()->routeIs('pelanggan.transaksi.riwayat') || request()->routeIs('pelanggan.transaksi.detail') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pelanggan.transaksi.riwayat') }}">
                        <i class="fas fa-fw fa-history"></i>
                        <span>Riwayat Sewa</span>
                    </a>
                </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    @if(Auth::guard('pelanggan')->check())
                        <form method="GET" action="{{ route('pelanggan.dashboard') }}" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-0 small" placeholder="Cari mobil..." aria-label="Cari mobil" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter" id="notif-badge" style="display:none;">0</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifikasi
                                </h6>
                                <div id="notif-list">
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">Sistem aktif</div>
                                            <span class="font-weight-bold">Beceq Rent siap digunakan</span>
                                        </div>
                                    </a>
                                </div>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Lihat Semua Notifikasi</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    @if(Auth::guard('admin')->check())
                                        {{ Auth::guard('admin')->user()->username }} (Admin)
                                    @elseif(Auth::guard('pelanggan')->check())
                                        {{ Auth::guard('pelanggan')->user()->nama }} (Pelanggan)
                                    @else
                                        Guest
                                    @endif
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->check() ? Auth::guard('admin')->user()->username : (Auth::guard('pelanggan')->check() ? Auth::guard('pelanggan')->user()->nama : 'Guest')) }}&background=4e73df&color=ffffff&size=40">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                @if(Auth::guard('admin')->check())
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout Admin
                                    </a>
                                    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @elseif(Auth::guard('pelanggan')->check())
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('pelanggan-logout-form').submit();">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout Pelanggan
                                    </a>
                                    <form id="pelanggan-logout-form" action="{{ route('pelanggan.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <a class="dropdown-item" href="{{ route('pelanggan.login') }}">
                                        <i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Login
                                    </a>
                                @endif
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">@yield('page-title', 'Dashboard')</h1>
                        <small class="text-muted">@yield('page-subtitle', '')</small>
                    </div>

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Menampilkan konten utama halaman sesuai view yang dipanggil --}}
@yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; {{ date('Y') }} <strong>Beceq Rent</strong> &mdash; Sistem Manajemen Rental Mobil</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    @stack('scripts')

</body>

</html>