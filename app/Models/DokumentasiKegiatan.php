<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumentasiKegiatan extends Model
{
    protected $table = 'dokumentasi_kegiatan';
    protected $primaryKey = 'id_dokumentasi';

    protected $fillable = [
        'id_kegiatan',
        'tanggal_dokumentasi',
        'file_kegiatan',
        'deskripsi_dokumentasi'
    ];

    protected $casts = [
        'tanggal_dokumentasi' => 'date'
    ];

    public function kegiatan()
    {
        return $this->belongsTo(KegiatanPadukuhan::class, 'id_kegiatan');
    }
}