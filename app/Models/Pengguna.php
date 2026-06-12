<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'nik',
        'foto_profil',
        'status_pengguna',
        'alamat_pengguna',
        'nomor_telepon_pengguna',
        'email_pengguna',
        'jenis_kelamin_pengguna',
        'tanggal_lahir_pengguna',
        'id_role'
    ];

    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_pengguna');
    }

    public function laporanKehilangan()
    {
        return $this->hasMany(LaporanKehilangan::class, 'id_pengguna');
    }

    public function kegiatan()
    {
        return $this->hasMany(KegiatanPadukuhan::class, 'id_pengguna');
    }

    public function umkm()
    {
        return $this->hasMany(Umkm::class, 'id_pengguna');
    }

    public function hasAkses($kode)
    {
        return optional($this->role->akses)
            ->pluck('nama_akses')
            ->contains($kode);
    }

    public function isDukuh()
    {
        return strtolower($this->role->nama_role) === 'dukuh';
    }
}