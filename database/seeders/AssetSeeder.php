<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $assets = [
            [
                'kode_aset' => 'AST-001',
                'nama_aset' => 'Laptop Dell Latitude 5420',
                'kategori' => 'Peralatan',
                'merk' => 'Dell',
                'tipe' => 'Latitude 5420',
                'tahun_perolehan' => 2023,
                'nilai_perolehan' => 15000000,
                'kondisi' => 'Baik',
                'lokasi' => 'Ruang IT',
                'pemegang_saat_ini' => 'IT Support'
            ],
            [
                'kode_aset' => 'AST-002',
                'nama_aset' => 'Meja Kantor',
                'kategori' => 'Peralatan',
                'merk' => 'Olympic',
                'tahun_perolehan' => 2022,
                'nilai_perolehan' => 2500000,
                'kondisi' => 'Baik',
                'lokasi' => 'Ruang Staff',
                'pemegang_saat_ini' => 'Staff Admin'
            ],
            [
                'kode_aset' => 'AST-003',
                'nama_aset' => 'Printer HP LaserJet',
                'kategori' => 'Peralatan',
                'merk' => 'HP',
                'tipe' => 'LaserJet Pro M404dn',
                'tahun_perolehan' => 2023,
                'nilai_perolehan' => 5000000,
                'kondisi' => 'Rusak Ringan',
                'lokasi' => 'Ruang Admin',
                'pemegang_saat_ini' => 'Admin'
            ],
            [
                'kode_aset' => 'AST-004',
                'nama_aset' => 'Mobil Dinas Toyota Avanza',
                'kategori' => 'Kendaraan',
                'merk' => 'Toyota',
                'tipe' => 'Avanza 1.3 G MT',
                'tahun_perolehan' => 2021,
                'nilai_perolehan' => 200000000,
                'kondisi' => 'Baik',
                'lokasi' => 'Parkir Kantor',
                'pemegang_saat_ini' => 'Direktur'
            ],
            [
                'kode_aset' => 'AST-005',
                'nama_aset' => 'Gedung Kantor Pusat',
                'kategori' => 'Bangunan',
                'tahun_perolehan' => 2015,
                'nilai_perolehan' => 5000000000,
                'kondisi' => 'Baik',
                'lokasi' => 'Jl. Raya Utama No. 123'
            ],
        ];

        foreach ($assets as $asset) {
            Asset::create($asset);
        }
    }
}