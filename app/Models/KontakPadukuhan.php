<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontakPadukuhan extends Model
{
    protected $table = 'kontak_padukuhan';
    protected $primaryKey = 'id_kontak';

    protected $fillable = [
        'nomor_telepon',
        'email',
        'instagram',
        'status_kontak'
    ];
}