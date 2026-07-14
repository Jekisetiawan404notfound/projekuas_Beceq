@extends('layouts.app')

@section('title', 'Overview')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan aktivitas rental mobil Beceq Rent')

@section('content')
<div class="dashboard-overview">
    
    <!-- ── STATISTIK UTAMA ── -->
    <div class="stats-grid">
        <!-- Pendapatan -->
        <div class="stat-card">
            <div class="stat-info">
                <span class="label">Total Pendapatan</span>
                <div class="value" id="stat-revenue">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
            <div class="stat-icon-wrapper" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                💰
            </div>
        </div>

        <!-- Transaksi -->
        <div class="stat-card">
            <div class="stat-info">
                <span class="label">Total Transaksi</span>
                <div class="value" id="stat-transactions">{{ $totalTransaksis }}</div>
            </div>
            <div class="stat-icon-wrapper" style="background: rgba(79, 70, 229, 0.15); color: #6366f1;">
                🧾
            </div>
        </div>

        <!-- Mobil -->
        <div class="stat-card">
            <div class="stat-info">
                <span class="label">Armada Mobil</span>
                <div class="value">{{ $totalMobils }}</div>
            </div>
            <div class="stat-icon-wrapper" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;">
                🚗
            </div>
        </div>

        <!-- Pelanggan -->
        <div class="stat-card">
            <div class="stat-info">
                <span class="label">Pelanggan</span>
                <div class="value">{{ $totalPelanggans }}</div>
            </div>
            <div class="stat-icon-wrapper" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;">
                👥
            </div>
        </div>
    </div>

    <!-- ── DUA KOLOM: GRAFIK & KONTROL SIMULASI ── -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-bottom: 24px;">
        <!-- Card Grafik -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <span class="card-title">📈 Tren Pendapatan & Transaksi</span>
                <!-- Filter Tanggal -->
                <div style="display: flex; gap: 6px;">
                    <button class="btn btn-outline btn-sm filter-btn active" onclick="updateChartPeriod('daily', this)">Harian</button>
                    <button class="btn btn-outline btn-sm filter-btn" onclick="updateChartPeriod('weekly', this)">Mingguan</button>
                    <button class="btn btn-outline btn-sm filter-btn" onclick="updateChartPeriod('monthly', this)">Bulanan</button>
                </div>
            </div>
            <div class="card-body" style="position: relative; height: 320px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Card Aksi Interaktif & Simulator -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <span class="card-title">⚡ Simulator & Kontrol Interaktif</span>
            </div>
            <div class="card-body">
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">
                    Uji fungsionalitas UI dashboard secara interaktif tanpa perlu input manual di database.
                </p>

                <!-- Tombol Simulasi Notifikasi -->
                <div style="margin-bottom: 16px; padding: 14px; border: 1px solid var(--border-color); border-radius: 12px; background: rgba(79, 70, 229, 0.03);">
                    <div style="font-size: 14px; font-weight: 700; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                        <span>🔔</span> Simulasikan Transaksi Masuk
                    </div>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 10px;">
                        Kirim notifikasi real-time transaksi baru ke dashboard secara instan.
                    </p>
                    <button class="btn btn-primary btn-sm" onclick="simulateNewOrder()">
                        Simulasikan Pesanan
                    </button>
                </div>

                <!-- Tombol Ekspor Laporan -->
                <div style="padding: 14px; border: 1px solid var(--border-color); border-radius: 12px; background: rgba(16, 185, 129, 0.03);">
                    <div style="font-size: 14px; font-weight: 700; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                        <span>📥</span> Unduh Laporan Kinerja
                    </div>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 10px;">
                        Ekspor ringkasan penjualan armada saat ini menjadi file digital (Excel/PDF).
                    </p>
                    <div style="display: flex; gap: 8px;">
                        <button class="btn btn-warning btn-sm" onclick="exportReport('PDF')">
                            📄 Ekspor ke PDF
                        </button>
                        <button class="btn btn-outline btn-sm" onclick="exportReport('Excel')" style="border-color: rgba(16, 185, 129, 0.3); color: #10b981;">
                            📊 Ekspor ke Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── TABEL TRANSAKSI TERBARU ── -->
    <div class="card">
        <div class="card-header">
            <span class="card-title">⏱️ Transaksi Sewa Terbaru</span>
            <a href="{{ route('transaksis.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Pelanggan</th>
                        <th>Tanggal Transaksi</th>
                        <th>Total Bayar</th>
                        <th>Petugas Admin</th>
                        <th width="150">Status</th>
                    </tr>
                </thead>
                <tbody id="transactions-table-body">
                    @forelse($recentTransaksis as $trx)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="avatar" style="width: 28px; height: 28px; font-size: 11px; font-weight: 700;">
                                    {{ strtoupper(substr($trx->pelanggan->nama ?? 'P', 0, 1)) }}
                                </div>
                                <span style="font-weight: 600;">{{ $trx->pelanggan->nama ?? 'Pelanggan Umum' }}</span>
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($trx->tgl_transaksi)->translatedFormat('d F Y') }}</td>
                        <td style="font-weight: 700; color: var(--primary);">
                            Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}
                        </td>
                        <td>
                            <span style="font-size: 13px; color: var(--text-muted);">
                                👤 {{ $trx->admin->nama ?? ($trx->admin->username ?? 'Admin') }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-success">Selesai</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            Belum ada transaksi rental tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // --- 1. INITIALIZE CHART ---
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Dataset Mock untuk filter periode
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

    // Deteksi warna berdasarkan tema
    function getChartThemeColors() {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        return {
            text: isDark ? '#9ca3af' : '#64748b',
            grid: isDark ? '#1f2937' : '#e2e8f0',
            primary: '#6366f1',
            success: '#10b981'
        };
    }

    let colors = getChartThemeColors();

    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartDataSets.daily.labels,
            datasets: [
                {
                    label: 'Pendapatan (Rp)',
                    data: chartDataSets.daily.revenue,
                    borderColor: colors.success,
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y'
                },
                {
                    label: 'Jumlah Sewa Mobil',
                    data: chartDataSets.daily.rentals,
                    borderColor: colors.primary,
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
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
                legend: {
                    position: 'top',
                    labels: {
                        color: colors.text,
                        font: { family: 'Plus Jakarta Sans', weight: '600' }
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: colors.grid },
                    ticks: { color: colors.text }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    grid: { color: colors.grid },
                    ticks: {
                        color: colors.text,
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: { color: colors.text }
                }
            }
        }
    });

    // Perbarui chart saat tema berganti
    const observer = new MutationObserver(() => {
        const newColors = getChartThemeColors();
        salesChart.options.plugins.legend.labels.color = newColors.text;
        salesChart.options.scales.x.ticks.color = newColors.text;
        salesChart.options.scales.x.grid.color = newColors.grid;
        salesChart.options.scales.y.ticks.color = newColors.text;
        salesChart.options.scales.y.grid.color = newColors.grid;
        salesChart.options.scales.y1.ticks.color = newColors.text;
        salesChart.update();
    });
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

    // --- 2. UPDATE CHART PERIOD ---
    window.updateChartPeriod = function(period, element) {
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        element.classList.add('active');

        const selectedData = chartDataSets[period];
        salesChart.data.labels = selectedData.labels;
        salesChart.data.datasets[0].data = selectedData.revenue;
        salesChart.data.datasets[1].data = selectedData.rentals;
        salesChart.update('active');
    };

    // --- 3. EXPORT REPORT SIMULATION ---
    window.exportReport = function(type) {
        showToast('Ekspor Laporan', `Sedang mempersiapkan data ekspor ${type}...`, '⏳');
        setTimeout(() => {
            showToast('Berhasil', `Laporan Beceq Rent berformat ${type} telah diunduh ke perangkat Anda.`, '✅');
        }, 1500);
    };

    // --- 4. SIMULATE NEW ORDER ---
    let orderCount = 0;
    const names = ['Andi Saputra', 'Budi Wijaya', 'Siti Rahma', 'Dewi Lestari', 'Joko Susilo'];
    const mobils = ['Avanza Veloz', 'Honda Civic Type-R', 'Toyota Alphard', 'Mitsubishi Xpander', 'Hyundai Ioniq 5'];

    window.simulateNewOrder = function() {
        orderCount++;
        const randomName = names[Math.floor(Math.random() * names.length)];
        const randomMobil = mobils[Math.floor(Math.random() * mobils.length)];
        const price = Math.floor((Math.random() * 5 + 3)) * 150000;
        
        // Panggil sistem layout notification
        if(typeof window.triggerNewOrderNotification === 'function') {
            window.triggerNewOrderNotification(
                'Pesanan Masuk 🚗',
                `${randomName} menyewa ${randomMobil} senilai Rp ${price.toLocaleString('id-ID')}`,
                '🎉'
            );
        }

        // Perbarui visual stats secara instan
        const revenueEl = document.getElementById('stat-revenue');
        const transactionsEl = document.getElementById('stat-transactions');
        
        // Update total transaksi
        let currentTrxCount = parseInt(transactionsEl.textContent) || 0;
        transactionsEl.textContent = currentTrxCount + 1;

        // Update total bayar
        let currentRevText = revenueEl.textContent.replace('Rp ', '').replace(/\./g, '');
        let currentRev = parseInt(currentRevText) || 0;
        let newRev = currentRev + price;
        revenueEl.textContent = 'Rp ' + newRev.toLocaleString('id-ID');

        // Tambah baris ke tabel transaksi terbaru
        const tableBody = document.getElementById('transactions-table-body');
        const emptyTr = tableBody.querySelector('td[colspan]');
        if(emptyTr) {
            tableBody.innerHTML = '';
        }

        const dateStr = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div class="avatar" style="width: 28px; height: 28px; font-size: 11px; font-weight: 700;">
                        ${randomName.substring(0, 1).toUpperCase()}
                    </div>
                    <span style="font-weight: 600;">${randomName}</span>
                </div>
            </td>
            <td>${dateStr}</td>
            <td style="font-weight: 700; color: var(--primary);">
                Rp ${price.toLocaleString('id-ID')}
            </td>
            <td>
                <span style="font-size: 13px; color: var(--text-muted);">
                    👤 Administrator (Sim)
                </span>
            </td>
            <td>
                <span class="badge badge-warning">Diproses</span>
            </td>
        `;
        tableBody.insertBefore(newRow, tableBody.firstChild);

        // Limit table to 6 entries
        if(tableBody.children.length > 6) {
            tableBody.lastChild.remove();
        }
    };
</script>
@endpush