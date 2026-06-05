<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukUmkm extends Model
{
    protected $table = 'produk_umkm';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_umkm',
        'id_produk_master',
        'nama_produk',
        'harga',
        'status_produk',
        'foto_produk',
        'deskripsi_produk'
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'id_umkm');
    }

    public function produkMaster()
    {
        return $this->belongsTo(ProdukMaster::class, 'id_produk_master', 'id_produk_master');
    }
}