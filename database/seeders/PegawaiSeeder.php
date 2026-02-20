<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $pegawai = [
            [
                'name'       => 'FAJAR KURNIAWAN, SE',
                'email'      => 'fajar@pdam.id',
                'username'   => '1293.0903.78',
                'password'   => Hash::make('password123'),
                'position'   => 'Ka.Bag Umum & Adm',
                'department' => 'operations',
                'phone'      => '081234567890',
            ],
            [
                'name'       => 'EKO PRASETYO,S.T',
                'email'      => 'eko@pdam.id',
                'username'   => '1283.0803.76',
                'password'   => Hash::make('password123'),
                'position'   => 'Ka Sub Bag Umum & PDE',
                'department' => 'operations',
                'phone'      => '081234567891',
            ],
            [
                'name'       => 'MENA ANDI',
                'email'      => 'mena@pdam.id',
                'username'   => '1912.0606.83',
                'password'   => Hash::make('password123'),
                'position'   => 'Plt. Ka Sub Unit Banjarnegoro',
                'department' => 'operations',
                'phone'      => '081234567892',
            ],
            [
                'name'       => 'Winarno Hermawarudin, A.Md',
                'email'      => 'winarno@pdam.id',
                'username'   => '1302.0903.72',
                'password'   => Hash::make('password123'),
                'position'   => 'Staf Teknik',
                'department' => 'operations',
                'phone'      => '081234567893',
            ],
        ];

        foreach ($pegawai as $p) {
            User::updateOrCreate(
                ['email' => $p['email']],
                $p
            );
        }
    }
}