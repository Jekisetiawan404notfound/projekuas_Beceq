<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Detail_transaksi;
use App\Models\Transaksi;
use App\Models\Mobil;
use App\Models\Pelanggan;

class DetailTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trx1 = Transaksi::where('pelanggan_id', Pelanggan::where('nama', 'Budi Santoso')->first()->id)
            ->where('tgl_transaksi', '2026-07-08')
            ->first()->id;

        Detail_transaksi::create([
            'transaksi_id' => $trx1,
            'mobil_id' => Mobil::where('merek', 'Toyota')->where('model', 'Avanza G CVT')->first()->id,
            'jumlah_beli' => 1,
            'subtotal' => 258900000,
        ]);

        $trx2 = Transaksi::where('pelanggan_id', Pelanggan::where('nama', 'Andi Saputra')->first()->id)
            ->where('tgl_transaksi', '2026-07-08')
            ->first()->id;

        Detail_transaksi::create([
            'transaksi_id' => $trx2,
            'mobil_id' => Mobil::where('merek', 'Toyota')->where('model', 'Innova Zenix')->first()->id,
            'jumlah_beli' => 1,
            'subtotal' => 458000000,
        ]);

        $trx3 = Transaksi::where('pelanggan_id', Pelanggan::where('nama', 'Siti Aisyah')->first()->id)
            ->where('tgl_transaksi', '2026-07-09')
            ->first()->id;

        Detail_transaksi::create([
            'transaksi_id' => $trx3,
            'mobil_id' => Mobil::where('merek', 'Suzuki')->where('model', 'Ertiga Hybrid')->first()->id,
            'jumlah_beli' => 1,
            'subtotal' => 289000000,
        ]);

        $trx4 = Transaksi::where('pelanggan_id', Pelanggan::where('nama', 'Luis Marwin')->first()->id)
            ->where('tgl_transaksi', '2026-07-09')
            ->first()->id;

        Detail_transaksi::create([
            'transaksi_id' => $trx4,
            'mobil_id' => Mobil::where('merek', 'Mitsubishi')->where('model', 'Pajero Sport')->first()->id,
            'jumlah_beli' => 1,
            'subtotal' => 610000000,
        ]);
    }
}
