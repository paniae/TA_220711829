<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleAksesSeeder extends Seeder
{
    public function run()
    {
        // 1 = Warga, 2 = RT, 3 = Dukuh

        // ROLE DUKUH (3)
        DB::table('role_akses')->insert([
            ['id_role' => 3, 'id_akses' => 1],  // kelola_kegiatan
            ['id_role' => 3, 'id_akses' => 3],  // kelola_pengaduan
            ['id_role' => 3, 'id_akses' => 5],  // kelola_laporan_kehilangan
            ['id_role' => 3, 'id_akses' => 6],  // hapus_komentar_forum
            ['id_role' => 3, 'id_akses' => 7],  // kelola_pengguna
            ['id_role' => 3, 'id_akses' => 8],  // kelola_penduduk
            ['id_role' => 3, 'id_akses' => 9],  // kelola_laporan_rekapitulasi
            ['id_role' => 3, 'id_akses' => 12], // konfirmasi_umkm
            ['id_role' => 3, 'id_akses' => 13], // kelola_informasi_umum
            ['id_role' => 3, 'id_akses' => 14], // kelola_role
            ['id_role' => 3, 'id_akses' => 15], // kelola_role_akses
        ]);

        // ROLE RT (2)
        DB::table('role_akses')->insert([
            ['id_role' => 2, 'id_akses' => 5],  // kelola_laporan_kehilangan
            ['id_role' => 2, 'id_akses' => 8],  // kelola_penduduk
            ['id_role' => 2, 'id_akses' => 10], // kelola_laporan_penduduk
            ['id_role' => 2, 'id_akses' => 11], // kelola_umkm
            ['id_role' => 2, 'id_akses' => 4],  // tambah_pengaduan
        ]);

        // ROLE WARGA (1)
        DB::table('role_akses')->insert([
            ['id_role' => 1, 'id_akses' => 2],  // lihat_kegiatan
            ['id_role' => 1, 'id_akses' => 4],  // tambah_pengaduan
            ['id_role' => 1, 'id_akses' => 5],  // kelola_laporan_kehilangan
            ['id_role' => 1, 'id_akses' => 11], // kelola_umkm
        ]);
    }
}