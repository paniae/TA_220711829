<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $table = 'umkm';
    protected $primaryKey = 'id_umkm';

    protected $fillable = [
        'id_pengguna',
        'nama_umkm',
        'alamat_umkm',
        'bidang_umkm',
        'foto_umkm',
        'status_umkm',
        'deskripsi_umkm',
        'nomor_telepon_umkm',
        'is_nomor_telepon_ditampilkan',
        'email_umkm'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function produk()
    {
        return $this->hasMany(ProdukUMKM::class, 'id_umkm');
    }
}