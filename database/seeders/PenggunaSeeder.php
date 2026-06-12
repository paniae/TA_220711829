<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengguna')->insert([
            [
                'nama' => 'Admin Dukuh',
                'username' => 'dukuh1',
                'nik' => '1234567890123456',
                'jenis_kelamin_pengguna' => 'Laki-laki',
                'nomor_telepon_pengguna' => '081234567890',
                'alamat_pengguna' => 'Jl. Dukuh',
                'email_pengguna' => 'dukuh@mail.com',
                'password' => Hash::make('password'),
                'status_pengguna' => 'aktif',
                'id_role' => 3
            ],
            [
                'nama' => 'Ketua RT',
                'username' => 'rt1234',
                'nik' => '6543210987654321',
                'jenis_kelamin_pengguna' => 'Laki-laki',
                'nomor_telepon_pengguna' => '081111111111',
                'alamat_pengguna' => 'Jl. RT',
                'email_pengguna' => 'rt@mail.com',
                'password' => Hash::make('password'),
                'status_pengguna' => 'aktif',
                'id_role' => 2
            ],
            [
                'nama' => 'Warga 1',
                'username' => 'warga1',
                'nik' => '1111111111111111',
                'jenis_kelamin_pengguna' => 'Perempuan',
                'nomor_telepon_pengguna' => '082222222222',
                'alamat_pengguna' => 'Jl. Warga',
                'email_pengguna' => 'warga@mail.com',
                'password' => Hash::make('password'),
                'status_pengguna' => 'aktif',
                'id_role' => 1
            ]
        ]);
    }
}
