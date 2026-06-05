<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarForum extends Model
{
    protected $table = 'komentar_forum';
    protected $primaryKey = 'id_komen';

    protected $fillable = [
        'id_laporan',
        'id_pengguna',
        'komentar',
        'tgl_waktu_komen',
        'foto_komen'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function laporan()
    {
        return $this->belongsTo(LaporanKehilangan::class, 'id_laporan');
    }
}