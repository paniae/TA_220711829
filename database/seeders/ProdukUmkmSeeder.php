<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukUmkmSeeder extends Seeder
{
    public function run()
    {
        DB::table('produk_umkm')->insert([
            [
                'id_umkm' => 1,
                'id_produk_master' => 1,
                'nama_produk' => 'Keripik Pisang Asli',
                'harga' => 15000,
                'status_produk' => 'tersedia',
                'foto_produk' => null,
                'deskripsi_produk' => 'Keripik pisang asli Gunungkidul, renyah dan manis alami.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
