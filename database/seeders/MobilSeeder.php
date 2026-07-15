<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mobil;
use App\Models\Kategori_mobil;

class MobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mobil::create([
            'id_kategori' => Kategori_mobil::where('nama_kategori', 'MPV')->first()->id_kategori,
            'merek' => 'Toyota',
            'model' => 'Avanza G CVT',
            'harga' => 258900000,
            'stok' => 9,
        ]);

        Mobil::create([
            'id_kategori' => Kategori_mobil::where('nama_kategori', 'MPV')->first()->id_kategori,
            'merek' => 'Toyota',
            'model' => 'Innova Zenix',
            'harga' => 458000000,
            'stok' => 6,
        ]);

        Mobil::create([
            'id_kategori' => Kategori_mobil::where('nama_kategori', 'SUV')->first()->id_kategori,
            'merek' => 'Honda',
            'model' => 'HR-V RS',
            'harga' => 512000000,
            'stok' => 4,
        ]);

        Mobil::create([
            'id_kategori' => Kategori_mobil::where('nama_kategori', 'Sedan')->first()->id_kategori,
            'merek' => 'Honda',
            'model' => 'Civic RS',
            'harga' => 620000000,
            'stok' => 3,
        ]);

        Mobil::create([
            'id_kategori' => Kategori_mobil::where('nama_kategori', 'SUV')->first()->id_kategori,
            'merek' => 'Mitsubishi',
            'model' => 'Pajero Sport',
            'harga' => 610000000,
            'stok' => 5,
        ]);

        Mobil::create([
            'id_kategori' => Kategori_mobil::where('nama_kategori', 'MPV')->first()->id_kategori,
            'merek' => 'Suzuki',
            'model' => 'Ertiga Hybrid',
            'harga' => 289000000,
            'stok' => 8,
        ]);

        Mobil::create([
            'id_kategori' => Kategori_mobil::where('nama_kategori', 'MPV')->first()->id_kategori,
            'merek' => 'Daihatsu',
            'model' => 'Xenia',
            'harga' => 245000000,
            'stok' => 7,
        ]);

        Mobil::create([
            'id_kategori' => Kategori_mobil::where('nama_kategori', 'Hatchback')->first()->id_kategori,
            'merek' => 'Toyota',
            'model' => 'Yaris GR',
            'harga' => 340000000,
            'stok' => 4,
        ]);
    }
}
