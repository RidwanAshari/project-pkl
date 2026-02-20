<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bengkel;

class BengkelSeeder extends Seeder
{
    public function run(): void
    {
        $bengkels = [
            [
                'nama'    => 'AHASS Resmi Motor',
                'alamat'  => 'Borobudur',
                'telepon' => '0293123456',
            ],
            [
                'nama'    => 'Bengkel Honda Magelang',
                'alamat'  => 'Jl. Veteran No. 45, Magelang',
                'telepon' => '0293234567',
            ],
            [
                'nama'    => 'Yamaha Authorized Service',
                'alamat'  => 'Jl. Pemuda No. 12, Mungkid',
                'telepon' => '0293345678',
            ],
        ];

        foreach ($bengkels as $bengkel) {
            Bengkel::create($bengkel);
        }
    }
}