<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengaduanSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengaduan')->insert([
            [
                'id_pengguna' => 1,
                'isi_pengaduan' => 'Lampu jalan di blok A mati sejak 3 hari yang lalu',
                'status_pengaduan' => 'menunggu',
                'tgl_waktu_pengaduan' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
