<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $table = 'penduduk';
    protected $primaryKey = 'nomor_induk_kependudukan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nomor_induk_kependudukan',
        'nama_lengkap',
        'nomor_kk',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'jenis_pekerjaan',
        'alamat',
        'rt',
        'rw',
        'kecamatan',
        'desa_kelurahan',
        'kabupaten_kota',
        'provinsi',
        'status_perkawinan',
        'status_penduduk',
        'foto_penduduk',
        'id_pengguna'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}