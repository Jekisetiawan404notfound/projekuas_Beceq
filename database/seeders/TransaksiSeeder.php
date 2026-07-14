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
        $adminId = Admin::where('username', 'admin')->first()->id;

        Transaksi::create([
            'pelanggan_id' => Pelanggan::where('nama', 'Budi Santoso')->first()->id,
            'admin_id' => $adminId,
            'tgl_transaksi' => '2026-07-08',
            'total_bayar' => 258900000,
        ]);

        Transaksi::create([
            'pelanggan_id' => Pelanggan::where('nama', 'Andi Saputra')->first()->id,
            'admin_id' => $adminId,
            'tgl_transaksi' => '2026-07-08',
            'total_bayar' => 458000000,
        ]);

        Transaksi::create([
            'pelanggan_id' => Pelanggan::where('nama', 'Siti Aisyah')->first()->id,
            'admin_id' => $adminId,
            'tgl_transaksi' => '2026-07-09',
            'total_bayar' => 289000000,
        ]);

        Transaksi::create([
            'pelanggan_id' => Pelanggan::where('nama', 'Luis Marwin')->first()->id,
            'admin_id' => $adminId,
            'tgl_transaksi' => '2026-07-09',
            'total_bayar' => 610000000,
        ]);
    }
}
