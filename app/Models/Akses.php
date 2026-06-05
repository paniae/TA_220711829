<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akses extends Model
{
    protected $table = 'akses';
    protected $primaryKey = 'id_akses';

    protected $fillable = ['nama_akses', 'deskripsi_akses'];

    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_akses', 'id_akses', 'id_role');
    }
}