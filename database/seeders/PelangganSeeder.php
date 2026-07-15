<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;

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
            'no_telepon' => '081234567890',
            'username' => 'budi_santoso',
            'password' => Hash::make('password123')
            ]);

        Pelanggan::create([
            'nama' => 'Andi Saputra', 
            'alamat' => 'Bandung', 
            'no_telepon' => '081298765432',
            'username' => 'andi_saputra',
            'password' => Hash::make('password123')
        ]);
        
        Pelanggan::create([
            'nama' => 'Siti Aisyah', 
            'alamat' => 'Palembang', 
            'no_telepon' => '082112223333',
            'username' => 'siti_aisyah',
            'password' => Hash::make('password123')
        ]);

        Pelanggan::create([
            'nama' => 'Luis Marwin', 
            'alamat' => 'Bangka Belitung', 
            'no_telepon' => '085212345678',
            'username' => 'luis_marwin',
            'password' => Hash::make('password123')
        ]);
    }
}
