<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProfilPadukuhan;

class ProfilPadukuhanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProfilPadukuhan::create([
            'visi' => 'Mewujudkan padukuhan yang mandiri, sejahtera, dan berdaya saing berbasis gotong royong.',
            
            'misi' => "1. Meningkatkan pelayanan kepada masyarakat.\n2. Mengembangkan potensi UMKM warga.\n3. Menjaga keamanan dan ketertiban lingkungan.\n4. Mendorong partisipasi aktif masyarakat dalam kegiatan sosial.",
            
            'alamat_balai' => 'Padukuhan Bruno II, Kalurahan Ngestirejo',
            'nama_padukuhan' => 'Bruno II',
            'nama_kalurahan' => 'Ngestirejo',
            'nama_kecamatan' => 'Tanjungsari',
            'nama_kabupaten' => 'Gunungkidul',

            'sejarah' => 'Padukuhan Bruno II merupakan salah satu padukuhan di Kalurahan Ngestirejo, Kapanewon Tanjungsari, Kabupaten Gunungkidul, yang secara historis berkembang bersama wilayah Tanjungsari sejak masa pembukaan hutan oleh Resi Wolo dari Keraton Surakarta sekitar tahun 1805. Nama Tanjungsari sendiri berasal dari banyaknya pohon tanjung yang tumbuh di kawasan tersebut pada masa awal pembukaan wilayah. Seiring perkembangan Desa Ngestirejo, terbentuklah beberapa padukuhan termasuk Bruno II yang hingga kini masih mempertahankan kehidupan masyarakat agraris khas kawasan karst Gunungkidul. Dalam kehidupan sosial dan budayanya, masyarakat Bruno II dikenal menjaga tradisi gotong royong, kenduri desa atau Rasulan, serta berbagai kesenian tradisional seperti jathilan dan wayang kulit yang menjadi bagian penting identitas budaya masyarakat setempat.',

            'foto_balai' => 'default_balai.jpg',
            'logo_padukuhan' => 'logo.png',
            'link_maps_balai' => 'https://maps.app.goo.gl/pVePXJ2v278iEg4u7',
            'jam_operasional' => 'Senin - Jumat, 08.00 - 15.00 WIB'
        ]);
    }
}
