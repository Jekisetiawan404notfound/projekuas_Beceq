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
        $trx1 = Transaksi::where('id_pelanggan', Pelanggan::where('nama', 'Budi Santoso')->first()->id_pelanggan)
            ->where('tgl_transaksi', '2026-07-08')
            ->first()->id_transaksi;

        Detail_transaksi::create([
            'id_transaksi' => $trx1,
            'id_mobil' => Mobil::where('merek', 'Toyota')->where('model', 'Avanza G CVT')->first()->id_mobil,
            'jumlah_beli' => 1,
            'subtotal' => 258900000,
        ]);

        $trx2 = Transaksi::where('id_pelanggan', Pelanggan::where('nama', 'Andi Saputra')->first()->id_pelanggan)
            ->where('tgl_transaksi', '2026-07-08')
            ->first()->id_transaksi;

        Detail_transaksi::create([
            'id_transaksi' => $trx2,
            'id_mobil' => Mobil::where('merek', 'Toyota')->where('model', 'Innova Zenix')->first()->id_mobil,
            'jumlah_beli' => 1,
            'subtotal' => 458000000,
        ]);

        $trx3 = Transaksi::where('id_pelanggan', Pelanggan::where('nama', 'Siti Aisyah')->first()->id_pelanggan)
            ->where('tgl_transaksi', '2026-07-09')
            ->first()->id_transaksi;

        Detail_transaksi::create([
            'id_transaksi' => $trx3,
            'id_mobil' => Mobil::where('merek', 'Suzuki')->where('model', 'Ertiga Hybrid')->first()->id_mobil,
            'jumlah_beli' => 1,
            'subtotal' => 289000000,
        ]);

        $trx4 = Transaksi::where('id_pelanggan', Pelanggan::where('nama', 'Luis Marwin')->first()->id_pelanggan)
            ->where('tgl_transaksi', '2026-07-09')
            ->first()->id_transaksi;

        Detail_transaksi::create([
            'id_transaksi' => $trx4,
            'id_mobil' => Mobil::where('merek', 'Mitsubishi')->where('model', 'Pajero Sport')->first()->id_mobil,
            'jumlah_beli' => 1,
            'subtotal' => 610000000,
        ]);
    }
}
