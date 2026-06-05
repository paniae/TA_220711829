<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            AksesSeeder::class,
            RoleAksesSeeder::class,
            PenggunaSeeder::class,
            PendudukSeeder::class,
            UmkmSeeder::class,
            ProdukMasterSeeder::class,
            ProdukUmkmSeeder::class,
            ProfilPadukuhanSeeder::class,
            KontakPadukuhanSeeder::class,
            KegiatanPadukuhanSeeder::class,
            LaporanKehilanganSeeder::class,
            PengaduanSeeder::class,
        ]);
    }
}
