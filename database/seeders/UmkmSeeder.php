<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UmkmSeeder extends Seeder
{
    public function run()
    {
        DB::table('umkm')->insert([
            [
                'id_pengguna' => 1,
                'nama_umkm' => 'Warung Bu Siti',
                'alamat_umkm' => 'Jl. Mawar',
                'bidang_umkm' => 'Kuliner',
                'nomor_telepon_umkm' => '08123456789',
                'status_umkm' => 'aktif',
                'is_nomor_telepon_ditampilkan' => true
            ],
            [
                'id_pengguna' => 3,
                'nama_umkm' => 'Kerajinan Bambu',
                'alamat_umkm' => 'Jl. Melati',
                'bidang_umkm' => 'Kerajinan',
                'nomor_telepon_umkm' => '08987654321',
                'status_umkm' => 'aktif',
                'is_nomor_telepon_ditampilkan' => false
            ]
        ]);
    }
}