<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;

    protected $table = 'jenis_surats';

    protected $fillable = [
        'nama_surat',
        'kode_surat',
        'template',
        'keterangan',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relationships
    public function pengajuan_surat()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getFormattedKodeAttribute()
    {
        return $this->kode_surat . ' - ' . $this->nama_surat;
    }
}
