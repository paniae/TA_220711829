<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AksesSeeder extends Seeder
{
    public function run()
    {
        $aksesData = [
            // Kegiatan
            ['nama_akses' => 'kelola_kegiatan', 'deskripsi_akses' => 'Menambah, mengubah, menghapus data dan mengunggah dokumentasi kegiatan/proker'],
            ['nama_akses' => 'lihat_kegiatan', 'deskripsi_akses' => 'Melihat dan mengunduh detail data serta dokumentasi kegiatan/proker'],
            
            // Pengaduan
            ['nama_akses' => 'kelola_pengaduan', 'deskripsi_akses' => 'Mengubah status, memantau, dan menghapus data laporan pengaduan masuk'],
            ['nama_akses' => 'tambah_pengaduan', 'deskripsi_akses' => 'Membuat dan mengirimkan laporan pengaduan baru ke dalam sistem'],
            
            // Kehilangan & Forum
            ['nama_akses' => 'kelola_laporan_kehilangan', 'deskripsi_akses' => 'Mengelola keseluruhan data forum kehilangan (menutup laporan, menghapus forum)'],
            ['nama_akses' => 'tambah_komentar', 'deskripsi_akses' => 'Memberikan dan mengubah komentar milik sendiri pada forum kehilangan'],
            ['nama_akses' => 'kelola_komentar', 'deskripsi_akses' => 'Menghapus komentar dari pengguna lain yang tidak pantas di forum kehilangan'],
            
            // Pengguna & Penduduk
            ['nama_akses' => 'kelola_pengguna', 'deskripsi_akses' => 'Menyetujui pendaftaran, mengubah, menghapus, dan menambah akun pengguna baru'],
            ['nama_akses' => 'kelola_penduduk', 'deskripsi_akses' => 'Menambah, mengubah, mencari, dan menghapus data penduduk padukuhan'],
            
            // Laporan
            ['nama_akses' => 'kelola_laporan_rekapitulasi', 'deskripsi_akses' => 'Mengakses dan mengunduh PDF laporan rekapitulasi (Kegiatan, UMKM, Pengaduan, dll)'],
            ['nama_akses' => 'kelola_laporan_penduduk', 'deskripsi_akses' => 'Mengakses dan mengunduh PDF khusus untuk data dan statistik kependudukan'],
            
            // UMKM
            ['nama_akses' => 'kelola_umkm', 'deskripsi_akses' => 'Memantau dan menghapus data toko UMKM beserta produk yang melanggar aturan'],
            ['nama_akses' => 'konfirmasi_umkm', 'deskripsi_akses' => 'Menyetujui pendaftaran toko UMKM baru dan pengajuan nama Produk Master baru'],
            
            // Informasi & Role
            ['nama_akses' => 'kelola_informasi_umum', 'deskripsi_akses' => 'Mengubah profil, visi misi, dan kontak padukuhan yang tampil di beranda utama'],
            ['nama_akses' => 'kelola_role_akses', 'deskripsi_akses' => 'Menambah, mengubah, melihat, menghapus jenis peran (role), serta memberikan dan mencabut izin hak akses untuk masing-masing peran'],

        ];

        foreach ($aksesData as $data) {
            DB::table('akses')->updateOrInsert(
                ['nama_akses' => $data['nama_akses']],
                ['deskripsi_akses' => $data['deskripsi_akses']]
            );
        }
    }
}