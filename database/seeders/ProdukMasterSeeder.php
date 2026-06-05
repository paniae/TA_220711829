<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produk = [
            'Pisang',
            'Keripik',
            'Rumput Laut',
            'Ikan Asin',
            'Terasi',
            'Kue Kering',
            'Kopi',
            'Camilan Tradisional'
        ];

        $data = [];
        foreach ($produk as $p) {
            $data[] = [
                'nama_produk_master' => $p,
                'status_produk_master' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('produk_master')->insert($data);
    }
}
