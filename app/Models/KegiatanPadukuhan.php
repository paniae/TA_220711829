<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanPadukuhan extends Model
{
    protected $table = 'kegiatan_padukuhan';
    protected $primaryKey = 'id_kegiatan';

    protected $fillable = [
        'id_pengguna',
        'nama_kegiatan',
        'tgl_waktu_pelaksanaan',
        'waktu_selesai',
        'jenis_kegiatan',
        'status_kegiatan',
        'kategori',
        'dana_dikeluarkan',
        'lokasi',
        'deskripsi_kegiatan',
        'poster_kegiatan'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function dokumentasi()
    {
        return $this->hasMany(DokumentasiKegiatan::class, 'id_kegiatan');
    }
}