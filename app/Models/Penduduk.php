<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';

    protected $fillable = [
        'nik',
        'no_kk',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'rt',
        'rw',
        'no_tlp',
        'foto_kk',
        'agama',
        'jenis_kelamin',
        'status_perkawinan',
        'pekerjaan',
        'status_penduduk'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    // Relationships
    public function user()
    {
        return $this->hasOne(User::class, 'nik', 'nik');
    }

    public function pengajuan_surat()
    {
        return $this->hasMany(PengajuanSurat::class, 'nik', 'nik');
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'nik', 'nik');
    }

    // Accessors
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age;
    }

    public function getFullNameAttribute()
    {
        return $this->nama_lengkap;
    }
}
