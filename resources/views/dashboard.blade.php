@extends('layouts.app')

@section('title', 'Overview')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan aktivitas rental mobil Beceq Rent')

@section('content')
{{-- Menampilkan ringkasan dashboard dan transaksi terbaru --}}

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
    // --- DATA ---
    const chartDataSets = @json($chartData);
    const DEFAULT_PERIOD = 'monthly';

    // Shared dataset config to avoid duplication
    const datasetBase = (label, color, yAxisID) => ({
        label, borderColor: color, backgroundColor: color.replace(')', ', 0.1)').replace('rgb', 'rgba'),
        borderWidth: 3, fill: true, tension: 0.4, yAxisID, data: []
    });

    // --- CHART INIT ---
    const salesChart = new Chart(
        document.getElementById('salesChart').getContext('2d'),
        {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    { ...datasetBase('Pendapatan (Rp)',   'rgb(28,200,138)',  'y'),  yAxisID: 'y'  },
                    { ...datasetBase('Jumlah Sewa Mobil', 'rgb(78,115,223)', 'y1'), yAxisID: 'y1' },
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: {
                    x:  { grid: { color: '#eaecf4' }, ticks: { color: '#858796' } },
                    y:  { type: 'linear', position: 'left',  grid: { color: '#eaecf4' },
                          ticks: { color: '#858796', callback: v => 'Rp ' + v.toLocaleString('id-ID') } },
                    y1: { type: 'linear', position: 'right', grid: { drawOnChartArea: false },
                          ticks: { color: '#858796' } }
                }
            }
        }
    );

    // --- SWITCH PERIOD ---
    window.updateChartPeriod = function(period, el) {
        const d = chartDataSets[period];
        salesChart.data.labels           = d.labels;
        salesChart.data.datasets[0].data = d.revenue;
        salesChart.data.datasets[1].data = d.rentals;
        salesChart.update('active');
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active', 'font-weight-bold'));
        el?.classList.add('active', 'font-weight-bold');
    };

    // Render default period on load
    updateChartPeriod(DEFAULT_PERIOD, document.querySelector(`.filter-btn[onclick*="${DEFAULT_PERIOD}"]`));

    // --- EXPORT SIMULATION ---
    window.exportReport = function(type) {
        toastr.info(`Mempersiapkan ekspor ${type}...`, 'Ekspor Laporan');
        setTimeout(() => toastr.success(`Laporan ${type} berhasil diunduh!`, 'Berhasil'), 1500);
    };

    // --- SIMULATE ORDER ---
    const NAMES  = ['Andi Saputra','Budi Wijaya','Siti Rahma','Dewi Lestari','Joko Susilo'];
    const MOBILS = ['Avanza Veloz','Honda Civic','Toyota Alphard','Mitsubishi Xpander','Hyundai Ioniq 5'];
    const pick   = arr => arr[Math.floor(Math.random() * arr.length)];
    const fmt    = n => n.toLocaleString('id-ID');

    window.simulateNewOrder = function() {
        const name  = pick(NAMES);
        const mobil = pick(MOBILS);
        const price = (Math.floor(Math.random() * 5) + 3) * 150000;

        // Update stat counters
        const revEl = document.getElementById('stat-revenue');
        const trxEl = document.getElementById('stat-transactions');
        trxEl.textContent = (parseInt(trxEl.textContent) || 0) + 1;
        revEl.textContent = 'Rp ' + fmt((parseInt(revEl.textContent.replace(/\D/g,'')) || 0) + price);

        // Prepend row to table
        const tbody = document.getElementById('transactions-table-body');
        tbody.querySelector('td[colspan]')?.closest('tr').remove();
        const tr = tbody.insertRow(0);
        tr.innerHTML = `
            <td><div class="d-flex align-items-center">
                <div class="icon-circle bg-primary mr-2" style="width:32px;height:32px;">
                    <span class="text-white font-weight-bold small">${name[0]}</span>
                </div>
                <span class="font-weight-bold">${name}</span>
            </div></td>
            <td>${new Date().toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'})}</td>
            <td class="font-weight-bold text-success">Rp ${fmt(price)}</td>
            <td class="text-muted small"><i class="fas fa-user mr-1"></i>Administrator (Sim)</td>
            <td><span class="badge badge-warning">Diproses</span></td>`;
        if (tbody.rows.length > 6) tbody.deleteRow(-1);

        toastr.success(`${name} menyewa ${mobil} — Rp ${fmt(price)}`, 'Pesanan Masuk!');
    };
</script>
@endpush