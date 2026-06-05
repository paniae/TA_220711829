<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\KomentarForum;
use App\Models\Pengguna;

class LaporanKehilangan extends Model
{
    protected $table = 'laporan_kehilangan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_pengguna',
        'tanggal_hilang',
        'barang_hilang',
        'lokasi_hilang',
        'foto_barang',
        'tanggal_laporan',
        'deskripsi_laporan',
        'status_kehilangan'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function komentar()
    {
        return $this->hasMany(KomentarForum::class, 'id_laporan');
    }
}