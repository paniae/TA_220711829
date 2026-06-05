<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AksesSeeder extends Seeder
{
    public function run()
    {
        DB::table('akses')->insert([
            // Kegiatan
            ['nama_akses' => 'kelola_kegiatan'],
            ['nama_akses' => 'lihat_kegiatan'],
            
            // Pengaduan
            ['nama_akses' => 'kelola_pengaduan'],
            ['nama_akses' => 'tambah_pengaduan'],
            
            // Kehilangan & Forum
            ['nama_akses' => 'kelola_laporan_kehilangan'],
            ['nama_akses' => 'tambah_komentar'],
            ['nama_akses' => 'kelola_komentar'],
            
            // Pengguna & Penduduk
            ['nama_akses' => 'kelola_pengguna'],
            ['nama_akses' => 'kelola_penduduk'],
            
            // Laporan
            ['nama_akses' => 'kelola_laporan_rekapitulasi'],
            ['nama_akses' => 'kelola_laporan_penduduk'],
            
            // UMKM
            ['nama_akses' => 'kelola_umkm'],
            ['nama_akses' => 'konfirmasi_umkm'],
            
            // Informasi & Role
            ['nama_akses' => 'kelola_informasi_umum'],
            ['nama_akses' => 'kelola_role'],
            ['nama_akses' => 'kelola_role_akses'],

        ]);
    }
}