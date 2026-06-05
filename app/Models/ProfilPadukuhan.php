<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilPadukuhan extends Model
{
    protected $table = 'profil_padukuhan';
    protected $primaryKey = 'id_profil';

    protected $fillable = [
        'visi',
        'misi',
        'alamat_balai',
        'nama_padukuhan',
        'nama_kalurahan',
        'nama_kecamatan',
        'nama_kabupaten',
        'sejarah',
        'foto_balai',
        'foto_kebersamaan',
        'link_maps_balai',
        'logo_padukuhan',
        'jam_operasional'
    ];
}