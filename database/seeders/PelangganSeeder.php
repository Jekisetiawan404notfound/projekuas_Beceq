<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::create([
            'nama' => 'Budi Santoso', 
            'alamat' => 'Jakarta Selatan', 
            'no_telepon' => '081234567890'
            ]);

        Pelanggan::create([
            'nama' => 'Andi Saputra', 
            'alamat' => 'Bandung', 
            'no_telepon' => '081298765432'
        ]);
        
        Pelanggan::create([
            'nama' => 'Siti Aisyah', 
            'alamat' => 'Palembang', 
            'no_telepon' => '082112223333'
        ]);

        Pelanggan::create([
            'nama' => 'Luis Marwin', 
            'alamat' => 'Bangka Belitung', 
            'no_telepon' => '085212345678'
        ]);
    }
}
