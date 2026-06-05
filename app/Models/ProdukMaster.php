<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukMaster extends Model
{
    protected $table = 'produk_master';
    
    protected $primaryKey = 'id_produk_master';

    protected $fillable = [
        'id_produk_master',
        'nama_produk_master',
        'status_produk_master',
    ];
}
