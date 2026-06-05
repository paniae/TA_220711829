<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KegiatanPadukuhanSeeder extends Seeder
{
    public function run()
    {
        DB::table('kegiatan_padukuhan')->insert([
            [
                'id_pengguna' => 3, 
                'nama_kegiatan' => 'Kerja Bakti Rutin Bulanan',
                'tgl_waktu_pelaksanaan' => Carbon::now()->addDays(2)->format('Y-m-d 07:00:00'),
                'waktu_selesai' => null,
                'jenis_kegiatan' => 'kegiatan',
                'status_kegiatan' => 'direncanakan',
                'kategori' => 'Kebersihan',
                'dana_dikeluarkan' => 0,
                'lokasi' => 'Seluruh Padukuhan',
                'deskripsi_kegiatan' => 'Kerja bakti membersihkan lingkungan',
                'poster_kegiatan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pengguna' => 3,
                'nama_kegiatan' => 'Posyandu Balita',
                'tgl_waktu_pelaksanaan' => Carbon::now()->addDays(5)->format('Y-m-d 08:00:00'),
                'waktu_selesai' => null,
                'jenis_kegiatan' => 'proker',
                'status_kegiatan' => 'direncanakan',
                'kategori' => 'Kesehatan',
                'dana_dikeluarkan' => 0,
                'lokasi' => 'Balai Padukuhan',
                'deskripsi_kegiatan' => 'Kegiatan rutin posyandu untuk balita',
                'poster_kegiatan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
