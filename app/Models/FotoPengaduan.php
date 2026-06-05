<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoPengaduan extends Model
{
    protected $table = 'foto_pengaduan';
    protected $primaryKey = 'id_foto_pengaduan';

    protected $fillable = ['id_pengaduan', 'foto_pengaduan'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan');
    }
}