<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanKehilanganSeeder extends Seeder
{
    public function run()
    {
        DB::table('laporan_kehilangan')->insert([
            [
                'id_pengguna' => 1, 
                'tanggal_hilang' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'barang_hilang' => 'Dompet Warna Hitam',
                'lokasi_hilang' => 'Jalan Utama Padukuhan',
                'foto_barang' => null,
                'tanggal_laporan' => Carbon::now()->format('Y-m-d'),
                'deskripsi_laporan' => 'Terdapat KTP dan SIM di dalamnya',
                'status_kehilangan' => 'Hilang',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
