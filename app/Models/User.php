<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nik',
        'no_kk',
        'alamat',
        'rw',
        'rt',
        'no_tlp',
        'status_penduduk',
        'foto_profil',
        'foto_kk',
        'is_active',
        'is_pending',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'nik', 'nik');
    }

    public function pengajuan_surat()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public function informasi_kelurahan()
    {
        return $this->hasMany(InformasiKelurahan::class, 'dibuat_oleh');
    }

    public function surat_diproses()
    {
        return $this->hasMany(PengajuanSurat::class, 'diproses_oleh');
    }

    // Accessors
    public function getFotoProfilUrlAttribute()
    {
        return $this->foto_profil ? asset('storage/profil/' . $this->foto_profil) : asset('img/default-avatar.png');
    }

    public function getFotoKkUrlAttribute()
    {
        return $this->foto_kk ? asset('storage/' . $this->foto_kk) : null;
    }

    public function getRoleNameAttribute()
    {
        return $this->roles->first()->name ?? 'No Role';
    }

    // Helper methods for roles
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isMember()
    {
        return $this->hasRole('user');
    }

    public function isLurah()
    {
        return $this->hasRole('lurah');
    }

    public function isPetugas()
    {
        return $this->hasRole('petugas');
    }

    public function canValidate()
    {
        return $this->hasRole(['admin', 'lurah']);
    }

    public function canManagePenduduk()
    {
        return $this->hasRole(['admin', 'petugas']);
    }

    public function canManageInformasi()
    {
        return $this->hasRole(['admin', 'petugas']);
    }
}
