<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Mobil;
use App\Models\Transaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalPelanggans'  => Pelanggan::count(),
            'totalMobils'      => Mobil::count(),
            'totalTransaksis'  => Transaksi::count(),
            'totalPendapatan'  => Transaksi::sum('total_bayar'),
            'recentTransaksis' => Transaksi::with(['pelanggan', 'admin'])
                                      ->orderByDesc('id_transaksi')->take(5)->get(),
            'chartData'        => [
                'daily'   => $this->buildChartData('daily',   7),
                'weekly'  => $this->buildChartData('weekly',  4),
                'monthly' => $this->buildChartData('monthly', 12),
            ],
        ]);
    }

    private function buildChartData(string $period, int $count): array
    {
        $labels = $revenue = $rentals = [];

        for ($i = $count - 1; $i >= 0; $i--) {
            [$label, $query] = match ($period) {
                'daily' => [
                    Carbon::today()->subDays($i)->translatedFormat('D, d M'),
                    Transaksi::whereDate('tgl_transaksi', Carbon::today()->subDays($i)),
                ],
                'weekly' => [
                    'Minggu ' . Carbon::now()->startOfWeek()->subWeeks($i)->format('d/m'),
                    Transaksi::whereBetween('tgl_transaksi', [
                        Carbon::now()->startOfWeek()->subWeeks($i)->toDateString(),
                        Carbon::now()->startOfWeek()->subWeeks($i)->endOfWeek()->toDateString(),
                    ]),
                ],
                'monthly' => [
                    Carbon::now()->startOfMonth()->subMonths($i)->translatedFormat('M Y'),
                    Transaksi::whereYear('tgl_transaksi', Carbon::now()->subMonths($i)->year)
                              ->whereMonth('tgl_transaksi', Carbon::now()->subMonths($i)->month),
                ],
            };

            $row = $query->selectRaw('SUM(total_bayar) as rev, COUNT(*) as cnt')->first();

            $labels[]  = $label;
            $revenue[] = (int) ($row->rev ?? 0);
            $rentals[] = (int) ($row->cnt ?? 0);
        }

        return compact('labels', 'revenue', 'rentals');
    }
}
