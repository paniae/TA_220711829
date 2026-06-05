<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriProdukSeeder extends Seeder
{
    public function run()
    {
        DB::table('kategori_produk')->insert([
            ['id_kategori_produk' => 'KAT-001', 'nama_kategori' => 'Makanan', 'status_kategori' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori_produk' => 'KAT-002', 'nama_kategori' => 'Minuman', 'status_kategori' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori_produk' => 'KAT-003', 'nama_kategori' => 'Kerajinan', 'status_kategori' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori_produk' => 'KAT-004', 'nama_kategori' => 'Jasa', 'status_kategori' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
