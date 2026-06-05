<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('role')->insert([
            ['nama_role' => 'warga'],
            ['nama_role' => 'rt'],
            ['nama_role' => 'dukuh'],
        ]);
    }
}
