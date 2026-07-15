<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Admin;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = Admin::where('username', 'admin')->first()->id_admin;

        Transaksi::create([
            'id_pelanggan' => Pelanggan::where('nama', 'Budi Santoso')->first()->id_pelanggan,
            'id_admin' => $adminId,
            'tgl_transaksi' => '2026-07-08',
            'total_bayar' => 258900000,
        ]);

        Transaksi::create([
            'id_pelanggan' => Pelanggan::where('nama', 'Andi Saputra')->first()->id_pelanggan,
            'id_admin' => $adminId,
            'tgl_transaksi' => '2026-07-08',
            'total_bayar' => 458000000,
        ]);

        Transaksi::create([
            'id_pelanggan' => Pelanggan::where('nama', 'Siti Aisyah')->first()->id_pelanggan,
            'id_admin' => $adminId,
            'tgl_transaksi' => '2026-07-09',
            'total_bayar' => 289000000,
        ]);

        Transaksi::create([
            'id_pelanggan' => Pelanggan::where('nama', 'Luis Marwin')->first()->id_pelanggan,
            'id_admin' => $adminId,
            'tgl_transaksi' => '2026-07-09',
            'total_bayar' => 610000000,
        ]);
    }
}
