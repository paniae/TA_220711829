<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Akses;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id_role';

    protected $fillable = ['nama_role'];

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'id_role');
    }

    public function akses()
    {
        return $this->belongsToMany(Akses::class, 'role_akses', 'id_role', 'id_akses');
    }
}