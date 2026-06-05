<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KontakPadukuhanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kontak_padukuhan')->insert([
            'nomor_telepon' => '081234567890',
            'email' => 'padukuhanbrunoii@gmail.com',
            'instagram' => '@padukuhanbrunoii',
            'status_kontak' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
