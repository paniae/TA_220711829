<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pengguna;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('penduduk')->truncate();
        DB::table('kegiatan_padukuhan')->truncate();
        DB::table('pengaduan')->truncate();
        DB::table('laporan_kehilangan')->truncate();
        DB::table('produk_umkm')->truncate();
        DB::table('umkm')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Pastikan ada setidaknya 1 pengguna untuk relasi
        $pengguna = Pengguna::first();
        if (!$pengguna) {
            // Buat pengguna dummy jika kosong
            $user = User::create([
                'username' => 'dummy_user_' . Str::random(5),
                'password' => bcrypt('password'),
                'id_role' => 1
            ]);
            $pengguna = Pengguna::create([
                'id_user' => $user->id_user,
                'nama_lengkap' => 'Dummy User',
                'nomor_telepon' => '081234567890',
                'alamat' => 'Alamat Dummy',
                'status_pengguna' => 'aktif'
            ]);
        }

        $idPengguna = $pengguna->id_pengguna;
        
        // 1. Data Penduduk (500 data)
        $pendudukData = [];
        $jk = ['Laki-laki', 'Perempuan'];
        $status = ['Aktif', 'Aktif', 'Aktif', 'Aktif', 'Pindah', 'Meninggal']; // Proporsi Aktif lebih banyak
        
        for ($i = 1; $i <= 500; $i++) {
            $umur = rand(5, 70); // dari balita hingga lansia
            $tglLahir = Carbon::now()->subYears($umur)->subDays(rand(1, 300));
            
            $pendudukData[] = [
                'nomor_induk_kependudukan' => '3404' . str_pad($i, 12, '0', STR_PAD_LEFT),
                'nama_lengkap' => 'Penduduk Dummy ' . $i,
                'nomor_kk' => '34040' . str_pad($i, 11, '0', STR_PAD_LEFT),
                'jenis_kelamin' => $jk[array_rand($jk)],
                'tempat_lahir' => 'Sleman',
                'tanggal_lahir' => $tglLahir,
                'agama' => 'Islam',
                'pendidikan' => 'SMA',
                'jenis_pekerjaan' => 'Wiraswasta',
                'status_perkawinan' => 'Belum Kawin',
                'rt' => str_pad(rand(1, 5), 2, '0', STR_PAD_LEFT),
                'rw' => '01',
                'alamat' => 'Padukuhan Dummy RT ' . rand(1, 5),
                'kecamatan' => 'Sleman',
                'desa_kelurahan' => 'Sleman',
                'kabupaten_kota' => 'Sleman',
                'provinsi' => 'DIY',
                'status_penduduk' => $status[array_rand($status)],
                'id_pengguna' => $idPengguna,
                'created_at' => Carbon::now()->subDays(rand(0, 1800)), // Rentang 5 tahun
                'updated_at' => Carbon::now()
            ];
        }
        // Insert bertahap agar tidak terlalu berat memori
        foreach (array_chunk($pendudukData, 100) as $chunk) {
            DB::table('penduduk')->insert($chunk);
        }

        // 2. Data Kegiatan (150 data) dan Proker (100 data)
        $kegiatanData = [];
        $kategoriKegiatan = ['RT/RW', 'Padukuhan', 'Kalurahan'];
        
        for ($i = 1; $i <= 250; $i++) {
            $jenis = $i <= 150 ? 'kegiatan' : 'proker';
            $tglPelaksanaan = Carbon::now()->subDays(rand(-30, 1800)); // Termasuk yang akan datang
            
            $kegiatanData[] = [
                'id_pengguna' => $idPengguna,
                'nama_kegiatan' => ucfirst($jenis) . ' Dummy ' . $i,
                'deskripsi_kegiatan' => 'Deskripsi untuk ' . $jenis . ' dummy ' . $i,
                'jenis_kegiatan' => $jenis,
                'tgl_waktu_pelaksanaan' => $tglPelaksanaan,
                'waktu_selesai' => (clone $tglPelaksanaan)->addHours(4),
                'lokasi' => 'Balai RW ' . rand(1, 5),
                'kategori' => $kategoriKegiatan[array_rand($kategoriKegiatan)],
                'status_kegiatan' => $tglPelaksanaan->isPast() ? 'selesai' : 'direncanakan',
                'created_at' => $tglPelaksanaan,
                'updated_at' => Carbon::now()
            ];
        }
        foreach (array_chunk($kegiatanData, 50) as $chunk) {
            DB::table('kegiatan_padukuhan')->insert($chunk);
        }

        // 3. Data Pengaduan (200 data)
        $pengaduanData = [];
        $statusPengaduan = ['menunggu_validasi', 'diproses', 'selesai', 'ditolak'];
        
        for ($i = 1; $i <= 200; $i++) {
            $tglPengaduan = Carbon::now()->subDays(rand(0, 1800));
            
            $pengaduanData[] = [
                'id_pengguna' => $idPengguna,
                'isi_pengaduan' => 'Isi detail pengaduan fasilitas umum ' . $i,
                'tgl_waktu_pengaduan' => $tglPengaduan,
                'status_pengaduan' => $statusPengaduan[array_rand($statusPengaduan)],
                'created_at' => $tglPengaduan,
                'updated_at' => Carbon::now()
            ];
        }
        foreach (array_chunk($pengaduanData, 50) as $chunk) {
            DB::table('pengaduan')->insert($chunk);
        }

        // 4. Data Laporan Kehilangan (150 data)
        $kehilanganData = [];
        $statusKehilangan = ['hilang', 'ditemukan'];
        
        for ($i = 1; $i <= 150; $i++) {
            $tglKehilangan = Carbon::now()->subDays(rand(0, 1800));
            
            $kehilanganData[] = [
                'id_pengguna' => $idPengguna,
                'barang_hilang' => 'Barang Dummy ' . $i,
                'deskripsi_laporan' => 'Barang warna hitam merk X ' . $i,
                'tanggal_hilang' => Carbon::parse($tglKehilangan)->subDays(rand(1, 3)),
                'tanggal_laporan' => $tglKehilangan,
                'lokasi_hilang' => 'Sekitar Masjid RT ' . rand(1, 5),
                'status_kehilangan' => $statusKehilangan[array_rand($statusKehilangan)],
                'created_at' => $tglKehilangan,
                'updated_at' => Carbon::now()
            ];
        }
        foreach (array_chunk($kehilanganData, 50) as $chunk) {
            DB::table('laporan_kehilangan')->insert($chunk);
        }

        // 5. Data UMKM & Produk
        $bidangUmkm = ['kuliner', 'fashion', 'agribisnis', 'jasa', 'teknologi dan digital'];
        
        for ($i = 1; $i <= 60; $i++) {
            $idUmkm = DB::table('umkm')->insertGetId([
                'id_pengguna' => $idPengguna,
                'nama_umkm' => 'UMKM Dummy ' . $i,
                'deskripsi_umkm' => 'Deskripsi usaha UMKM ' . $i,
                'bidang_umkm' => $bidangUmkm[array_rand($bidangUmkm)],
                'alamat_umkm' => 'Alamat UMKM RT ' . rand(1, 5),
                'nomor_telepon_umkm' => '0822' . rand(10000000, 99999999),
                'status_umkm' => 'aktif',
                'created_at' => Carbon::now()->subDays(rand(0, 1800)),
                'updated_at' => Carbon::now()
            ]);

            // Tambahkan 3-6 produk untuk setiap UMKM
            $produkData = [];
            $maxProduk = rand(3, 6);
            for ($j = 1; $j <= $maxProduk; $j++) {
                $produkData[] = [
                    'id_umkm' => $idUmkm,
                    'nama_produk' => 'Produk ' . $j . ' dari UMKM ' . $i,
                    'deskripsi_produk' => 'Deskripsi singkat produk ' . $j,
                    'harga' => rand(1, 50) * 5000,
                    'status_produk' => 'aktif',
                    'created_at' => Carbon::now()->subDays(rand(1, 100)),
                    'updated_at' => Carbon::now()
                ];
            }
            DB::table('produk_umkm')->insert($produkData);
        }
    }
}
