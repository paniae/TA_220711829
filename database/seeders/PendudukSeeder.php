<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PendudukSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $data = [];
        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'nomor_induk_kependudukan' => $faker->nik(),
                'nama_lengkap' => $faker->name(),
                'nomor_kk' => $faker->numerify('3404############'),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'tempat_lahir' => $faker->city(),
                'tanggal_lahir' => $faker->date('Y-m-d', '2000-01-01'),
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'pendidikan' => $faker->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2']),
                'jenis_pekerjaan' => $faker->jobTitle(),
                'alamat' => $faker->streetAddress(),
                'rt' => '0' . $faker->numberBetween(1, 9),
                'rw' => '0' . $faker->numberBetween(1, 5),
                'kecamatan' => 'Depok',
                'desa_kelurahan' => 'Caturtunggal',
                'kabupaten_kota' => 'Sleman',
                'provinsi' => 'DIY',
                'status_perkawinan' => $faker->randomElement(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']),
                'status_penduduk' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('penduduk')->insert($data);
    }
}
