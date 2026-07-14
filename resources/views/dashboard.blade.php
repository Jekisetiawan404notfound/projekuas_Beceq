@extends('layouts.app')

@section('title', 'Overview')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan aktivitas rental mobil Beceq Rent')

@section('content')

<!-- Content Row - Stats Cards -->
<div class="row">

    <!-- Pendapatan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pendapatan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-revenue">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Transaksi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-transactions">
                            {{ $totalTransaksis }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Armada Mobil Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Armada Mobil</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMobils }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-car fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pelanggan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pelanggan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPelanggans }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row - Chart & Simulator -->
<div class="row">

    <!-- Chart Area -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-line mr-2"></i>Tren Pendapatan &amp; Transaksi
                </h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Filter Periode:</div>
                        <a class="dropdown-item filter-btn" href="#" onclick="updateChartPeriod('daily', this); return false;">Harian</a>
                        <a class="dropdown-item filter-btn" href="#" onclick="updateChartPeriod('weekly', this); return false;">Mingguan</a>
                        <a class="dropdown-item filter-btn" href="#" onclick="updateChartPeriod('monthly', this); return false;">Bulanan</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area" style="height: 320px;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Simulator Card -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt mr-2"></i>Simulator &amp; Kontrol
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">
                    Uji fungsionalitas UI dashboard secara interaktif.
                </p>

                <!-- Simulasi Notifikasi -->
                <div class="p-3 mb-3 rounded border bg-light">
                    <p class="font-weight-bold mb-1 small">
                        <i class="fas fa-bell text-primary mr-1"></i> Simulasikan Transaksi Masuk
                    </p>
                    <p class="text-muted small mb-2">
                        Kirim notifikasi real-time transaksi baru ke dashboard.
                    </p>
                    <button class="btn btn-primary btn-sm" onclick="simulateNewOrder()">
                        <i class="fas fa-play mr-1"></i> Simulasikan Pesanan
                    </button>
                </div>

                <!-- Ekspor Laporan -->
                <div class="p-3 rounded border bg-light">
                    <p class="font-weight-bold mb-1 small">
                        <i class="fas fa-download text-success mr-1"></i> Unduh Laporan Kinerja
                    </p>
                    <p class="text-muted small mb-2">
                        Ekspor ringkasan penjualan armada saat ini.
                    </p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-warning btn-sm mr-2" onclick="exportReport('PDF')">
                            <i class="fas fa-file-pdf mr-1"></i> PDF
                        </button>
                        <button class="btn btn-success btn-sm" onclick="exportReport('Excel')">
                            <i class="fas fa-file-excel mr-1"></i> Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row - Tabel Transaksi Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clock mr-2"></i>Transaksi Sewa Terbaru
                </h6>
                <a href="{{ route('transaksis.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>Pelanggan</th>
                                <th>Tanggal Transaksi</th>
                                <th>Total Bayar</th>
                                <th>Petugas Admin</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="transactions-table-body">
                            @forelse($recentTransaksis as $trx)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle bg-primary mr-2" style="width:32px;height:32px;">
                                            <span class="text-white font-weight-bold small">
                                                {{ strtoupper(substr($trx->pelanggan->nama ?? 'P', 0, 1)) }}
                                            </span>
                                        </div>
                                        <span class="font-weight-bold">{{ $trx->pelanggan->nama ?? 'Pelanggan Umum' }}</span>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($trx->tgl_transaksi)->translatedFormat('d F Y') }}</td>
                                <td class="font-weight-bold text-success">
                                    Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}
                                </td>
                                <td class="text-muted small">
                                    <i class="fas fa-user mr-1"></i>
                                    {{ $trx->admin->nama ?? ($trx->admin->username ?? 'Admin') }}
                                </td>
                                <td>
                                    <span class="badge badge-success">Selesai</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Belum ada transaksi rental tercatat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script>
    // --- 1. INITIALIZE CHART ---
    const ctx = document.getElementById('salesChart').getContext('2d');

    const chartDataSets = {
        daily: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            revenue: [1200000, 1900000, 3000000, 5000000, 2000000, 7000000, 8500000],
            rentals: [2, 3, 4, 6, 3, 8, 9]
        },
        weekly: {
            labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
            revenue: [15000000, 23000000, 18000000, 34000000],
            rentals: [18, 25, 20, 38]
        },
        monthly: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            revenue: [45000000, 52000000, 68000000, 85000000, 72000000, 95000000, 110000000, 89000000, 94000000, 105000000, 120000000, 145000000],
            rentals: [48, 55, 70, 92, 78, 102, 118, 95, 99, 112, 128, 155]
        }
    };

    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartDataSets.daily.labels,
            datasets: [
                {
                    label: 'Pendapatan (Rp)',
                    data: chartDataSets.daily.revenue,
                    borderColor: '#1cc88a',
                    backgroundColor: 'rgba(28, 200, 138, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y'
                },
                {
                    label: 'Jumlah Sewa Mobil',
                    data: chartDataSets.daily.rentals,
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                x: { grid: { color: '#eaecf4' }, ticks: { color: '#858796' } },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    grid: { color: '#eaecf4' },
                    ticks: {
                        color: '#858796',
                        callback: function(value) { return 'Rp ' + value.toLocaleString(); }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: { color: '#858796' }
                }
            }
        }
    });

    // --- 2. UPDATE CHART PERIOD ---
    window.updateChartPeriod = function(period, element) {
        const selectedData = chartDataSets[period];
        salesChart.data.labels = selectedData.labels;
        salesChart.data.datasets[0].data = selectedData.revenue;
        salesChart.data.datasets[1].data = selectedData.rentals;
        salesChart.update('active');
    };

    // --- 3. EXPORT REPORT SIMULATION ---
    window.exportReport = function(type) {
        toastr.info(`Sedang mempersiapkan data ekspor ${type}...`, 'Ekspor Laporan');
        setTimeout(() => {
            toastr.success(`Laporan Beceq Rent berformat ${type} telah diunduh!`, 'Berhasil');
        }, 1500);
    };

    // --- 4. SIMULATE NEW ORDER ---
    let orderCount = 0;
    const names = ['Andi Saputra', 'Budi Wijaya', 'Siti Rahma', 'Dewi Lestari', 'Joko Susilo'];
    const mobils = ['Avanza Veloz', 'Honda Civic', 'Toyota Alphard', 'Mitsubishi Xpander', 'Hyundai Ioniq 5'];

    window.simulateNewOrder = function() {
        orderCount++;
        const randomName = names[Math.floor(Math.random() * names.length)];
        const randomMobil = mobils[Math.floor(Math.random() * mobils.length)];
        const price = Math.floor((Math.random() * 5 + 3)) * 150000;

        // Update stats
        const revenueEl = document.getElementById('stat-revenue');
        const transactionsEl = document.getElementById('stat-transactions');
        let currentTrxCount = parseInt(transactionsEl.textContent) || 0;
        transactionsEl.textContent = currentTrxCount + 1;
        let currentRevText = revenueEl.textContent.replace('Rp ', '').replace(/\./g, '');
        let currentRev = parseInt(currentRevText) || 0;
        let newRev = currentRev + price;
        revenueEl.textContent = 'Rp ' + newRev.toLocaleString('id-ID');

        // Add row to table
        const tableBody = document.getElementById('transactions-table-body');
        const emptyCell = tableBody.querySelector('td[colspan]');
        if (emptyCell) { tableBody.innerHTML = ''; }
        const dateStr = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-primary mr-2" style="width:32px;height:32px;">
                        <span class="text-white font-weight-bold small">${randomName.substring(0, 1).toUpperCase()}</span>
                    </div>
                    <span class="font-weight-bold">${randomName}</span>
                </div>
            </td>
            <td>${dateStr}</td>
            <td class="font-weight-bold text-success">Rp ${price.toLocaleString('id-ID')}</td>
            <td class="text-muted small"><i class="fas fa-user mr-1"></i> Administrator (Sim)</td>
            <td><span class="badge badge-warning">Diproses</span></td>
        `;
        tableBody.insertBefore(newRow, tableBody.firstChild);
        if (tableBody.children.length > 6) { tableBody.lastChild.remove(); }

        toastr.success(`${randomName} menyewa ${randomMobil} - Rp ${price.toLocaleString('id-ID')}`, 'Pesanan Masuk!');
    };
</script>
@endpush