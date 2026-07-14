<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori_mobil;

class KategoriMobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori_mobil::create(['nama_kategori' => 'SUV']);

        Kategori_mobil::create(['nama_kategori' => 'MPV']);

        Kategori_mobil::create(['nama_kategori' => 'Sedan']);

        Kategori_mobil::create(['nama_kategori' => 'Hatchback']);
        
        Kategori_mobil::create(['nama_kategori' => 'Pickup']);
    }
}
