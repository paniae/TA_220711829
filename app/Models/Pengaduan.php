<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';
    protected $primaryKey = 'id_pengaduan';

    protected $fillable = [
        'id_pengguna',
        'isi_pengaduan',
        'status_pengaduan',
        'tgl_waktu_pengaduan'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function foto()
    {
        return $this->hasMany(FotoPengaduan::class, 'id_pengaduan');
    }
}